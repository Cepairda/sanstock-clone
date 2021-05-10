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

class BrandB2BImport
{
    private $apiUrl = 'http://94.131.241.126/api/brands';
    private static $data;

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

    /**
     * @return void
     */
    public function import() : void
    {
        $jsonData = self::$data;

        foreach ($jsonData as $ref => [
            'name' => $name,
            'image' => $image
        ]) {
            /**
             *  We create brands only for existing products
             */
            $product = Product::where('details->brand_id', $ref)->first();

            if ($product) {
                $this->brandImport($ref, $name, $image);
            }
        }
    }

    /**
     * @param string $ref
     * @param string $name
     * @param string $image
     *
     * @return void
     */
    public function brandImport(string $ref, string $name, string $image) : void
    {
        $brand = Brand::where('details->ref', $ref)->first();

        if (!isset($brand)) {
            $brand = new Brand();

            $brand->setRequest([
                'slug' => Slug::create(Brand::class, $name),
                'details' => [
                    'ref' => $ref,
                    'name' => $name
                ],
            ]);

            LaravelLocalization::setLocale('ru');
            $brand->storeOrUpdate();
        }
    }
}
