<?php

namespace App\Classes\Imports;

use App\Category;
use App\Jobs\ProcessCategoryB2BImport;
use App\Product;
use GuzzleHttp\Client;
use LaravelLocalization;
use App\Classes\Slug;

class CategoryB2BImport
{
    private $apiUrl = 'https://b2b-sandi.com.ua/api/categories';
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
        $this->importCommand();
    }

    public function importCommand()
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
        }

        /**
         * If this is the root category, we must trim the numbers
         * otherwise no change
         * Before: 1. CategoryName
         * After: CategoryName
         */
        if (is_null($parentRef)) {
            $nameRu = substr($name['ru'], strpos($name['ru'], ' ') + 1);
            $nameUk = substr($name['uk'], strpos($name['uk'], ' ') + 1);
        } else {
            $nameRu = $name['ru'];
            $nameUk = $name['uk'];
        }

        $category->setRequest([
            'slug' => Slug::create(Category::class, $nameRu),
            'details' => [
                'ref' => $ref,
                'parent_ref' => $parentRef,
            ],
            'data' => ['name' => $nameRu]
        ]);

        LaravelLocalization::setLocale('ru');
        $category->storeOrUpdate();

        $category->setRequest([
            'data' => ['name' => $nameUk]
        ]);

        LaravelLocalization::setLocale('uk');
        $category->storeOrUpdate();
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
                $category->forceDelete();
            }
        }

        return $isEmptyDeep;
    }
}
