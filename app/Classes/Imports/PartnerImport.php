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

class PartnerImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public function collection(Collection $rows)
    {
        ini_set('max_execution_time', 900);
        $partners = []; // Для оптимизации производительности

        foreach ($rows as $row) {
            $requestData = [];
            $sku = (int)$row['sku'];
            $url = $row['url'];
            $partnerUrl = PartnerUrl::where('details->url', $url)->first();

            if (!isset($partnerUrl)) {
                $partnerUrl = new PartnerUrl();
            }

            $partnerHost = parse_url($url, PHP_URL_HOST);

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
