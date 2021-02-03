<?php

namespace App\Classes\Imports;

use App\Product;
use Carbon\Carbon;
use GuzzleHttp\Client;

class PriceImport
{
    public static function import($productSku)
    {
        try {
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
                        'details->price' => $item['discount_price'] ?? $item['price'],
                        'details->price_updated_at' => Carbon::now(),
                        'details->old_price' => isset($item['discount_price']) ? $item['price'] : null
                    ]);
                }
            }

            //return redirect()->back();
        } catch (\Exception $e) {

        }
    }
}
