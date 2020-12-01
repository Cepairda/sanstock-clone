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
}
