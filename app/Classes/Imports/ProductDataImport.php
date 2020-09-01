<?php

namespace App\Classes\Imports;

use App\Product;
use App\ProductCategory;
use App\ProductData;
use App\ResourceLocalization;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use LaravelLocalization;

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
                $product = Product::where('details->sku', $sku)->first();
                //ResourceLocalization::where('resource_id', $product->id)->delete();

                if (isset($product)) {
                    $product->setRequest([
                        'data' => [
                            'meta_title' => $row['meta_title'],
                            'meta_description' => $row['meta_description'],
                            'name' => $row['name'],
                            'description' => $row['description'],
                            'text' => $row['text'],
                        ]
                    ]);

                    LaravelLocalization::setLocale($this->locale);
                    $product->storeOrUpdate();
                }
            }
        }
    }
}
