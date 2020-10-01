<?php

namespace App\Classes\Exports;

use App\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class CategoryExport implements FromCollection, WithHeadings, WithTitle, WithMapping, WithStrictNullComparison
{
    public function collection()
    {
        return Category::joinLocalization('ru')->get();
    }

    public function map($category): array
    {
        return [
            $category->resource_id,
            $category->parent_id ? Category::find($category->parent_id)->resource_id : null,
            $category->details['sort'],
            $category->details['published'],
            $category->details['is_menu_item'],
            $category->slug,
            $category->data['name']
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'parent_id',
            'sort',
            'published',
            'is_menu_item',
            'alias',
            'name'
        ];
    }

    public function title(): string
    {
        return 'main';
    }
}
