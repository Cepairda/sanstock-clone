<?php

namespace App;

class Icon extends Resource
{
    public function getNameAttribute()
    {
        return $this->getData('name');
    }

    public function getImageAttribute()
    {
        return $this->getData('img');
    }
}
