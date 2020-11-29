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

    public function getNameAttribute()
    {
        return $this->attributes['name'] ?? $this->attributes['name'] = $this->getData('name');
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description'] ?? $this->attributes['description'] = $this->getData('description');
    }

    public function getPriceAttribute()
    {
        return $this->attributes['price'] ?? $this->attributes['price'] = $this->getDetails('price');
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

    public function scopeWithCharacteristics($query, $joinLocalization = true)
    {
        return $query->with(['characteristics' => function ($query) use ($joinLocalization) {
            if ($joinLocalization) return $query->select('*')->joinLocalization()->withCharacteristic();
        }]);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'resource_resource',
            'resource_id', 'relation_id')
            ->where('relation_type', Category::class);
    }

    public function characteristics()
    {
        return $this->belongsToMany(CharacteristicValue::class, 'resource_resource',
            'resource_id', 'relation_id')
            ->where('relation_type', CharacteristicValue::class);
    }
}
