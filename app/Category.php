<?php

namespace App;

use Kalnoy\Nestedset\NodeTrait;

class Category extends Resource
{
    use NodeTrait;

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
}
