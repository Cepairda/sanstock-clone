<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Product;
use Carbon\Carbon;
use GuzzleHttp\Client;
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
        try {
            $sku = $request->post('sku');

            $productSku = Product::whereIn('details->sku', $sku)->get()->keyBy('sku')->keys()->toArray();

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

            //return redirect()->back();
        } catch (\Exception $e) {

        }
    }
}
