<?php

namespace App\Imports;

use App\CategoryData;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryDataImport implements ToCollection, WithHeadingRow
{
    protected $locale;

    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            CategoryData::updateOrCreate(
                [
                    'category_id' => (int)$row['category_id'],
                    'locale' => $this->locale
                ],
                [
                    'meta_title' => $row['meta_title'],
                    'meta_description' => $row['meta_description'],
                    'h1' => $row['h1'],
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'text' => $row['text'],
                ]
            );
        }
    }
}