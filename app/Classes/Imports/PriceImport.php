<?php

namespace App\Classes\Imports;

use App\Jobs\ProcessImportPrice;
use App\Product;
use GuzzleHttp\Client;

class PriceImport
{
    private const DEFAULT_API_URL = 'http://94.131.241.126/api/products?token=368dbc0bf4008db706576eb624e14abf&only_defectives=1';

    /**
     * @param int|null $ids
     *
     * @return void
     */
    public static function addToQueue( int $ids = null) : void
    {
        $products = isset($ids)
            ? Product::whereIn('details->sku', $ids)->get()
            : Product::get();

        $tenPartJsonDate = $products->chunk(10);

        foreach ($tenPartJsonDate as $key => $products) {
            $skuArray = [];

            foreach ($products as $sku => $product) {
                $skuArray[] = $product->getDetails('sku');
            }

            ProcessImportPrice::dispatch($skuArray)->onQueue('priceImport');
        }
    }

    /**
     * @param array $jsonData
     *
     * @return void
     */
    public static function import(array $jsonData) : void
    {
        try {
            foreach ($jsonData['data'] as $sku => [
                     'main' => [
                     //'sku' => $sku,
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

    /**
     * @param array $skuArray
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function importQueue(array $skuArray) : void
    {
        $skuStr = implode(',', $skuArray);
        $apiUrl = self::DEFAULT_API_URL . "&sku_in={$skuStr}";
        $dataJson = PriceImport::pricesApi($apiUrl);

        PriceImport::import($dataJson);
    }

    /**
     * @param string $apiUrl
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function pricesApi(string $apiUrl) : array
    {
        $client = new Client();
        $res = $client->request('GET', $apiUrl);
        $prices = json_decode($res->getBody(), true);

        return $prices;
    }
}
