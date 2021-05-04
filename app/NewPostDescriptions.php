<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewPostDescriptions extends Model
{
    use SoftDeletes;

    protected $table = 'np_descriptions';

    protected $fillable = [
        'locale',
        'affiliated_id',
        'group',
        'name',
        'type',
        'search',
    ];

    public $timestamps = false;
}
