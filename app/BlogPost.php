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

    public function getImgAttribute()
    {
        return $this->getData('img');
    }

    public function getTextAttribute()
    {
        return $this->getData('text');
    }

    public function getMetaTitleAttribute()
    {
        return $this->getData('meta_title');
    }

    public function getMetaDescriptionAttribute()
    {
        return $this->getData('meta_description');
    }

    public function scopeWithCategories($query, $joinLocalization = true)
    {
        return $query->with(['categories' => function ($query) use ($joinLocalization) {
            if ($joinLocalization) return $query->joinLocalization();
        }]);
    }

    public function scopeWithTags($query, $joinLocalization = true)
    {
        return $query->with(['tags' => function ($query) use ($joinLocalization) {
            if ($joinLocalization) return $query->select('*')->joinLocalization()->where('details->published', 1);
        }]);
    }

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'resource_resource',
            'resource_id', 'relation_id')
            ->where('relation_type', BlogCategory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'resource_resource',
            'resource_id', 'relation_id');
    }
}
