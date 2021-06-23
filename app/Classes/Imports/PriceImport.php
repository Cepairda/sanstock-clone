<?php

namespace App\Classes\Imports;

use App\Classes\TelegramBot;
use Exception;

use App\Jobs\ProcessImportPrice;
use App\Product;
use App\ProductSort;
use GuzzleHttp\Client;

class PriceImport
{
    public const DEFAULT_API_URL = 'https://b2b-sandi.com.ua/api/products?token=368dbc0bf4008db706576eb624e14abf&only_defectives=1';

    /**
     * @param int|null $ids
     *
     * @return void
     */
    public static function addToQueue(TelegramBot $bot, int $ids = null) : void
    {
        try {
            $products = isset($ids)
                ? Product::whereIn('details->sku', $ids)->get()
                : Product::get();
            $productsCount = $products->count();

            $tenPartJsonDate = $products->chunk(25);

            foreach ($tenPartJsonDate as $key => $products) {
                $skuArray = [];

                foreach ($products as $sku => $product) {
                    $skuArray[] = $product->getDetails('sku');
                }

                ProcessImportPrice::dispatch($skuArray)->onQueue('priceImport');
            }

            $message = "Добавлено в очередь обновление цен и остатков для {$productsCount} товаров";
        } catch (Exception $e) {
            $message = "PriceImport. Ошибка: {$e->getMessage()}";
        } finally {
            $bot->sendSubscribes('sendMessage', $message);
        }
    }

    /**
     * @param array $jsonData Products from API
     * @param array|null $skuArray SKU products from DB
     * @return void
     */
    public static function import(array $jsonData, array $skuArray = null) : void
    {
        //try {
            $skuExistsAPI = [];

            foreach ($jsonData['data'] as $sku => [
                'main' => [
                    //'sku' => $sku,
                    'sku' => $sdCode,
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'balance' => $balance,
                    'defective_attributes' => [
                        'grade' => $grade,
                    ],
                ]
            ]) {
                $skuExistsAPI[] = $sku;

                self::updateBalance($sku, $balance);
                self::updatePrice($sdCode, $grade, $price, $oldPrice);
            }

            $missingSkuInApi = array_diff($skuArray, $skuExistsAPI);

            foreach ($missingSkuInApi as $sku) {
                self::updateBalance($sku, 0);
            }


        //} catch (\Exception $e) {

        //}
    }

    protected static function updateBalance($sku, $balance)
    {
        Product::where('details->sku', $sku)->update([
            'details->balance' => $balance
        ]);
    }

    protected static function updatePrice($sdCode, $grade, $price, $oldPrice)
    {
        ProductSort::where([['details->sd_code', $sdCode], ['details->grade', $grade]])->update([
            'details->price' => ceil($price),
            'details->old_price' => ceil($oldPrice),
        ]);
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

        PriceImport::import($dataJson, $skuArray);

        /**
         * Use capture to restrict requests to the server
         */
        usleep(50_000);
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
