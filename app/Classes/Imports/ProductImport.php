<?php

namespace App\Classes\Imports;

use App\Alias;
use App\Category;
use App\Classes\Slug;
use App\Product;
use App\ProductCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use LaravelLocalization;

class ProductImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $categories = Category::all()->pluck('id', 'virtual_id');

        foreach ($rows as $row) {
            $requestData = [];
            $sku = (int)$row['sku'];
            $categoryId = (int)$row['category_id'];
            $slug = $row['slug'];
            $product = Product::where('details->sku', $sku)->first();

            if (!isset($product)) {
                $product = new Product();
                $requestData['details']['sku'] = $sku;
                //$requestData['slug'] = (Slug::create(Product::class, $row['name']));
            }

            if (empty($slug)) {
                $category = Category::find($categoryId);
                $slugName = (Slug::create(Product::class, $row['name']));

                $slug = $category
                    ? $category->slug . '/' . $slugName
                    : $slugName;
            }

            $requestData['slug'] = $slug;
            $requestData['details']['published'] = (int)$row['published'];
            $requestData['details']['category_id'] = isset($categories[$categoryId]) ? $categories[$categoryId] : null;

            $product->setRequest($requestData);

            LaravelLocalization::setLocale('ru');
            $product->storeOrUpdate();

            $categoryIds = !empty($row['category_ids']) ? explode('|', $row['category_ids']) : [];

            if (!empty($categoryId) && !in_array($categoryId, $categoryIds)) {
                array_push($categoryIds, $categoryId);
            }

            $categoryIdsReplace = [];//Заменяем ID из файла на реальный ID в БД

            foreach ($categoryIds as $id) {
                if (isset($categories[$id]))
                    $categoryIdsReplace[] = $categories[$id];
            }

            if (!empty($categoryIdsReplace)) {
                $product->setRequest([
                    'relations' => [
                        Category::class => $categoryIdsReplace,
                    ]
                ]);

                $product->updateRelations();
            }
        }
    }
}
