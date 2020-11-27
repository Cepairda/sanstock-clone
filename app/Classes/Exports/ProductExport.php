<?php

namespace App\Classes\Exports;

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
            $product->details['sku'] ?? null,
            $product->details['category_id'] ?? null,
            null,//$product->details['categories']->keyBy('id')->keys()->implode('|'),
            $product->details['published'] ?? null,
            $product->data['name'] ?? null,
        ];
    }

    public function headings(): array
    {
        return [
            'sku',
            'category_id',
            'category_ids',
            'published',
            'name'
        ];
    }

    public function title(): string
    {
        return 'main';
    }
}
