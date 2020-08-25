<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductWithDataExport;
use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
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

    public function importPrice(Request $request)
    {
        try {
            $sku = $request->post('sku');
            $productSku = !isset($sku)
                ? Product::select(['details->sku as sku'])->where('details->sku', $sku)->get()->keyBy('sku')->keys()->toArray()
                : Product::select(['details->sku as sku'])->get()->keyBy('sku')->keys()->toArray();
            $client = new Client();
            $res = $client->request('POST', 'https://b2b-sandi.com.ua/api/price-center', [
                'form_params' => [
                    'action' => 'get_ir_prices',
                    'sku_list' => $productSku,
                ]
            ]);
            $prices = json_decode($res->getBody(), true);

            foreach ($prices as $sku => $item) {
                if ($item['price'] != 'Недоступно') {
                    Product::where('details->sku', $sku)->update([
                        'details->price' => $item['price'],
                        'details->price_updated_at' => Carbon::now()
                    ]);
                }
            }

            return redirect()->back();
        } catch (\Exception $e) {

        }
    }
}
