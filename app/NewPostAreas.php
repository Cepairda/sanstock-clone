<?php

namespace App;

class NewPostAreas extends Resource
{
    protected $table = 'np_areas';

    protected $fillable = [
        'ref',
        'areas_center',
        'status',
    ];

    public $timestamps = true;
}
