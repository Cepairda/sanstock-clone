<?php

namespace App;

class OrderShipping extends Resource
{
    protected $table = 'order_shipping';

    protected $fillable = [
        'order_id',
        'areas_ref',
        'settlement_ref',
        'street_ref',
        'warehouse_ref',
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'email',
        'cashless_payment',
        'payments_form',
        'cash_sum',
        'company',
        'insurance_sum',
        'comments',
    ];

    public $timestamps = true;
}