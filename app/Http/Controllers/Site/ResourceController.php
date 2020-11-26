<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Product;
use App\Resource;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    public function getResource($slug)
    {
        $resource = Resource::withoutGlobalScopes()
            ->joinLocalization()
            ->where('slug', $slug)
            ->where('deleted_at', null)
            ->firstOrFail();
        $viewPath = Str::lower(class_basename($resource->type));
        $resource = $resource->type::find($resource->id);

        return view('site.' . $viewPath . '.show', compact('resource'));
    }
}
