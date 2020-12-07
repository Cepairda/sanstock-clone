<?php

namespace App\Http\Controllers\Admin;

use App\Characteristic;
use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;

class CharacteristicController extends Controller
{
    use isResource;

    public function __construct(Characteristic $characteristic)
    {
        $this->resource = $characteristic;
    }

    public function createSearchString() {
        $characteristics = $this->resource
            ->select('id', 'details', 'ua.data as ua_name', 'ru.data as ru_name')
            ->join('resource_localizations as ua', function($q) {
                $q->on('ua.resource_id', '=', 'resources.id')
                    ->where('ua.locale', 'uk');
            })
            ->join('resource_localizations as ru', function($q) {
                $q->on('ru.resource_id', '=', 'resources.id')
                    ->where('ru.locale', 'ru');
            })->get();

        foreach ($characteristics as $characteristic) {
            Characteristic::where('id', $characteristic->id)->update([
                'search_string' =>
                    (json_decode($characteristic->ua_name, 1))['name'] . ' ' .
                    (json_decode($characteristic->ru_name, 1))['name']
            ]);
        }
    }
}
