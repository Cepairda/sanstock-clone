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
                $resource = $resource->type::joinLocalization()->withCharacteristicValue()->whereId($resource->id)->first();
                break;
            default:
                $resource = $resource->type::joinLocalization()->whereId($resource->id)->first();
        }

        //Для примера Имя характеристики - значение характеристики
        //dd($resource->characteristics[0]->characteristic->getData('name') . ':' . $resource->characteristics[0]->getData('value'));

        return view('site.' . $type . '.show', [$type => $resource] ); //compact('resource')
    }
}
