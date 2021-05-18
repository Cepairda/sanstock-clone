<?php

namespace App\Classes\Imports;

use App\Brand;
use App\Category;
use App\Characteristic;
use App\CharacteristicValue;
use App\Jobs\ProcessCategoryB2BImport;
use App\Product;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use LaravelLocalization;
use App\Jobs\ProcessImportB2B;
use App\Classes\Slug;

class CategoryB2BImport
{
    private $apiUrl = 'http://94.131.241.126/api/categories';
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
//        $this->getDataJson($this->apiUrl);
//        $jsonData = self::$data;
//
//        foreach ($jsonData as $ref => $data) {
//            ProcessCategoryB2BImport::dispatch($ref)->onQueue('b2bImportCategory');
//        }
        ProcessCategoryB2BImport::dispatch()->onQueue('b2bImportCategory');
    }

    public function importQueue()
    {
        if (empty(self::$data)) {
            self::$data = $this->getDataJson();
        }

        /*[
            'parent_ref' => $parentRef,
            'name' => $name,
            'image' => $image
        ] = self::$data[$ref];
        $this->categoryImport($ref, $parentRef, $name, $image);*/

        $this->import();
    }

    public function import()
    {
        $jsonData = self::$data;

        foreach ($jsonData as $ref => [
            'parent_ref' => $parentRef,
            'name' => $name,
            'image' => $image
        ]) {
            $this->categoryImport($ref, $parentRef, $name, $image);
        }

        $this->fixParent();
        $tree = Category::get()->toTree();
        $this->recursiveCheck($tree);
    }

    /**
     * @param string $ref
     * @param string|null $parentRef
     * @param array $name
     * @param string $image
     *
     * @return void
     */
    public function categoryImport(string $ref, ?string $parentRef, array $name, string $image) : void
    {
        $category = Category::where('details->ref', $ref)->first();

        if (!isset($category)) {
            $category = new Category();

            $category->setRequest([
                'slug' => Slug::create(Category::class, $name['ru']),
                'details' => [
                    'ref' => $ref,
                    'parent_ref' => $parentRef,
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

    public function fixParent()
    {
        $categories = Category::get();

        foreach ($categories as $key => [
            'id' => $id,
            'details' => [
                'ref' => $ref,
                'parent_ref' => $parentRef
            ]
        ]) {
            if (!is_null($parentRef)) {
                $parentCategory = Category::where('details->ref', $parentRef)->first();
                Category::where('id', $id)->update(['parent_id' => $parentCategory->id]);
            }
        }

        Category::fixTree();
    }

    /**
     *
     *
     * @param $categories
     *
     * @return bool
     */
    function recursiveCheck($categories) : bool
    {
        $isEmpty = true;
        $isEmptyDeep = true;

        foreach ($categories as $category) {
            $children = $category->children;

            if ($children->isNotEmpty()) {
                $isEmpty = $this->recursiveCheck($children);

                if ($isEmpty == false) {
                    $isEmptyDeep = false;
                }
            } else {
                $product = Product::where('details->category_id', $category->getDetails('ref'))->first();
                $isEmpty = !$product;

                if ($product) {
                    $isEmptyDeep = false;
                }
            }

            if ($isEmpty) {
                $category->delete();
            }
        }

        return $isEmptyDeep;
    }
}
