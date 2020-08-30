<?php

namespace App\Classes\Imports;

use App\Product;
use App\ProductCategory;
use App\ProductData;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductDataImport implements ToCollection, WithHeadingRow
{
    protected $locale;

    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!empty($row['name'])) {
                $sku = (int)$row['sku'];
                $product = Product::whereSku($sku)->first();
                ProductData::whereProductId($product->id)->whereLocale($this->locale)->delete();
                ProductData::create([
                    'product_id' => $product->id,
                    'locale' => $this->locale,
                    'meta_title' => $row['meta_title'],
                    'meta_description' => $row['meta_description'],
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'text' => $row['text'],
                ]);
            }
        }
    }
}
