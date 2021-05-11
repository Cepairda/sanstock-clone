<?php

namespace App\Classes\Imports;

use App\Brand;
use App\Category;
use App\Characteristic;
use App\CharacteristicValue;
use App\Product;
use App\ProductGroup;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use LaravelLocalization;
use App\Jobs\ProcessImportB2B;
use App\Classes\Slug;

class StockB2BImport
{
    private const DEFAULT_API_URL = 'http://94.131.241.126/api/products?token=368dbc0bf4008db706576eb624e14abf&only_defectives=1';
    protected $apiUrl;
    private static $data;

    public function getDataJson($apiUrl = self::DEFAULT_API_URL, array $queryString = [])
    {
        $client = new Client();
        $res = $client->request('GET', $apiUrl, $queryString);
        $this->setData(json_decode($res->getBody(), true));

        return self::$data;
    }

    private function setData($data)
    {
        self::$data = $data;
    }

    public function addToQueue()
    {
        $this->apiUrl = self::DEFAULT_API_URL;

        do {
            $this->getDataJson($this->apiUrl);
            $jsonData = self::$data;
            $tenPartJsonDate = array_chunk($jsonData['data'], 10, true);

            foreach ($tenPartJsonDate as $key => $products) {
                $skuArray = [];

                foreach ($products as $sku => $product) {
                    $skuArray[] = $sku;
                }

                ProcessImportB2B::dispatch($skuArray)->onQueue('b2bImport');
            }

        } while ($this->apiUrl = $jsonData['next_page_url'] ?? null);
    }

    public function importQueue(array $skuArray)
    {
        $skuStr = implode(',', $skuArray);
        $apiUrl = self::DEFAULT_API_URL . "&sku_in={$skuStr}";

        $this->importProductWithAttributes($apiUrl);
    }

    public function parse()
    {
            $this->apiUrl = self::DEFAULT_API_URL;

        do {
            $this->importProductWithAttributes($this->apiUrl);
        } while ($this->apiUrl = $jsonData['next_page_url'] ?? null);
    }

