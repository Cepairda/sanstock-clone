<?php

namespace App\Classes\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use LaravelLocalization;

class CategoryWithDataExport implements Responsable, WithMultipleSheets
{
    use Exportable;

    private $fileName = 'categories.xlsx';

    public function sheets(): array
    {
        $sheets[] = new CategoryExport();
        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $locale) {
            $sheets[] = new CategoryDataExport($locale);
        }
        return $sheets;
    }
}
