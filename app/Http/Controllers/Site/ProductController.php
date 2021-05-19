<?php

namespace App\Http\Controllers\Site;

use App\Classes\Imports\PriceImport;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductSort;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search()
    {

        return view('site.components.header.liveSearch', [
            'products' => ProductSort::joinLocalization()->withProductGroup()->where('details->published', 0)
                ->where(function ($query) {
                    foreach (explode(' ', request()->get('query')) as $value) {
                        $query->orWhere('search_string', 'LIKE', '%' . $value . '%');
                    }
                })->get()
        ]);
    }

    public function updatePrice(Request $request)
    {
        $sku = $request->post('sku');
        $productSku = Product::whereIn('details->sku', $sku)->get()->keyBy('sku')->keys()->toArray();

        $prices = PriceImport::pricesApi($productSku);
        $newPrices = [];

        foreach ($productSku as $sku) {
            if (isset($prices[$sku])) {
                if ($prices[$sku]['price'] != 'Недоступно') {
                    $newPrices[$sku] = $prices[$sku];
                }
            }
        }

        PriceImport::import($newPrices);

        return $newPrices;
    }

    public function getFirstAdditional(Request $request)
    {
        $sku = $request->post('sku');
        //$additional = temp_additional($sku, true);
        $additionalPath = 'storage/product/' . $sku . '/300-' . $sku . '_1.jpg';

        if (file_exists($additionalPath)) {
            return response()->json(['additional' => [asset($additionalPath)]]);
        }

        return null;
    }
}
