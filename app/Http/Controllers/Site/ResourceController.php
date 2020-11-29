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
            ->where('slug', $slug)
            ->where('deleted_at', null)
            ->firstOrFail();

        $type = Str::lower(class_basename($resource->type));

        switch ($type) {
            case 'product':
                $data = [
                    'product' => $resource->type::joinLocalization()->withCharacteristics()->whereId($resource->id)->first()
                ];
                break;
            case 'category':
                $data = [
                    'category' => $category = $resource->type::joinLocalization()->whereId($resource->id)->first(),
                    'products' => Product::joinLocalization()->whereExistsCategoryIds($category->id)->paginate()
                ];
                break;
            default:
                $data = [
                    'resource' => $resource->type::joinLocalization()->whereId($resource->id)->first()
                ];
        }

        return view('site.' . $type . '.show', $data);
    }
}
