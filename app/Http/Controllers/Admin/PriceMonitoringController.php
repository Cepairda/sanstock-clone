<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Classes\TelegramBot;
use App\Http\Controllers\Admin\Resource\isResource;
use App\Partner;
use App\PartnerUrl;
use App\Product;
use App\Resource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use LaravelLocalization;

class PriceMonitoringController
{
    private $monitoringData = [];

    private $partners = [];
    protected $info;

    /**
     * Мониторинг ценовой политики по api
     */
    public function getMonitoringListByApi() {

        $partners = $this->getPartners();

        $brands = [["name" => "Lidz"]];

        $response = $this->sentRequest($brands, $partners);

        $sdList = $this->parseResponseByApi(json_decode($response, true ), new TelegramBot());

        $skuList = $this->getProductIdBySdCode($sdList);

        $products = $this->getProducts();


        $this->createPartnerUrlToProducts($products, $skuList, $this->monitoringData);
    }

    /**
     * Отправка запроса на получение данных от z-price
     * @param $brands
     * @param $partners
     * @return bool|string
     */
    public function sentRequest($brands, $partners) {

        $start = time() ;

        $url = 'http://api.z-price.com/Report/';

        $post_fields = [
            "Sample" => "ALL",
            "Type" => "JSON",
            "ForAllMyCompanies" => false,
            "options" => [
                "brands" => $brands,
                "stores" => $partners
            ]
        ];

      $post_fields = json_encode($post_fields);

        $curl = curl_init();
        curl_setopt_array($curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_POST => TRUE,
                CURLOPT_POSTFIELDS => $post_fields,
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT => 10000,
                CURLOPT_HTTPHEADER => array(
                    'apiKey: ' . config('app.price_monitoring_api_key'),
                    'Content-Type: application/json'
                )
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $this->info = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if($this->info !== 200) Log::info('[ API ] Время запроса: ' . (time() - $start) . 'с.; Код ответа: ' . $this->info);

//        var_dump('Время работы скрипта: ' . (time() - $start));
//        var_dump('Код ответа: ' . $info);
//        var_dump('Ответ:');
        //var_dump($response);
        if($err) {
            return false;
        }

        return $response;
    }

    /**
     * Получаем sku товаров
     * @param $sdArr
     * @return false|mixed
     */
    public function getProductIdBySdCode($sdArr) {

        $start = time() ;

        $url = 'https://b2b-sandi.com.ua/api/sd-code-to-sku';

        $post_fields = [
            "sd_codes" => $sdArr
        ];

        $post_fields = json_encode($post_fields);

        $curl = curl_init();
        curl_setopt_array($curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_POST => TRUE,
                CURLOPT_POSTFIELDS => $post_fields,
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT => 1000,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                )
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $info = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

//        var_dump('Время работы скрипта: ' . (time() - $start));
//        var_dump('Код ответа: ' . $info);
//        var_dump('Ответ:');

        if($err) {
            return false;
        }

        return json_decode($response, true);
    }

    /**
     * Проверка ссылок партнеров
     * @return bool|string
     */
    public function checkPartnerUrl() {

        $start = time() ;

        $url = "https://kranok.ua/ua/lidzltsb8080sathighfb";

        $curl = curl_init();
        curl_setopt_array($curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT => 1000,
            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $info = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

//        var_dump('Время работы скрипта: ' . (time() - $start));
//        var_dump('Код ответа: ' . $info);
//        var_dump('Ответ:');

        if($err) {
            return false;
        }

        return $response;
    }

    /**
     * Получаем список партнеров из базы
     * @return array
     */
    public function getPartners() {

        $partnersData = DB::table('resources')->select('id', 'details')->where('type', 'App\Partner')->get();

        $partners = [];

        foreach ($partnersData as $partner):

            $partnerArr = [];

            $partnerArr["name"] = json_decode($partner->details)->host;

            $partners[] = $partnerArr;

            $this->partners[$partner->id] = $partnerArr["name"];

        endforeach;

        return $partners;
    }

    /**
     * Парсим ответ api
     * @param $response
     * @return array
     */
    public function parseResponseByApi($response, TelegramBot $bot) {

        $sdList = [];

        if(is_array($response)):

            foreach($response as $item):

                $sdList[] = $item["ClientCode"];

                $this->monitoringData[$item["ClientCode"]] = $item;

            endforeach;
        else:
            $bot->sendSubscribes('sendMessage', 'Z-price. Не пришёл ответ с API. Код ошибки: ' . $this->info . '.' . $response);
        endif;

        return $sdList;
    }

    /**
     * Получаем список товаров из базы
     * @return array
     */
    public function getProducts() {

        $productsData = DB::table('resources')->select('id', 'details')->where('type', 'App\Product')->get();

        $result = [];

        foreach($productsData as $product):

            $details = json_decode($product->details, true);

            $result[$details['sku']] = $details['price'];

        endforeach;

        return $result;
    }

    /**
     * Создание ссылок партнеров для товаров
     * @param $products
     * @param $skuList
     * @param $apiResponse
     */
    public function createPartnerUrlToProducts($products, $skuList, $apiResponse) {

        if(count($apiResponse) > 0) {

            PartnerUrl::where('type', 'App\\PartnerUrl')->forceDelete();

            foreach ($apiResponse as $item):

                $sd_code = $item['ClientCode'];

                if(isset($skuList[$sd_code]) && !empty($sku = $skuList[$sd_code]) &&
                    isset($products[$sku]) && !empty($product_price = (float)$products[$sku])) {

                    if(isset($item['Offers']))
                        $this->createPartnersUrl($item['Offers'], $products[$sku], $this->partners, $sku);
                }

            endforeach;
        }
    }

    /**
     * Запускаем проверку условий и создание ссылок партнеров для товара
     * @param $stores
     * @param $price
     * @param $partners
     * @param $sku
     * @return bool
     */
    public function createPartnersUrl($stores, $price, $partners, $sku) {

        foreach($stores as $store):

            if(in_array($store['SiteName'], $partners)) {

                if($store['SiteName'] === 'rozetka.com.ua' || ((float)$price - 5) <= (float)$store['Price'])
                    $this->createPartnerUrl($store['Href'], $sku, $store['SiteName'], array_search($store['SiteName'], $partners));

               // $str = 'Sku: ' . $sku . ', ИМ: ' . $store['SiteName'] . ' / Цена Lidz - ' . $price . ' :: Цена ИМ - '.  $store['Price'] ;
            }
            // else $str = '     ***** Sku: ' . $sku . ', ИМ: ' . $store['SiteName'] . ' / Цена Lidz - ' . $price . ' :: Цена ИМ - '.  $store['Price'] ;

            // echo $str . PHP_EOL;

        endforeach;

        return true;
    }

    /**
     * Создаем связь товара и ссылки партнера
     * @param $url
     * @param $sku
     * @param $partnerHost
     * @param $partnerId
     */
    public function createPartnerUrl($url, $sku, $partnerHost, $partnerId) {

        $partnerUrl = new PartnerUrl();

        $requestData = [];

        $requestData['details'] = [];

        $requestData['details']['host'] = $partnerHost;

        $requestData['details']['url'] = preg_replace('/(http:\/\/)|(https:\/\/)/', '', $url);

        $requestData['details']['sku'] = $sku;

        $requestData['details']['partner_id'] = $partnerId;

        $partnerUrl->setRequest($requestData);

        LaravelLocalization::setLocale('ru');

        $partnerUrl->storeOrUpdate();
    }
}
