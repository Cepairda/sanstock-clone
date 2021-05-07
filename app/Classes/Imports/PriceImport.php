<?php

namespace App\Classes\Imports;

use App\Jobs\ProcessImportPrice;
use App\Product;
use GuzzleHttp\Client;

class PriceImport
{
    private const DEFAULT_API_URL = 'http://94.131.241.126/api/products?token=368dbc0bf4008db706576eb624e14abf&only_defectives=1';

    public static function addToQueue($ids = null)
    {
        $products = isset($ids)
            ? Product::whereIn('details->sku', $ids)->get()
            : Product::get();

        foreach ($products as $product) {
            ProcessImportPrice::dispatch($product->getDetails('sku'))->onQueue('priceImport');
        }
    }

    public static function import($jsonData)
    {
        try {
            foreach ($jsonData['data'] as [
                     'main' => [
                     'sku' => $sku,
                     'price' => $price,
                     'old_price' => $oldPrice,
                     'balance' => $balance
            ]
            ]) {
                Product::where('details->sku', $sku)->update([
                    'details->price' => $price,
                    'details->old_price' => $oldPrice,
                    'details->balance' => $balance
                ]);
            }
        } catch (\Exception $e) {

        }
    }

    public static function importQueue($sku)
    {
        $apiUrl = self::DEFAULT_API_URL . "&sku_in={$sku}";
        $dataJson = PriceImport::pricesApi($apiUrl);

        PriceImport::import($dataJson);
    }

    public static function pricesApi($apiUrl)
    {
        $client = new Client();
        $res = $client->request('GET', $apiUrl);
        $prices = json_decode($res->getBody(), true);

        return $prices;
    }
}
