<?php


namespace App\Http\Controllers\Admin;

//use App\Alias;
use App\Brand;
use App\Characteristic;
use App\CharacteristicValue;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
/*use App\Product;
use App\ProductCharacteristicValue;
use App\ProductData;
use Ixudra\Curl\Facades\Curl;
use LaravelLocalization;*/

use App\Product;
use App\Resource;
use App\ResourceResource;
use GuzzleHttp\Client;

class ImportController extends Controller
{
    private $token = '87cbacd82eca60a44f2abaa6d8dcf2d6a6368fd35e071f7c27d1cc5ca24486ca';

    public function __construct()
    {
        ini_set('default_socket_timeout', 10000);
        ini_set('memory_limit', -1);
        ini_set('max_input_time', -1);
        ini_set('max_execution_time', 10000);
        set_time_limit(0);
    }

    private function getData($resource)
    {
        $client = new Client();
        $res = $client->request('GET', 'https://b2b-sandi.com.ua/api/content/' . $resource . '?token=' . $this->token);

        return json_decode($res->getBody(), true);
    }

    public function updateOrCreate($brandRef = null)
    {
        //$data = $this->getData('brand/' . $brandRef);
        $data = $this->getData('brand/' . '462a44b3-920c-11e6-8148-00155db18262');

        $brand = $this->firstOrCreateBrand($data['brand']);

        $productRefs = Product::select('data->ref as ref')->joinLocalization()->where('data->brand_id', $brand->id)->get()->keyBy('ref')->keys();
        $this->firstOrCreateProducts($data['products'], $productRefs, null, $brand->id);
        $products = Product::select(['id', 'data->ref as ref'])->joinLocalization()->where('data->brand_id', $brand->id)->get()->keyBy('ref');
        $this->updateOrCreateCharacteristics($data['characteristics'], $products);
    }



    public function firstOrCreateBrand($brand = null)
    {
        $brandObj = new Brand();
        $brandFirst = $brandObj->joinLocalization()->where('data->ref', $brand['ref'])->first();

        if (!isset($brandFirst)) {
            $data = [
                'ref' => $brand['ref'],
                'name' => trim($brand['description'])
            ];

            $brandFirst = $brandObj->storeOrUpdateImport($data);
        }

        return $brandFirst;
    }

    public function firstOrCreateProducts($products, $productRefs, $categories, $brandId)
    {
        foreach ($products as $product) {
            if (!$productRefs->contains($product['ref'])) {
                $productDescription = trim($product['description']);

                $productObj = new Product();

                $data = [
                    'brand_id' => $brandId,
                    'category_id' => null,
                    'sku' => $product['old_base_code'],
                    'ref' => $product['ref'],
                    'name' => $productDescription
                ];

                $productObj->storeOrUpdateImport($data);
            }
        }
    }

    public function updateOrCreateCharacteristics($characteristics, $products)
    {
        $characteristicArray = [];
        $characteristicValueArray = [];

        DB::disableQueryLog();
        DB::beginTransaction();

        foreach ($characteristics as $productRef => $data) {

            if (isset($products[$productRef])) {
                ResourceResource::where('resource_id', $products[$productRef]->id)->delete();

                foreach ($data as $characteristic) {
                    $c = null;

                    $characteristicDataName = mb_ucfirst(trim(mb_ereg_replace('/\s+/', ' ', mb_convert_encoding($characteristic['description_characteristic'], 'UTF-8'))));
                    $characteristicValueDataValue = trim(mb_ereg_replace('/\s+/', ' ', mb_convert_encoding($characteristic['value'], 'UTF-8')));

                    if (!empty($characteristicDataName) && !empty($characteristicValueDataValue)) {
                        if (!array_key_exists($characteristicDataName, $characteristicArray)) {
                            $c = Characteristic::where('locale', 'uk')->where('data->name', $characteristicDataName)->joinLocalization()->first();

                        }

                        if (!isset($c) && !array_key_exists($characteristicDataName, $characteristicArray)) {
                            $c = new Characteristic();

                            $data = [
                                'name' => $characteristicDataName,
                            ];

                            $c->storeOrUpdateImport($data);

                            //echo $characteristicDataName . '<br>';

                            /*
                             *
                             * Вот тут ниже не ясно как сохранить locale UK
                             * Через метод up Resource::storeOrUpdate
                             *
                             */

                            /*if (!empty($characteristic['description_characteristic_uk']) && !empty($characteristic['value_uk'])) {
                                $characteristicDataNameUk = mb_ucfirst(trim(mb_ereg_replace('/\s+/', ' ', mb_convert_encoding($characteristic['description_characteristic_uk'], 'UTF-8'))));
                                CharacteristicData::create([
                                    'characteristic_id' => $c->id,
                                    'name' => $characteristicDataNameUk,
                                    'locale' => 'uk'
                                ]);
                            }*/
                        }

                        $cId = ($characteristicArray[$characteristicDataName] = $c->id ?? $characteristicArray[$characteristicDataName]);


                        /*
                         *
                         * Ниже если расскоментировать код,
                         * То импорт вместо 2-3 минут работает 10, и то не всегда работает
                         * Браузер выбивает ошибку типа - Не могу дождаться ответа
                         * Хотя смотрю в БД всё появляется вроде
                         *
                         */


                       /* $cV = CharacteristicValue::where('data->characteristic_id', $cId)->where('data->value', $characteristicValueDataValue)->joinLocalization()->first();

                        if (!isset($cV)) {
                            if ((!isset($characteristicValueArray[$cId][$characteristicValueDataValue]))) {

                                $c = new CharacteristicValue();
                                $data = [
                                    'name' => null,
                                    'characteristic_id' => $cId,
                                    'value' => $characteristicValueDataValue,
                                ];

                                $c->storeOrUpdateImport($data);

                                unset($c);

                                $characteristicValueArray[$cId][$characteristicValueDataValue] = true;
                            }
                        }*/


                        /*
                         *
                         *  Аналогично, как сохранять locale
                         *
                         */

                        /*if (!empty($characteristic['description_characteristic_uk']) && !empty($characteristic['value_uk'])) {
                            $characteristicValueDataValueUk = trim(mb_ereg_replace('/\s+/', ' ', mb_convert_encoding($characteristic['value_uk'], 'UTF-8')));
                            CharacteristicValueData::updateOrCreate([
                                'characteristic_value_id' => $cV->id,
                                'locale' => 'uk'
                            ], [
                                'value' => $characteristicValueDataValueUk,
                            ]);
                        }

                        ProductCharacteristicValue::updateOrCreate([
                            'product_id' => $products[$productRef]->id,
                            'characteristic_value_id' => $cV->id
                        ]);*/
                    }
                }

            }
        }
        DB::commit();
    }
}
