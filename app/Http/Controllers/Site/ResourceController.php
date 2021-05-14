<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Product;
use App\ProductGroup;
use App\ProductSort;
use App\Resource;
use App\ResourceResource;
use App\Characteristic;
use App\CharacteristicValue;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Cache;
use App\HtmlBlock;

class ResourceController extends Controller
{
    public function getResource($slug, array $parameters = null)
    {
        $resource = Resource::withoutGlobalScopes()
            ->where('slug', $slug)
            ->where('deleted_at', null)
            ->firstOrFail();
        $originalType = class_basename($resource->type);
        $type = Str::snake($originalType);
        $productsDefectiveAttributes = [];

        switch ($type) {
            case 'product_group':
                $sortGet = $_GET['sort'] ?? null;

                $data = [
                    'productGroup' => $resource->type::joinLocalization()
                        ->withCharacteristics()
                        ->whereId($resource->id)
                        //->where('details->published', 1)
                        ->withCategory()
                        ->withRelateProducts()
                        ->withComments()
                        ->withReviews()
                        ->withPartnerUrl()
                        ->firstOrFail(),
                ];
                $data['additional'] = temp_additional($data['productGroup']->sdCode);
                $productsSort = [];
                $sortFromDb = null;

                foreach ($data['productGroup']->productsSort as $productSort) {
                    /*$sortFromDb = isset($sortFromDb)
                        ? ($productSort->grade < $sortFromDb
                            ? $productSort->grade
                            : $sortFromDb)
                        : $productSort->grade;*/
                    //dd($productSort->products[0]["sku"]);
                    //dd();
                    foreach($productSort->products as $productModel):
                        $products = Product::joinLocalization()->withCharacteristics()->whereIn('details->sku', [$productModel["sku"]])->get();
                        $productsDefectiveAttributes[$productModel["sku"]] = $products[0]->data['defective_attributes'];
                    endforeach;
                    $productsSort[$productSort->grade] = $productSort;
                }

                $sort = isset($productsSort[$sortGet]) ? $sortGet : min(array_keys($productsSort));

                $data['productsSort'] = $productsSort;
                $data['productsDefectiveAttributes'] = $productsDefectiveAttributes;
                $data['sort'] = $sort;

                //dd($data['product']['data']);

                break;
            case 'category':
                $category = $resource->type::joinLocalization()->withAncestors()->withDescendants()->whereId($resource->id)->firstOrFail();
                //$products = ProductGroup::where('details->category_id', $category->getDetails('ref'))->where('details->price', '>' , 0)->get()->keyBy('id')->keys();
                //$productGroup = ProductGroup::where('details->category_id', $category->getDetails('ref'))->firstOrFail();
                $productGroup = ProductGroup::where('details->category_id', $category->getDetails('ref'))->get()->keyBy('details->sd_code')->keys();
                $productGroupKeys = ProductGroup::where('details->category_id', $category->getDetails('ref'))->get()->keyBy('id')->keys();
                $productsSort = ProductSort::whereIn('details->sd_code', $productGroup)->get()->keyBy('id')->keys();
                $productsTotal = $productsSort->count();

                $characteristics = isset($category->characteristic_group[0])
                    ? $category->characteristic_group[0]->getDetails('characteristics')
                    : null;

                $characteristicIds = null;

                if (isset($characteristics)) {
                    $characteristicIds = [];

                    foreach ($characteristics as $id => $characteristic) {
                        if (isset($characteristic['filter']))
                            $characteristicIds[] = $id;
                    }
                }

                $characteristicValueIds = ResourceResource::whereIn('resource_id', $productGroupKeys)
                    ->where('relation_type', 'App\CharacteristicValue')
                    ->get()
                    ->keyBy('relation_id')
                    ->keys();
                $characteristicsValue = CharacteristicValue::joinLocalization()
                    ->whereCharacteristicIsFilter($characteristicIds)
                    ->whereIn('id', $characteristicValueIds)->get();
                $valuesForView = [];

                foreach ($characteristicsValue as $value) {
                    /*if (!isset($valuesForView[$value->getDetails('characteristic_id')])) {
                        $valuesForView[$value->attribute_id] = [];
                        $a = $value->attribute_id;
                    }*/

                    $valuesForView[$value->getDetails('characteristic_id')][] = $value;
                }

                $characteristicsIds = array_keys($valuesForView);

                $productsSort = ProductSort::joinLocalization()
                    ->withProductGroup()
                    ->withIcons()
                    ->whereIn('id', $productsSort)
                    ->withCategory();

                $mixMaxPriceQuery = (clone $productsSort)->selectRaw("MIN(CAST(JSON_EXTRACT(`details`, '$.price') AS FLOAT)) AS minPrice, MAX(CAST(JSON_EXTRACT(`details`, '$.price') AS FLOAT)) AS maxPrice")->first();
                $minPrice = $mixMaxPriceQuery->minPrice;
                $maxPrice = $mixMaxPriceQuery->maxPrice;

                $productsSort = $productsSort->selectRaw('*, CAST(JSON_EXTRACT(`details`, \'$.price\') AS FLOAT) as price');

                if (Request::has('minPrice') && Request::has('maxPrice')) {
                    $minPriceSelect = Request::input('minPrice');
                    $maxPriceSelect = Request::input('maxPrice');
                    $productsSort = $productsSort->where('details->price', '>=', +$minPriceSelect)->where('details->price', '<=', +$maxPriceSelect);
                }

                if (Request::has('filter')) {
                    $filters = Request::input('filter');
                    $characteristicsV = $filters;

                    foreach ($characteristicsV as $characteristicId => $filters) {
                        $fids = $filters;

                        $alias = 'rr' . $characteristicId;

                        $productsSort->join('resource_resource as ' . $alias, function ($q) use ($alias, $fids) {
                            $q->on('resources.id', '=', $alias . '.resource_id')
                                ->whereIn($alias . '.relation_id', $fids);
                        });
                    }
                }

                if (Request::has('name')) {
                    $sortName = Request::input('name') == 'up' ? 'ASC' : 'DESC';
                    $productsSort = $productsSort->orderBy('data->name', $sortName);
                }

                if (Request::has('price')) {
                    $sortPrice = Request::input('price') == 'up' ? 'ASC' : 'DESC';
                    $productsSort = $productsSort->orderBy('price', $sortPrice);
                }

                $productsSort = $productsSort->paginate(21)->appends(Request::except('page'));

                $showMore = null;

                $pageNumber = $productsSort->currentPage();


                if ($pageNumber < $productsSort->lastPage()) {
                    $showMore = [
                        'slug' => $slug,
                        'page' => ($pageNumber + 1)
                    ];

                    //dd($showMore);
                }

                if (isset($parameters['showMore'])) {
                    return [
                        'products' => $productsSort,
                        'show_more' => $showMore,
                    ];
                }

                $data = [
                    'category' => $category,
                    'productsSort' => $productsSort,
                    'productsDefectiveAttributes' => $productsDefectiveAttributes,
                    'productsTotal' => $productsTotal,
                    'minPrice' => $minPrice,
                    'maxPrice' => $maxPrice,
                    'minPriceSelect' => $minPriceSelect ?? $minPrice,
                    'maxPriceSelect' => $maxPriceSelect ?? $maxPrice,
                    'characteristics' => Characteristic::joinLocalization()->whereIn('id', $characteristicsIds)->get(),
                    'valuesForView' => $valuesForView,
                    'showMore' => $showMore,
                ];

                break;
            case 'page':
                $data = [
                    'page' => $resource->type::joinLocalization()->whereId($resource->id)->first()
                ];
                break;
            default:
                $data = [
                    'resource' => $resource->type::joinLocalization()->whereId($resource->id)->first()
                ];
        }
// dd($type);

//        return Cache::remember('resource_' . $resource->id, 3600, function() use ($type, $data){
//            return view('site.' . $type . '.show', $data)->render();
//        });

        //return HtmlBlock::replaceShortCode(view('site.' . $type . '.show', $data)->render());
        return view('site.' . $type . '.show', $data);
    }

    public function showMore(\Illuminate\Http\Request $request)
    {
        $data = $this->getResource($request->input('slug'), ['page' => $request->input('page'), 'showMore' => true]);

        return response()->json([
            'products' => view('site.components.products', ['products' => $data['products']])->render(),
            'show_more' => $data['show_more']
        ], 200);
    }

    public function favorites()
    {
        $cookie = !empty($_COOKIE['favorites']) ? $_COOKIE['favorites'] : null;

        $data['products'] = collect();
        if (isset($cookie)) {
            $favorites = explode(',', $cookie);
            $data['products'] = Product::joinLocalization()->whereIn('details->sku', $favorites)->paginate(12);
        }
        return view('site.product.favorites', $data);
    }
}
