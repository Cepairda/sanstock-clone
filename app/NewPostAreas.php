<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewPostAreas extends Model
{
    use SoftDeletes;

    protected $table = 'np_areas';

    protected $fillable = [
        'ref',
        'areas_center',
        'status',
    ];

    public $timestamps = true;
}
