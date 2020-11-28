<?php

namespace App\Classes\Exports;

use App\Category;
use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    public function collection()
    {
        return Product::joinLocalization('ru')->get();
    }

    public function map($product): array
    {
        return [
            $product->getDetails('sku'),
            Category::find($product->getDetails('category_id'))->virtual_id ?? null,
            $product->categories->keyBy('virtual_id')->keys()->implode('|'),
            $product->getDetails('published'),
            $product->getData('name'),
            $product->slug,
        ];
    }

    public function headings(): array
    {
        return [
            'sku',
            'category_id',
            'category_ids',
            'published',
            'name',
            'slug',
        ];
    }

    public function title(): string
    {
        return 'main';
    }
}
