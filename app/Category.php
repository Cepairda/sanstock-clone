<?php

namespace App;

use Kalnoy\Nestedset\NodeTrait;

class Category extends Resource
{
    use NodeTrait;

    public function getNameAttribute()
    {
        return $this->getData('name');
    }

    public function getDescriptionAttribute()
    {
        return $this->getData('description');
    }

    public function scopeWithCharacteristicGroup($query, $withCharacteristicGroupCharacteristic = true)
    {
        return $query->with(['characteristic_group' => function ($query) use ($withCharacteristicGroupCharacteristic) {
            //if ($withCharacteristicGroupCharacteristic) $query->withCharacteristicGroupCharacteristic();
            $query;
        }]);
    }

    public function characteristic_group()
    {
        return $this->belongsToMany(CharacteristicGroup::class, 'resource_resource',
            'relation_id', 'resource_id')
            ->where('resource_type', CharacteristicGroup::class);
    }

    public function scopeWithAncestors($query)
    {
        return $query->with(['ancestors' => function ($query) {
            return $query->joinLocalization();
        }]);
    }

    public function scopeWithDescendants($query)
    {
        return $query->with(['descendants' => function ($query) {
            return $query->with('product')->joinLocalization()->where('details->published', 1);
        }]);
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'details->category_id', 'id')->where('details->published', 1);
    }
}
