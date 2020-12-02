<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Product;

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
}
