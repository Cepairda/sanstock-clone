<?php

namespace App;

class BlogTag extends Resource
{
    public function getNameAttribute()
    {
        return $this->getData('name');
    }
}
