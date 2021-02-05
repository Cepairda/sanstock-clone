<?php

namespace App\Classes\Imports;

use App\Alias;
use App\Partner;
use App\PartnerUrl;
use App\ProductCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use LaravelLocalization;

class PartnerImport implements ToCollection, WithHeadingRow //,WithMultipleSheets
{
    use Importable;

    public function collection(Collection $rows)
    {
        ini_set('max_execution_time', 900);
        $partners = []; // Для оптимизации производительности

        PartnerUrl::where('type', 'App\\PartnerUrl')->forceDelete();

        foreach ($rows as $row) {
            if (!empty($row['sku'])) {
                $requestData = [];
                $sku = $row['sku'];
                $url = $row['url'];
                $partnerHost = $row['host'];

                $partnerUrl = new PartnerUrl();

                if (!isset($partners[$partnerHost])) {
                    $partner = Partner::where('details->host', $partnerHost)->first();

                    if (!isset($partner)) {
                        $partner = new Partner();
                        $requestData['details']['host'] = $partnerHost;

                        $partner->setRequest($requestData);
                        LaravelLocalization::setLocale('ru');
                        $partner->storeOrUpdate();
                    }

                    $partners[$partnerHost] = $partner->id;
                }

                $partnerId = $partners[$partnerHost];

                $requestData['details']['url'] = $url;
                $requestData['details']['sku'] = $sku;
                $requestData['details']['partner_id'] = $partnerId;

                $partnerUrl->setRequest($requestData);
                LaravelLocalization::setLocale('ru');
                $partnerUrl->storeOrUpdate();
            }
        }
    }
}
