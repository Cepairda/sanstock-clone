<?php

namespace App\Classes;

use App\Resource;
use Illuminate\Support\Str;

class Slug
{
    public static function create($resource, $name)
    {
        $originalSlug = Str::slug($name);
        $slug = $originalSlug;
        $i = 0;

        while ($resource::whereSlug($slug)->first()) {
            $slug = $originalSlug . '-' . ++$i;
        }

        return $slug;
    }
}
