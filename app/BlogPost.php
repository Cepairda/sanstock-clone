<?php

namespace App;

class BlogPost extends Resource
{
    public function getNameAttribute()
    {
        return $this->getData('name');
    }

    public function getDescriptionAttribute()
    {
        return $this->getData('description');
    }

    public function getTextAttribute()
    {
        return $this->getData('text');
    }

    public function scopeWithCategories($query, $joinLocalization = true)
    {
        return $query->with(['categories' => function ($query) use ($joinLocalization) {
            if ($joinLocalization) return $query->joinLocalization();
        }]);
    }

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'resource_resource',
            'resource_id', 'relation_id')
            ->where('relation_type', BlogCategory::class);
    }
}
