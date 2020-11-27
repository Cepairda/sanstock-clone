<?php

namespace App\Classes\Imports;

use App\Category;
use App\CategoryData;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use LaravelLocalization;

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
            $category= Category::where('virtual_id', (int)$row['category_id'])->first();

            if (isset($category)) {
                $category->setRequest([
                    'data' => [
                        'meta_title' => $row['meta_title'],
                        'meta_description' => $row['meta_description'],
                        'h1' => $row['h1'],
                        'name' => $row['name'],
                        'description' => $row['description'],
                        'text' => $row['text'],
                    ]
                ]);

                LaravelLocalization::setLocale($this->locale);
                $category->storeOrUpdate();
            }
        }
    }
}
