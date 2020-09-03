<?php

namespace App\Classes\Exports;

use App\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoryExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    public function collection()
    {
        return Category::joinLocalization('ru')->get();
    }

    public function map($category): array
    {
        return [
            $category->details['category_id'],
            $category->parent_id,
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
