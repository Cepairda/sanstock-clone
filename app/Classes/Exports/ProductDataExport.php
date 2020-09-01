<?php

namespace App\Exports;

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
//        return ProductData::whereLocale($this->locale)->get();
        return Product::joinData($this->locale)->get();
    }

    public function map($product): array
    {
        return [
//            $product->product_id,
            $product->sku,
            $product->meta_title,
            $product->meta_description,
            $product->name,
            $product->description,
            $product->text,
        ];
    }

    public function headings(): array
    {
        return [
//            'product_id',
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