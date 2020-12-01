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

    public function getSkuAttribute()
    {
        return $this->attributes['sku'] ?? $this->attributes['sku'] = $this->getDetails('sku');
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description'] ?? $this->attributes['description'] =
                $this->getData('description') ??
                $this->characteristics->where('name', (LaravelLocalization::getCurrentLocale() == 'ru' ? 'Описание' : 'Опис'))->first()->value;
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

    public function scopeWhereExistsCategoryIds($query, $categoryIds)
    {
        $categoryIds = (is_object($categoryIds) || is_array($categoryIds)) ? $categoryIds : [$categoryIds];
        return $query->whereExists(function ($query) use ($categoryIds) {
            return $query->select('resource_resource.resource_id')->from('resource_resource')
                ->whereRelationType(Category::class)->whereResourceType(self::class)
                ->whereRaw('resource_resource.resource_id = resources.id')
                ->whereIn('resource_resource.relation_id', $categoryIds);
        });
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

    public function scopeWithCategory($query)
    {
        return $query->with(['category' => function($query) {
            return $query->joinLocalization()->withAncestors();
        }]);
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'details->category_id');
    }
}
