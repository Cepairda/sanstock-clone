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
        do {


            foreach ($jsonData['data'] as $sku => $dataProduct) {
                $main = $dataProduct['main'];
                $attributes = $dataProduct['attributes'];
                //$this->stockBrand($main['brand']['ref'], $main['brand']['name']);
                //$this->stockCategory($main['category']['ref'], $main['category']['name']);
                //$this->stockProduct($sku, $main);
                $this->stockAttributes($sku, $attributes);
                break;
            }
        } while (isset($jsonData['next_page_url']));
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

    public function stockUpdatePriceAndBalance(array $sku = null)
    {
        $jsonData = self::$data;

        $products = isset($sku)
            ? Product::where('details->published', 1)->whereIn('details->sku', $sku)->get()
            : Product::where('details->published', 1)->get();

        foreach ($products['data'] as $product) {
            Product::where('details->sku', $product->sku)->update([
                'details->price' => $product['price'],
                'details->old_price' => $product['old_price'],
                'details->old_price' => $product['balance']
            ]);
        }
    }
}