    /**
     * @param $ref
     * @param $dataProduct
     *
     * @return void
     */
    protected function stockProductGroup(string $ref, array $dataProduct) : void
    {
        $product = ProductGroup::where('details->sd_code', $ref)->first();

        if (!isset($product)) {
            $product = new ProductGroup();

            $sdCode = $dataProduct['sku'];
            $name = $dataProduct['name'];
            $description = $dataProduct['description'];
            $brand = $dataProduct['brand'];
            $category = $dataProduct['category'];

            $slug = Slug::create(ProductGroup::class, $category['name']['ru'] . '/' . $name['ru']);

            $product->setRequest([
                'slug' => $slug,
                'details' => [
                    'sd_code' => $sdCode,
                    'brand_id' => $brand['ref'],
                    'category_id' => $category['ref'],
                    'published' => 0,
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

            $sdCode = $dataProduct['sku'];
            $name = $dataProduct['name'];
            $description = $dataProduct['description'];
            $brand = $dataProduct['brand'];
            $category = $dataProduct['category'];
            $price = $dataProduct['price'];
            $oldPrice = $dataProduct['old_price'];
            $balance = $dataProduct['balance'];
            $grade = $dataProduct['defective_attributes']['grade'];

            $defectiveDescriptionRu = $dataProduct['defective_attributes']['descriptions']['ru'];
            $defectiveDescriptionUk = $dataProduct['defective_attributes']['descriptions']['uk'];

            //$slug = Slug::create(Product::class, $category['name']['ru'] . '/' . $name['ru']);

            $product->setRequest([
                //'slug' => $slug,
                'details' => [
                    'sku' => $ref,
                    'sd_code' => $sdCode,
                    'brand_id' => $brand['ref'],
                    'category_id' => $category['ref'],
                    'published' => 0,
                    'price' => $price,
                    'old_price' => $oldPrice,
                    'balance' => $balance,
                    'grade' => $grade
                ],
                'data' => [
                    'name' => $name['ru'],
                    'description' => $description['ru'],
                    'defective_attributes' => $defectiveDescriptionRu
                ]
            ]);

            LaravelLocalization::setLocale('ru');
            $product->storeOrUpdate();

            $product->setRequest([
                'data' => [
                    'name' => $name['uk'],
                    'description' => $description['uk'],
                    'defective_attributes' => $defectiveDescriptionUk
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

    /**
     * @param string $nameRu
     * @param string|null $nameUk
     *
     * @return int
     */
    public function stockCharacteristic(string $nameRu, ?string $nameUk) : int
    {
        $c = Characteristic::where('data->name', $nameRu)->joinLocalization('ru')->first();

        if (!isset($c)) {
            $c = new Characteristic();

            $c->setRequest([
                'data' => ['name' => $nameRu]
            ]);

            LaravelLocalization::setLocale('ru');
            $c->storeOrUpdate();
        }

        if (!empty($nameUk)) {
            $c->setRequest([
                'details' => [
                    'is_filter' => 1,
                    'published' => 1,
                    'sort' => 0
                ],
                'data' => ['name' => $nameUk],
            ]);

            LaravelLocalization::setLocale('uk');
            $c->storeOrUpdate();
        }

        return $c->id;
    }

    /**
     * @param int $characteristicId
     * @param string $nameRu
     * @param string $nameUk
     *
     * @return int
     */
    public function stockCharacteristicValue(int $characteristicId, string $valueRu, string $valueUk) : int
    {
        $cV = CharacteristicValue::where('details->characteristic_id', $characteristicId)
            ->where('data->value', $valueRu)->joinLocalization('ru')->first();

        if (!isset($cV)) {
            $cV = new CharacteristicValue();

            $cV->setRequest([
                'details' => ['characteristic_id' => $characteristicId],
                'data' => ['value' => $valueRu]
            ]);

            LaravelLocalization::setLocale('ru');
            $cV->storeOrUpdate();
        }

        if (!empty($valueUk)) {
            $cV->setRequest([
                'details' => ['characteristic_id' => $characteristicId],
                'data' => ['value' => $valueUk]
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
    public function stockAttributes(int $sdCode, array $attributes) : void
    {
        $productGroup = ProductGroup::where('details->sd_сode', $sdCode)->first();

        if (isset($productGroup)) {
            if (isset($attributes)) {
                $productGroup->setRequest([
                    'relations' => [
                        CharacteristicValue::class => $this->stockUpdateOrCreateCharacteristics($attributes)
                    ]
                ]);
            }

            $productGroup->updateRelations();
        }
    }


    /**
     * @param array $characteristics
     *
     * @return array
     */
    public function stockUpdateOrCreateCharacteristics(array $characteristics) : array
    {
        $characteristicValueIds = [];

        foreach ($characteristics as ['name' => $name, 'value' => $value]) {
            $characteristicId = $this->stockCharacteristic($name['ru'], $name['uk']);
            $characteristicValueId = $this->stockCharacteristicValue(
                $characteristicId,
                $value['ru'],
                $value['uk']
            );

            array_push($characteristicValueIds, $characteristicValueId);
        }

        return $characteristicValueIds;
    }

    /**
     * @param string $apiUrl
     *
     * @return void
     */
    protected function importProductWithAttributes(string $apiUrl) : void
    {
        $this->getDataJson($apiUrl);
        $jsonData = self::$data;

        foreach ($jsonData['data'] as $sku => $dataProduct) {
            $main = $dataProduct['main'];
            $attributes = $dataProduct['attributes'];
            $sdCode = $dataProduct['sku'];
            //$this->stockBrand($main['brand']['ref'], $main['brand']['name']);
            //$this->stockCategory($main['category']['ref'], $main['category']['name']);
            $this->stockProductGroup($sdCode, $main);
            $this->stockProduct($sku, $main);
            $this->stockAttributes($sdCode, $attributes);
        }
    }

    /**
     * @param PriceImport $price
     * @param array $skuT
     *
     * @return void
     */
    public function stockUpdatePriceAndBalance(PriceImport $price, array $skuT = []) : void
    {
        /**
         * For testing
         */
        $sku = [2250000005477, 2250000005279];

        $this->apiUrl = self::DEFAULT_API_URL;
        $skuString = implode(',', $sku);

        $urlData = parse_url(self::DEFAULT_API_URL);
        $params = [];
        parse_str($urlData['query'], $params);
        $params['sku_in'] = $skuString;

        $queryString = [
            'query' => $params
        ];

        do {
            $sku
                ? $this->getDataJson($this->apiUrl, $queryString)
                : $this->getDataJson($this->apiUrl);

            $jsonData = self::$data;
            $price->import($jsonData);
        } while ($this->apiUrl = $jsonData['next_page_url'] ?? null);
    }
}
