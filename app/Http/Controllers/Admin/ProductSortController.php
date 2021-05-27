<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Exports\ProductWithDataExport;
use App\Classes\Imports\PriceImport;
use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Classes\Imports\ProductWithDataImport;
use App\Product;
use App\ProductSort;
use Illuminate\Http\Request;

class ProductSortController extends Controller
{
    use isResource;

    public function __construct(ProductSort $productSort)
    {
        $this->resource = $productSort;
    }

    public function export()
    {
        return (new ProductWithDataExport())->download();
    }

    public function import(Request $request)
    {
        (new ProductWithDataImport())->import($request->file('products'));
        $this->createSearchString();

        return redirect()->back();
    }

    public function importPrice(Request $request)
    {
        ini_set('default_socket_timeout', 10000);
        ini_set('memory_limit', -1);
        ini_set('max_input_time', -1);
        ini_set('max_execution_time', 10000);
        set_time_limit(0);

        PriceImport::addToQueue();
    }

    public function createSearchString() {
        $products = Product::select('id', 'details', 'ua.data as ua_name', 'ru.data as ru_name')
            ->join('resource_localizations as ua', function($q) {
                $q->on('ua.resource_id', '=', 'resources.id')
                    ->where('ua.locale', 'uk');
            })
            ->join('resource_localizations as ru', function($q) {
                $q->on('ru.resource_id', '=', 'resources.id')
                    ->where('ru.locale', 'ru');
            })->get();

        foreach ($products as $product) {
            $sdCode = $product->getDetails('sd_code');
            $uaName = (json_decode($product->ua_name, 1))['name'];
            $ruName = (json_decode($product->ru_name, 1))['name'];

            ProductSort::where('details->sd_code', $sdCode)->update([
                'search_string' =>
                    $uaName . ' ' .
                    $ruName . ' ' .
                    $sdCode
            ]);
        }
    }
}
