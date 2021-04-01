<?php

namespace App\Classes\Imports;

use App\Alias;
use App\Category;
use App\Classes\Slug;
use App\Icon;
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
        ini_set('max_execution_time', 900);
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
                $slugName = Slug::create(Product::class, $row['name']);

                $slug = $category
                    ? $category->slug . '/' . $slugName
                    : $slugName;
            } else {
                $slug = Slug::create(Product::class, $row['slug'], $product->id ?? null);
            }

            $requestData['slug'] = $slug;
            $requestData['details']['published'] = (int)$row['published'];
            $requestData['details']['category_id'] = isset($categories[$categoryId]) ? $categories[$categoryId] : null;
            $requestData['details']['sku'] = $sku;
            $requestData['details']['ref'] = $product->getDetails('ref');
            $requestData['details']['brand_id'] = $product->getDetails('brand_id');
            $requestData['details']['price'] = $product->getDetails('price');
            $requestData['details']['price_updated_at'] = $product->getDetails('price_updated_at');
            $requestData['details']['old_price'] = $product->getDetails('old_price');
            $requestData['details']['enable_comments'] = $product->getDetails('enable_comments') ?? 1;
            $requestData['details']['enable_stars_comments'] = $product->getDetails('enable_stars_comments') ?? 1;
            $requestData['details']['enable_reviews'] = $product->getDetails('enable_reviews') ?? 1;
            $requestData['details']['enable_stars_reviews'] = $product->getDetails('enable_stars_reviews') ?? 1;

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

            $relateProductsSku = !empty($row['relate_products_sku']) ? explode('|', $row['relate_products_sku']) : [];
            $relateProductsIds = Product::whereIn('details->sku', $relateProductsSku)->get()->keyBy('id')->keys()->toArray();

            if (!empty($relateProductsIds)) {
                $product->setRequest([
                    'relations' => [
                        Product::class => $relateProductsIds,
                    ]
                ]);

                $product->updateRelations();
            }

            $iconsIds = !empty($row['icons_ids']) ? explode('|', $row['icons_ids']) : [];
            $iconsIds = Icon::whereIn('id', $iconsIds)->get()->keyBy('id')->keys()->toArray();

            if (!empty($iconsIds)) {
                $product->setRequest([
                    'relations' => [
                        Icon::class => $iconsIds,
                    ]
                ]);

                $product->updateRelations();
            }
        }
    }
}
