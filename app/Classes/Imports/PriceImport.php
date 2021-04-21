<?php

namespace App\Classes\Imports;

use App\Jobs\ProcessImportPrice;
use App\Product;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class PriceImport
{
    private static $priceFromAPI;

    public static function addToQueue($ids = null)
    {
        $products = isset($ids)
            ? Product::where('details->published', 1)->whereIn('details->sku', $ids)->get()
            : Product::where('details->published', 1)->get();

        $jobId = null;

        foreach ($products as $product) {
            //$id = ProcessImportPrice::dispatch($product->getDetails('sku'))->onQueue('priceImport');

            $job = (new ProcessImportPrice($product->getDetails('sku')))->onQueue('priceImport');
            //$jobId = dispatch($job);
            $jobId = app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
        }

        Cache::put('lastIdPriceImport', $jobId);
    }

    public static function import($prices)
    {
        try {

            foreach ($prices as $sku => $item) {
                if ($item['price'] != 'Недоступно') {
                    Product::where('details->sku', $item['sku'])->update([
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

    public static function importQueue($sku)
    {
        $product = [$sku];

        if (empty(self::$priceFromAPI)) {
            $productSku = Product::get()->keyBy('sku')->keys()->toArray();
            self::$priceFromAPI = PriceImport::pricesApi($productSku);
        }

        $productSingle = [];

        if (isset(self::$priceFromAPI[$sku])) {
            $productSingle[$sku] = self::$priceFromAPI[$sku];
        }

        PriceImport::import($productSingle);
    }

    public static function pricesApi($productSku)
    {
        $client = new Client();
        $res = $client->request('POST', 'https://b2b-sandi.com.ua/api/price-center', [
            'form_params' => [
                'action' => 'get_ir_prices',
                'sku_list' => $productSku,
            ]
        ]);

        $prices = json_decode($res->getBody(), true);

        return $prices;
    }
}
