<?php

namespace App\Classes\Exports;

use App\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class CategoryDataExport implements FromCollection, WithHeadings, WithTitle, WithMapping, WithStrictNullComparison
{
    protected $locale;

    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    public function collection()
    {
        return Category::joinLocalization($this->locale)->get();
    }

    public function map($category): array
    {
        return [
            $category->resource_id,
            $category->data['meta_title'],
            $category->data['meta_description'],
            $category->data['h1'],
            $category->data['name'],
            $category->data['description'],
            $category->data['text']
        ];
    }

    public function headings(): array
    {
        return [
            'category_id',
            'meta_title',
            'meta_description',
            'h1',
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
