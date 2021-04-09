<?php

namespace App\Classes\Imports;

use App\Brand;
use App\Characteristic;
use App\CharacteristicValue;
use App\Product;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use LaravelLocalization;
use App\Jobs\ProcessImportB2B;

class B2BImport
{
    private $token = '87cbacd82eca60a44f2abaa6d8dcf2d6a6368fd35e071f7c27d1cc5ca24486ca';
    private static $data;

    public function getDataJson($resource)
    {
        if (self::$data === null) {
            $client = new Client();
            $res = $client->request('GET', 'https://b2b-sandi.com.ua/api/content/' . $resource . '?token=' . $this->token);
            $this->setData(json_decode($res->getBody(), true));
        }

        return self::$data;
    }

    private function setData($data)
    {
        self::$data = $data;
    }

    public function firstOrCreateBrand()
    {
        $brand = Brand::where('details->ref', self::$data['brand']['ref'])->first();

        if (!isset($brand)) {
            $brand = new Brand();
            $name = trim(self::$data['brand']['description']);

            $brand->setRequest([
                'slug' => Str::slug(str_replace('/', '', $name)),
                'details' => ['ref' => self::$data['brand']['ref']],
                'data' => ['name' => $name]
            ]);

            LaravelLocalization::setLocale('ru');
            $brand->storeOrUpdate();
        }

        return $brand;
    }

    public function firstOrCreateProducts($brand = null)
    {
        foreach (self::$data['products'] as $productRef => $productData) {
            $this->product($brand->id, $productRef);
        }
    }

    public function updateOrCreateCharacteristics($characteristics)
    {
        $characteristicValueIds = [];

        foreach ($characteristics as $characteristic) {
            $characteristicDataName = mb_ucfirst(trim(mb_ereg_replace('/\s+/', ' ', mb_convert_encoding($characteristic['description_characteristic'], 'UTF-8'))));
            $characteristicValueDataValue = trim(mb_ereg_replace('/\s+/', ' ', mb_convert_encoding($characteristic['value'], 'UTF-8')));

            if (!empty($characteristicDataName) && !empty($characteristicValueDataValue)) {
                $characteristicDataNameUk = mb_ucfirst(trim(mb_ereg_replace('/\s+/', ' ', mb_convert_encoding($characteristic['description_characteristic_uk'], 'UTF-8'))));
                $characteristicId = $this->characteristic($characteristicDataName, $characteristicDataNameUk);

                $characteristicValueDataValueUk = trim(mb_ereg_replace('/\s+/', ' ', mb_convert_encoding($characteristic['value_uk'], 'UTF-8')));
                $characteristicValueId = $this->characteristicValue(
                    $characteristicId,
                    $characteristicValueDataValue,
                    $characteristicValueDataValueUk
                );

                array_push($characteristicValueIds, $characteristicValueId);
            }
        }

        return $characteristicValueIds;
    }

    protected function product($brandId, $productRef)
    {
        $product = Product::where('details->ref', $productRef)->first();

        if (!isset($product)) {
            $product = new Product();
            $productData = self::$data['products'][$productRef];
            $name = trim($productData['description']);
            $categoryName = (self::$data['categories'][$productData['category_ref']]['description'] ?? 'uncategorized');
            $slug = (Str::slug($categoryName) . '/' . Str::slug($name));

            $product->setRequest([
                'slug' => $slug,
                'details' => [
                    'ref' => $productRef,
                    'sku' => $productData['old_base_code'],
                    'brand_id' => $brandId ?? null,
                    'category_id' => null,
                    'published' => 0,
                    'enable_comments' => 1,
                    'enable_stars_comments' => 1,
                    'enable_reviews' => 1,
                    'enable_stars_reviews' => 1,
                ],
                'data' => ['name' => $name]
            ]);

            LaravelLocalization::setLocale('ru');
            $product->storeOrUpdate();
        }

        if (isset(self::$data['characteristics'][$productRef])) {
            $product->setRequest([
                'relations' => [
                    CharacteristicValue::class => $this->updateOrCreateCharacteristics(self::$data['characteristics'][$productRef])
                ]
            ]);
        }

        $product->updateRelations();
    }

    protected function characteristic($characteristicDataName): int
    {
        $c = Characteristic::where('data->name', $characteristicDataName)->joinLocalization('ru')->first();

        if (!isset($c)) {
            $c = new Characteristic();

            $c->setRequest([
                'data' => ['name' => $characteristicDataName]
            ]);

            LaravelLocalization::setLocale('ru');
            $c->storeOrUpdate();
        }

        if (!empty($characteristicDataNameUk)) {
            $c->setRequest([
                'details' => [
                    'is_filter' => 1,
                    'published' => 1,
                    'sort' => 0
                ],
                'data' => ['name' => $characteristicDataNameUk],
            ]);

            LaravelLocalization::setLocale('uk');
            $c->storeOrUpdate();
        }

        return $c->id;
    }

    protected function characteristicValue($characteristicId, $characteristicValueDataValue, $characteristicValueDataValueUk): int
    {
        $cV = CharacteristicValue::where('details->characteristic_id', $characteristicId)
            ->where('data->value', $characteristicValueDataValue)->joinLocalization('ru')->first();

        if (!isset($cV)) {
            $cV = new CharacteristicValue();

            $cV->setRequest([
                'details' => ['characteristic_id' => $characteristicId],
                'data' => ['value' => $characteristicValueDataValue]
            ]);

            LaravelLocalization::setLocale('ru');
            $cV->storeOrUpdate();
        }

        if (!empty($characteristicValueDataValueUk)) {
            $cV->setRequest([
                'details' => ['characteristic_id' => $characteristicId],
                'data' => ['value' => $characteristicValueDataValueUk]
            ]);

            LaravelLocalization::setLocale('uk');
            $cV->storeOrUpdate();
        }

        return $cV->id;
    }

    public function addToQueue()
    {
        $brand = $this->firstOrCreateBrand();

        foreach (self::$data['products'] as $productRef => $productData) {
            ProcessImportB2B::dispatch($brand->id, $productRef)->onQueue('b2bImport');
        }
    }

    public function importQueue($brandId, $productRef)
    {
        $this->product($brandId, $productRef);
    }
}
