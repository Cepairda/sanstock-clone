<?php

namespace App\Classes\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductDataExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    protected $locale;

    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    public function collection()
    {
        return Product::joinLocalization($this->locale)->get();
    }

    public function map($product): array
    {
        return [
            $product->details['sku'] ?? null,
            $product->data['meta_title'] ?? null,
            $product->data['meta_description'] ?? null,
            $product->data['name'] ?? null,
            $product->data['description'] ?? null,
            $product->data['text'] ?? null,
        ];
    }

    public function headings(): array
    {
        return [
            'sku',
            'meta_title',
            'meta_description',
            'name',
            'description',
            'text'
        ];
    }

    public function title(): string
    {
        return $this->locale;
    }
}
