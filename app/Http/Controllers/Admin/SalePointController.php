<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\SalePoint;

class SalePointController extends Controller
{
    use isResource;

    public function __construct(SalePoint $salePoint)
    {
        $this->resource = $salePoint;
    }

    public function createSearchString() {
        $salePoints = $this->resource
            ->select('id', 'details', 'ua.data as ua_name', 'ru.data as ru_name')
            ->leftJoin('resource_localizations as ua', function($q) {
                $q->on('ua.resource_id', '=', 'resources.id')
                    ->where('ua.locale', 'uk');
            })
            ->leftJoin('resource_localizations as ru', function($q) {
                $q->on('ru.resource_id', '=', 'resources.id')
                    ->where('ru.locale', 'ru');
            })->get();

        foreach ($salePoints as $salePoint) {
            SalePoint::where('id', $salePoint->id)->update([
                'search_string' =>
                    (json_decode($salePoint->ua_name, 1))['name'] . ' ' .
                    (json_decode($salePoint->ru_name, 1))['name']
            ]);
        }
    }
}
