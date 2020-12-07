<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Http\Controllers\Admin\Resource\isResource;

class PageController
{
    use isResource;

    public function __construct(Page $page)
    {
        $this->resource = $page;
    }

    public function createSearchString() {
        $pages = $this->resource
            ->select('id', 'details', 'ua.data as ua_name', 'ru.data as ru_name')
            ->leftJoin('resource_localizations as ua', function($q) {
                $q->on('ua.resource_id', '=', 'resources.id')
                    ->where('ua.locale', 'uk');
            })
            ->leftJoin('resource_localizations as ru', function($q) {
                $q->on('ru.resource_id', '=', 'resources.id')
                    ->where('ru.locale', 'ru');
            })->get();

        foreach ($pages as $page) {
            Page::where('id', $page->id)->update([
                'search_string' =>
                    (json_decode($page->ua_name, 1))['name'] . ' ' .
                    (json_decode($page->ru_name, 1))['name']
            ]);
        }
    }
}
