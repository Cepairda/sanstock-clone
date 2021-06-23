<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regions extends Model
{
    use SoftDeletes;

    protected $table = 'regions';

    protected $fillable = [
        'ref',
        'description',
        'rr_price_type_ref',
        'available_for_registration',
        'email',
        'maximum_number_of_days_without_an_order',
        'oddment_id',
    ];

    public $timestamps = true;

    public $dates = ['deleted_at'];

}
