<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Resource;

class ResourceController extends Controller
{
    public function getResource($slug)
    {
        //echo $slug;
        //die();
        $resource = Resource::withoutGlobalScopes()->joinLocalization()->where('slug', $slug)->where('deleted_at', null)->firstOrFail();
        $view = Str::lower(class_basename($resource));

        dd($view);
    }
}
