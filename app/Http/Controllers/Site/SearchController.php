<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\ProductSort;
use Illuminate\Support\Facades\Request;

class SearchController extends Controller
{
    public function search()
    {
        return view('site.search.show', [
            'productsSort' => ProductSort::joinLocalization()->withProductGroup()->where('details->published', 0)
                ->where(function ($query) {
                    foreach (explode(' ', request()->get('query')) as $value) {
                        $query->orWhere('search_string', 'LIKE', '%' . $value . '%');
                    }
                })->paginate()->appends(Request::except('page')),
            'searchQuery' => request()->get('query'),
        ]);
    }

}
