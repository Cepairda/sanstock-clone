<?php

namespace App\Http\Controllers\Admin;

use App\BlogCategory;
use App\Http\Controllers\Admin\Resource\isResource;

class BlogCategoryController
{
    use isResource;

    public function __construct(BlogCategory $blogCategory)
    {
        $this->resource = $blogCategory;
    }

    public function createSearchString() {
        $blogCategories = $this->resource
            ->select('id', 'details', 'ua.data as ua_name', 'ru.data as ru_name')
            ->leftJoin('resource_localizations as ua', function($q) {
                $q->on('ua.resource_id', '=', 'resources.id')
                    ->where('ua.locale', 'uk');
            })
            ->leftJoin('resource_localizations as ru', function($q) {
                $q->on('ru.resource_id', '=', 'resources.id')
                    ->where('ru.locale', 'ru');
            })->get();

        foreach ($blogCategories as $blogCategory) {
            BlogCategory::where('id', $blogCategory->id)->update([
                'search_string' =>
                    (json_decode($blogCategory->ua_name, 1))['name'] . ' ' .
                    (json_decode($blogCategory->ru_name, 1))['name']
            ]);
        }
    }
}
