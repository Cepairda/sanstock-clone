<?php

namespace App\Classes\Imports;

use App\Brand;
use App\Category;
use App\Characteristic;
use App\CharacteristicValue;
use App\Product;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use LaravelLocalization;
use App\Jobs\ProcessImportB2B;
use App\Classes\Slug;

class StockB2BImport
{
    private $apiUrl = 'http://94.131.241.126/api/products?token=368dbc0bf4008db706576eb624e14abf&only_defectives=1';
    private static $data;

    private $categoryApiUrl = 'http://94.131.241.126/api/categories';

    public function getDataJson()
    {
        if (self::$data === null) {
            $client = new Client();
            $res = $client->request('GET', $this->apiUrl);
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

    public function parse()
    {
        $jsonData = self::$data;

        foreach ($jsonData['data'] as $sku => $dataProduct) {
            $main = $dataProduct['main'];
            $attributes = $dataProduct['attributes'];
            //$this->stockBrand($main['brand']['ref'], $main['brand']['name']);
            //$this->stockCategory($main['category']['ref'], $main['category']['name']);
            //$this->stockProduct($sku, $main);
            //$this->stockAttributes($sku, $attributes);
            //break;
        }
    }

    /**
     * @param $ref
     * @param $dataProduct
     *
     * @return void
     */
    protected function stockProduct(string $ref, array $dataProduct) : void
    {
        $product = Product::where('details->sku', $ref)->first();

        if (!isset($product)) {
            $product = new Product();

            $name = $dataProduct['name'];
            $description = $dataProduct['description'];
            $brand = $dataProduct['brand'];
            $category = $dataProduct['category'];
            $price = $dataProduct['price'];
            $oldPrice = $dataProduct['old_price'];
            $balance = $dataProduct['balance'];

            $slug = Slug::create(Product::class, $category['name']['ru'] . '/' . $name['ru']);

            $product->setRequest([
                'slug' => $slug,
                'details' => [
                    'sku' => $ref,
                    'brand_id' => $brand['ref'],
                    'category_id' => $category['ref'],
                    'published' => 0,
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'balance' => $balance,
                ],
                'data' => [
                    'name' => $name['ru'],
                    'description' => $description['ru'],
                ]
            ]);

            LaravelLocalization::setLocale('ru');
            $product->storeOrUpdate();

            $product->setRequest([
                'data' => [
                    'name' => $name['uk'],
                    'description' => $description['uk'],
                ]
            ]);

            LaravelLocalization::setLocale('uk');
            $product->storeOrUpdate();
        }
    }

    /**
     * @param string $ref
     * @param string $name
     *
     * @return void
     */
    public function stockBrand(string $ref, string $name) : void
    {
        $brand = Brand::where('details->ref', $ref)->first();

        if (!isset($brand)) {
            $brand = new Brand();

            $brand->setRequest([
                'slug' => Str::slug(str_replace('/', '', $name)),
                'details' => [
                    'ref' => $ref,
                    'name' => $name
                ],
            ]);

            LaravelLocalization::setLocale('ru');
            $brand->storeOrUpdate();
        }
    }

    /**
     * @param string $ref
     * @param array $name
     *
     * @return void
     */
    public function stockCategory(string $ref, array $name) : void
    {
        $category = Category::where('details->ref', $ref)->first();

        if (!isset($category)) {
            $category = new Category();

            $category->setRequest([
                'slug' => Slug::create(Category::class, $name['ru']),
                'details' => [
                    'ref' => $ref,
                    'name' => $name
                ],
                'data' => ['name' => $name['ru']]
            ]);

            LaravelLocalization::setLocale('ru');
            $category->storeOrUpdate();

            $category->setRequest([
                'data' => ['name' => $name['uk']]
            ]);

            LaravelLocalization::setLocale('uk');
            $category->storeOrUpdate();
        }
    }

    public function stockCharacteristic()
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

    public function stockCharacteristicValue()
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

    /**
     * @param int $sku
     * @param array $attributes
     *
     * @return void
     */
    public function stockAttributes(int $sku, array $attributes) : void
    {
        $product = Product::where('details->sku', $sku)->first();

        if (isset($product)) {
            if (isset($attributes)) {
                $product->setRequest([
                    'relations' => [
                        CharacteristicValue::class => $this->stockUpdateOrCreateCharacteristics($attributes)
                    ]
                ]);
            }

            $product->updateRelations();
        }
    }

    public function stockUpdateOrCreateCharacteristics($characteristics)
    {
        $characteristicValueIds = [];

        foreach ($characteristics as ['name' => $name, 'value' => $value]) {
            $characteristicId = $this->characteristic($name['ru'], $name['uk']);
            $characteristicValueId = $this->characteristicValue(
                $characteristicId,
                $value['ru'],
                $value['uk']
            );

            array_push($characteristicValueIds, $characteristicValueId);
        }

        return $characteristicValueIds;
    }
}
