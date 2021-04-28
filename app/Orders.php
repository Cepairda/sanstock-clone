<?php

namespace App;

class Orders extends Resource
{
    protected $table = 'orders';

    protected $fillable = [
        'status',
    ];

    public $timestamps = true;
}
