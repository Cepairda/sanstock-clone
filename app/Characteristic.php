<?php

namespace App;

class Characteristic extends Resource
{
    public function getPublishedAttribute()
    {
        return $this->getDetails('published');
    }
}
