<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\Request;

class SearchController extends Controller
{
    public function search()
    {
        return view('site.search.show', [
            'products' => Product::joinLocalization()->where('details->published', 1)
                ->where(function ($query) {
                    foreach (explode(' ', request()->get('query')) as $value) {
                        $query->orWhere('search_string', 'LIKE', '%' . $value . '%');
                    }
                })->paginate()->appends(Request::except('page')),
            'searchQuery' => request()->get('query'),
        ]);
    }

}
