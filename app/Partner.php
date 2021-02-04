<?php

namespace App;

class Partner extends Resource
{
    public function getImgAttribute()
    {
        return $this->getDetails('img');
    }
}
