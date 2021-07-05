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
                        ->withProductsSort()
                        ->withCategory()
                        ->firstOrFail(),
                ];
                $data['additional'] = temp_additional($data['productGroup']->sdCode);
                $productsSort = [];

                foreach ($data['productGroup']->productsSort as $productSort) {
                    $productsSort[$productSort->grade] = $productSort;
                }

                $productsSortKeys = array_keys($productsSort);
                $sortType = [0, 1, 2, 3];
                $firstExistSort = $productsSortKeys ? min($productsSortKeys) : null;
                $sort = isset($sortType[$sortGet]) ? $sortGet : $firstExistSort;


                $togglePrice = in_array($sort, $productsSortKeys);

                $data['productsSort'] = $productsSort;
                $data['sort'] = $sort;
                $data['firstExistSort'] = $firstExistSort;
                $data['togglePrice'] = $togglePrice;

                break;
            case 'category':
                $category = $resource->type::joinLocalization()->withAncestors()->withDescendants()->withChildren()->whereId($resource->id)->firstOrFail();
                $productGroupBase = ProductGroup::where('details->category_id', $category->getDetails('ref'))->get();
                $productGroup = $productGroupBase->keyBy('details->sd_code')->keys();
                $productGroupKeys = $productGroupBase->keyBy('id')->keys();
                $productsSort = ProductSort::whereIn('details->sd_code', $productGroup)->withNotShowProductsBalanceZero();
                $sortType = $productsSort->get()->keyBy('details->grade')->keys()->unique()->sort()->values();

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
                    if (!empty($value->value)) {
                        $valuesForView[$value->getDetails('characteristic_id')][] = $value;
                    }
                }

                /**
                 * Sorting Characteristics Values
                 */
                foreach ($valuesForView as $cId => &$cValues) {
                    //sort($cValues);
                    usort($cValues, function ($a, $b) {
                        $first = str_replace(',', '.', $a->value);
                        $second = str_replace(',', '.', $b->value);

                        if (is_numeric($first) && is_numeric($second)) {
                            return $first <=> $second;
                        }

                        return strcmp($a->value, $b->value);
                    });
                }

                $characteristicsIds = array_keys($valuesForView);

                $productsSort = $productsSort->joinLocalization()
                    ->withProductGroup()
                    ->withNotShowProductsBalanceZero();
                    //->withIcons()
                    //->withCategory();

                $productsTotal = $productsSort->count();

                $mixMaxPriceQuery = (clone $productsSort)->selectRaw("MIN(CAST(JSON_EXTRACT(`details`, '$.price') AS FLOAT)) AS minPrice, MAX(CAST(JSON_EXTRACT(`details`, '$.price') AS FLOAT)) AS maxPrice")->first();

                $minPrice = $mixMaxPriceQuery->minPrice;
                $maxPrice = $mixMaxPriceQuery->maxPrice;

                $productsSort = $productsSort->selectRaw('*, CAST(JSON_EXTRACT(`details`, \'$.price\') AS FLOAT) as price');

                if (Request::has('minPrice') && Request::has('maxPrice')) {
                    $minPriceSelect = Request::input('minPrice');
                    $maxPriceSelect = Request::input('maxPrice');
                    $productsSort = $productsSort->where('details->price', '>=', +$minPriceSelect)->where('details->price', '<=', +$maxPriceSelect);
                }

                if (Request::has('sort')) {
                    $chooseSortType = Request::input('sort');
                    $productsSort->whereIn('details->grade', $chooseSortType);
                }

                if (Request::has('filters')) {
                    $filters = Request::input('filters');
                    $characteristicsV = $filters;

                    $productGroupForFilter = ProductGroup::select();

                    foreach ($characteristicsV as $characteristicId => $filters) {
                        $fids = $filters;

                        $alias = 'rr' . $characteristicId;
                        $productGroupForFilter->join('resource_resource as ' . $alias, function ($q) use ($alias, $fids) {
                            $q->on('resources.id', '=', $alias . '.resource_id')
                                ->whereIn($alias . '.relation_id', $fids);
                        });
                    }

                    $productGroupSdCodes = $productGroupForFilter->get()
                        ->keyBy('details->sd_code')
                        ->keys();
                    $productsSort->whereIn('details->sd_code', $productGroupSdCodes);
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
                    'sortType' => $sortType,
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
