<?php

namespace App;

class Page extends Resource
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

    public function getMetaTitleAttribute()
    {
        return $this->getData('meta_title');
    }

    public function getMetaDescriptionAttribute()
    {
        return $this->getData('meta_description');
    }
}
