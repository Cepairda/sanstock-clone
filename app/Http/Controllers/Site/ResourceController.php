<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Resource;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    public function getResource($slug)
    {

        $resource = Resource::withoutGlobalScopes()->joinLocalization()->where('slug', $slug)->where('deleted_at', null)->firstOrFail();

        $view = Str::lower(class_basename($resource->type));

        return view('site.' . $view . '.show', compact('resource'));

    }
}
