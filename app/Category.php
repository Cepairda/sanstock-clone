<?php

namespace App;

use Kalnoy\Nestedset\NodeTrait;

class Category extends Resource
{
    use NodeTrait;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'resource_resource',
            'relation_id', 'resource_id')
            ->where('relation_type', Product::class);
    }
}
