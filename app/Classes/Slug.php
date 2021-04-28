<?php

namespace App\Classes;

use Illuminate\Support\Str;

class Slug
{
    /**
     * @param string $resource full namespace to class. Example 'App\Brand'
     * @param string $name name for new slug
     * @param int|null $id id from Resource Table
     *
     * @return string
     */
    public static function create(string $resource, string $name, int $id = null)
    {
        $originalSlug = '';
        $slugs = explode('/', $name);

        foreach ($slugs as $slug) {
            $originalSlug .= Str::slug($slug) . '/';
        }

        $slug = rtrim($originalSlug, '/');
        $i = 0;

        while ($resourceId = $resource::whereSlug($slug)->where('id', '!=', $id)->first()) {
               $slug .= '-' . ++$i;
        }

        return $slug;
    }
}
