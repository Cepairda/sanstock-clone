<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Exports\ProductWithDataExport;
use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Classes\Imports\ProductWithDataImport;
use App\Product;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use isResource;

    public function __construct(Product $product)
    {
        $this->resource = $product;
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
        try {
            $sku = $request->post('sku');

            $productSku = !empty($sku)
                ? Product::whereIn('details->sku', $sku)->get()->keyBy('sku')->keys()->toArray()
                : Product::get()->keyBy('sku')->keys()->toArray();

            //dd($productSku);

            $client = new Client();
            $res = $client->request('POST', 'https://b2b-sandi.com.ua/api/price-center', [
                'form_params' => [
                    'action' => 'get_ir_prices',
                    'sku_list' => $productSku,
                ]
            ]);
            $prices = json_decode($res->getBody(), true);

            $t['start'] = \Carbon\Carbon::now()->format('H:i:s');

            foreach ($prices as $sku => $item) {
                if ($item['price'] != 'Недоступно') {
                    Product::where('details->sku', $sku)->update([
                        'details->price' => $item['discount_price'] ?? $item['price'],
                        'details->price_updated_at' => Carbon::now(),
                        'details->old_price' => isset($item['discount_price']) ? $item['price'] : null
                    ]);
                }
            }

            $t['end'] = \Carbon\Carbon::now()->format('H:i:s');

            dd($t);

            //return redirect()->back();
        } catch (\Exception $e) {

        }
    }

    public function createSearchString() {
        $products = $this->resource
            ->select('id', 'details', 'ua.data as ua_name', 'ru.data as ru_name')
            ->join('resource_localizations as ua', function($q) {
                $q->on('ua.resource_id', '=', 'resources.id')
                    ->where('ua.locale', 'uk');
            })
            ->join('resource_localizations as ru', function($q) {
                $q->on('ru.resource_id', '=', 'resources.id')
                    ->where('ru.locale', 'ru');
            })->get();

        foreach ($products as $product) {
            Product::where('id', $product->id)->update([
                'search_string' =>
                    (json_decode($product->ua_name, 1))['name'] . ' ' .
                    (json_decode($product->ru_name, 1))['name'] . ' ' .
                    $product->details['sku']
            ]);
        }
    }
}
