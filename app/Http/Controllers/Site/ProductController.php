<?php

namespace App\Http\Controllers\Site;

use App\Classes\Imports\PriceImport;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search()
    {
        return view('site.product.components.search', [
            'products' => Product::joinLocalization()->where('details->published', 1)
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

        PriceImport::import($productSku);
    }
}
