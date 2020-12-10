<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Product;
use App\Resource;
use App\ResourceResource;
use App\Characteristic;
use App\CharacteristicValue;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;

class ResourceController extends Controller
{
    public function getResource($slug)
    {
        $resource = Resource::withoutGlobalScopes()
            ->where('slug', $slug)
            ->where('deleted_at', null)
            ->firstOrFail();

        $type = Str::lower(class_basename($resource->type));

        switch ($type) {
            case 'product':
                $data = [
                    'product' => $resource->type::joinLocalization()
                        ->withCharacteristics()
                        ->whereId($resource->id)
                        ->where('details->published', 1)
                        ->withCategory()
                        ->first(),
                ];
                break;
            case 'category':
                $category = $resource->type::joinLocalization()->withAncestors()->withDescendants()->whereId($resource->id)->where('details->published', 1)->firstOrFail();
                $products = Product::whereExistsCategoryIds($category->id)->where('details->published', 1)->get()->keyBy('id')->keys();
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

                $characteristicValueIds = ResourceResource::whereIn('resource_id', $products)
                    ->where('relation_type', 'App\CharacteristicValue')
                    ->get()
                    ->keyBy('relation_id')
                    ->keys();
                $characteristicsValue = CharacteristicValue::joinLocalization()
                    ->whereCharacteristicIsFilter($characteristicIds)
                    ->whereIn('id', $characteristicValueIds)->get();

                $valuesForView = [];

                foreach ($characteristicsValue as $value) {
                    if (!isset($valuesForView[$value->getDetails('characteristic_id')])) {
                        $valuesForView[$value->attribute_id] = [];
                    }

                    $valuesForView[$value->getDetails('characteristic_id')][] = $value;
                }

                $characteristicsIds = array_keys($valuesForView);

                $products = Product::joinLocalization()->whereIn('id', $products);

                $mixMaxPriceQuery = (clone $products)->selectRaw("MIN(CAST(JSON_EXTRACT(`details`, '$.price') AS FLOAT)) AS minPrice, MAX(CAST(JSON_EXTRACT(`details`, '$.price') AS FLOAT)) AS maxPrice")->first();
                $minPrice = $mixMaxPriceQuery->minPrice;
                $maxPrice = $mixMaxPriceQuery->maxPrice;

                if (Request::has('minPrice') && Request::has('maxPrice')) {
                    $minPriceSelect = Request::input('minPrice');
                    $maxPriceSelect = Request::input('maxPrice');
                    $products = $products->where('details->price', '>=', +$minPriceSelect)->where('details->price', '<=', +$maxPriceSelect);
                }

                if (Request::has('filter')) {
                    $filters = Request::input('filter');
                    $characteristicsV = $filters;

                    foreach ($characteristicsV as $characteristicId => $filters) {
                        $fids = $filters;

                        $alias = 'rr' . $characteristicId;

                        $products->join('resource_resource as ' . $alias, function ($q) use ($alias, $fids) {
                            $q->on('resources.id', '=', $alias . '.resource_id')
                                ->whereIn($alias . '.relation_id', $fids);
                        });
                    }


                }

                $products = $products->paginate();

                $data = [
                    'category' => $category,
                    'products' => $products,
                    'minPrice' => $minPrice,
                    'maxPrice' => $maxPrice,
                    'minPriceSelect' => $minPriceSelect ?? $products->min('details->price'),
                    'maxPriceSelect' => $maxPriceSelect ?? $products->max('details->price'),
                    'characteristics' => Characteristic::joinLocalization()->whereIn('id', $characteristicsIds)->get(),
                    'valuesForView' => $valuesForView,
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
