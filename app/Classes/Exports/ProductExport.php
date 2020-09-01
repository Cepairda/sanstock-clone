<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    public function collection()
    {
        return Product::joinData('ru')->withCategories()->get();
    }

    public function map($product): array
    {
        return [
//            $product->id,
            $product->sku,
            $product->category_id,
            $product->categories->keyBy('id')->keys()->implode('|'),
            $product->group_id,
            $product->published,
            $product->name
        ];
    }

    public function headings(): array
    {
        return [
//            'id',
            'sku',
            'category_id',
            'category_ids',
            'group_id',
            'published',
            'name'
        ];
    }

    public function title(): string
    {
        return 'main';
    }
}