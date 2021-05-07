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
    private const DEFAULT_API_URL = 'http://94.131.241.126/api/products?token=368dbc0bf4008db706576eb624e14abf&only_defectives=1';
    protected $apiUrl;
    private static $data;

    public function getDataJson($apiUrl = self::DEFAULT_API_URL, array $queryString = [])
    {
        if (self::$data === null) {
            $client = new Client();
            $res = $client->request('GET', $apiUrl, $queryString);
            $this->setData(json_decode($res->getBody(), true));
        }

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

            foreach ($jsonData['data'] as $sku => $dataProduct) {
                ProcessImportB2B::dispatch($sku)->onQueue('b2bImport');
            }
        } while ($this->apiUrl = $jsonData['next_page_url'] ?? null);
    }

    public function importQueue($sku)
    {
        $apiUrl = self::DEFAULT_API_URL . "&sku_in={$sku}";
        $this->getDataJson($apiUrl);
        ['data' => [$sku => ['main' => $main]]] = self::$data;

        $this->stockProduct($sku, $main);
        $this->stockAttributes($sku, $attributes);
    }

    public function parse()
    {
        $this->apiUrl = self::DEFAULT_API_URL;

        do {
            $this->getDataJson($this->apiUrl);
            $jsonData = self::$data;

            foreach ($jsonData['data'] as $sku => $dataProduct) {
                $main = $dataProduct['main'];
                $attributes = $dataProduct['attributes'];
                //$this->stockBrand($main['brand']['ref'], $main['brand']['name']);
                //$this->stockCategory($main['category']['ref'], $main['category']['name']);
                $this->stockProduct($sku, $main);
                $this->stockAttributes($sku, $attributes);
            }
        } while ($this->apiUrl = $jsonData['next_page_url'] ?? null);
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

    public function stockUpdatePriceAndBalance(PriceImport $price, array $skuT = [])
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
