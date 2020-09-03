<?php

namespace App\Classes\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Importable;
use LaravelLocalization;

class CategoryWithDataImport implements WithMultipleSheets
{
    use Importable;

    public function sheets(): array
    {
        ini_set('memory_limit', '512M');
        $sheets = [];
        $sheets['main'] = new CategoryImport();

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $locale) {
            $sheets[$locale] = new CategoryDataImport($locale);
        }

        return $sheets;
    }
}
