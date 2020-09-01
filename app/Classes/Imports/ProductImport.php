<?php

namespace App\Classes\Imports;

use App\Alias;
use App\Category;
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
        foreach ($rows as $row) {
            $requestData = [];
            $sku = (int)$row['sku'];
            $categoryId = (int)$row['category_id'];
            $product = Product::where('details->sku', $sku)->first();
            if (!isset($product)) {
                $product = new Product();
                $requestData['details']['sku'] = $sku;
                $requestData['slug'] = (Str::slug($row['name']));
            }

            $requestData['details']['published'] = (int)$row['published'];
            $requestData['details']['group_id'] = (int)$row['group_id'];
            $requestData['details']['category_id'] = $categoryId;

            $product->setRequest($requestData);

            /*$product->setRequest([
                'slug' => $slug,
                'details' => [
                    'published' => (int)$row['published'],
                    'group_id' => (int)$row['group_id'],
                    'category_id' => $categoryId,
                ],
            ]);*/

            LaravelLocalization::setLocale('ru');
            $product->storeOrUpdate();

            $categoryIds = !empty($row['category_ids']) ? explode('|', $row['category_ids']) : [];

            if (!empty($categoryId) && !in_array($categoryId, $categoryIds)) {
                array_push($categoryIds, $categoryId);
            }

            $product->setRequest([
                'relations' => [
                    Category::class => $categoryIds,
                ]
            ]);

            $product->updateRelations();
            /*ProductCategory::storeOrUpdate($product->id, $categoryIds);*/
        }
    }
}
