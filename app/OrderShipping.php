<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderShipping extends Model
{
    protected $table = 'order_shipping';

    protected $fillable = [
        'order_id',
        'areas_ref',
        'settlement_ref',
        'street_ref',
        'house',
        'apartment',
        'warehouse_ref',
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'cashless_payment',
        'payments_form',
        'cash_sum',
        'company',
        'insurance_sum',
        'comments',
    ];

    public $timestamps = true;
}
