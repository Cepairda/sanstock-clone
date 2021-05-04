<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewPostSettlements extends Model
{
    protected $table = 'np_settlements';

    protected $fillable = [
        'ref',
        'area_ref',
        'settlement_type',
    ];

    public $timestamps = true;
}
