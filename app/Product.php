<?php

namespace App;

use LaravelLocalization;

class Product extends Resource
{
    protected $appends = ['main_image', 'additional_image'];

    public function getMainImageAttribute(){

    }

    public function getAdditionalImageAttribute(){

    }

    public function getRelatedAttribute()
    {
        return $this->attributes['related'] ?? $this->attributes['related'] =
                self::where('details->category_id', $this->getDetails('category_id'))->
                whereType(self::class)->where('id', '!=', $this->id)->inRandomOrder()->take(4)->get();
    }

    public function scopeWithCategories($query, $joinLocalization = true)
    {
        return $query->with(['categories' => function ($query) use ($joinLocalization) {
            if ($joinLocalization) return $query->joinLocalization();
        }]);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'resource_resource',
            'resource_id', 'relation_id')
            ->where('relation_type', Category::class);
    }

//    public function scopeWithCharacteristics($query)
//    {
//        return $query->with(['characteristics' => function($query) {
//            return $query->joinLocalization('ru');
//        }]);
//    }

    public function characteristics()
    {
//        return $this->hasMany(ResourceResource::class, 'resource_id', 'id')
//            ->where('relation_type', CharacteristicValue::class)
//            ->join('', '', '');
        return $this->belongsToMany(CharacteristicValue::class, 'resource_resource',
            'resource_id', 'relation_id')
            ->where('relation_type', CharacteristicValue::class)->joinLocalization('ru');
    }
}
