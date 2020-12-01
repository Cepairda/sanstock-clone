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
            $product->getDetails('sku'),
            $product->getData('meta_title'),
            $product->getData('meta_description'),
            $product->getData('name'),
            $product->getData('description'),
            $product->getData('text'),
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
