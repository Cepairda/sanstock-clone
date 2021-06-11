<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Product;
use App\ProductSort;
use Illuminate\Support\Facades\Request;

class SearchController extends Controller
{
    public function search()
    {
        $productsSort = ProductSort::joinLocalization()->withProductGroup()->where('details->published', 0)
            ->where(function ($query) {
                foreach (explode(' ', request()->get('query')) as $value) {
                    $query->orWhere('search_string', 'LIKE', '%' . $value . '%');
                }
            })->paginate()->appends(Request::except('page'));

        if ($productsSort->total() < 0) {
            dd(55);
            $productsSdCode = Product::where('details->sku', 'LIKE', '%' . request()->get('query') . '%')->get()->pluck('details->sd_code');
            $productsSort = ProductSort::joinLocalization()->withProductGroup()->where('details->published', 0)
                ->whereIn('details->sd_code', $productsSdCode)->paginate()->appends(Request::except('page'));
        }





        $productsSort = ProductSort::joinLocalization()->withProductGroup()->where('details->published', 0)
            ->where(function ($query) {
                foreach (explode(' ', request()->get('query')) as $value) {
                    $query->orWhere('search_string', 'LIKE', '%' . $value . '%');
                }
            })
            ->paginate()
            ->appends(Request::except('page'));

        //if ($productsSort->isEmpty()) {
            $productsSdCode = Product::where('details->sku', 'LIKE', '%' . request()->get('query') . '%')->get()->pluck('details->grade', 'details->sd_code');
            $productsSortByBarCode = collect([]);

            if ($productsSdCode->isNotEmpty()) {
                $productsSortByBarCode = ProductSort::joinLocalization()->withProductGroup()->where('details->published', 0);
                $productsSortByBarCode = $productsSortByBarCode->where(function ($query) use ($productsSdCode) {
                    foreach ($productsSdCode as $sdCode => $sort) {
                        $query->orWhere([['details->grade', $sort], ['details->sd_code', $sdCode]]);
                    }
                })
                ->paginate()
                ->appends(Request::except('page'));
            }
        //}

        $productsSort = $productsSort->merge($productsSortByBarCode);

        return view('site.search.show', [
            'productsSort' => $productsSort,
            'searchQuery' => request()->get('query'),
        ]);
/*
        return view('site.search.show', [
            'productsSort' => ProductSort::joinLocalization()->withProductGroup()->where('details->published', 0)
                ->where(function ($query) {
                    foreach (explode(' ', request()->get('query')) as $value) {
                        $query->orWhere('search_string', 'LIKE', '%' . $value . '%');
                    }
                })->paginate()->appends(Request::except('page')),
            'searchQuery' => request()->get('query'),
        ]);*/
    }

}
