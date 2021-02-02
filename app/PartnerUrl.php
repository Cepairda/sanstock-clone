<?php

namespace App;

class PartnerUrl extends Resource
{
    public function getUrlAttribute()
    {
        return $this->getDetails('url');
    }

    public function partner()
    {
        return $this->hasOne(Partner::class, 'id', 'details->partner_id');
    }
}
