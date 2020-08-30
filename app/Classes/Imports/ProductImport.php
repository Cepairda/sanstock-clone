<?php

namespace App\Classes\Imports;

use App\Alias;
use App\Product;
use App\ProductCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $sku = (int)$row['sku'];
            $categoryId = (int)$row['category_id'];
            $product = Product::where('details->sku', $sku)->first();
            if (!isset($product)) {
                $product = new Product();
                $product->details['sku'] = $sku;
                //$product->alias_id = Alias::storeOrUpdate(str_replace('/', '-', $row['name']), 'product');
                $slug = (Str::slug($row['name']));
            }

            $product->setRequest([
                'slug' => $slug,
                'details' => [
                    'published' => (int)$row['published'],
                    'group_id' => (int)$row['group_id'],
                    'category_id' => $categoryId,
                ],
            ]);

            LaravelLocalization::setLocale('ru');
            $product->storeOrUpdate();

            /*$categoryIds = !empty($row['category_ids']) ? explode('|', $row['category_ids']) : [];
            if (!empty($categoryId) && !in_array($categoryId, $categoryIds)) {
                array_push($categoryIds, $categoryId);
            }
            ProductCategory::storeOrUpdate($product->id, $categoryIds);*/
        }
    }
}
