<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewPostWarehouses extends Model
{
    use SoftDeletes;

    protected $table = 'np_warehouses';

    protected $fillable = [
        'ref',
        'city_ref',
        'site_key',
        'type_of_warehouse'
    ];

    public $timestamps = true;
}
