<?php

namespace App\Classes\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use LaravelLocalization;

class ProductWithDataExport implements Responsable, WithMultipleSheets
{
    use Exportable;

    private $fileName = 'products.xlsx';

    public function sheets(): array
    {
        $sheets[] = new ProductExport();

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $locale) {
            $sheets[] = new ProductDataExport($locale);
        }

        return $sheets;
    }
}
