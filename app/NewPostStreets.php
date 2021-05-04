<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewPostStreets extends Model
{
    use SoftDeletes;

    protected $table = 'np_streets';

    protected $fillable = [
        'ref',
        'streets_type_ref',
        'city_ref',
    ];

    public $timestamps = true;
}
