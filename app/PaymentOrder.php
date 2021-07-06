<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentOrder extends Model
{
    protected $table = 'payment_order';

    protected $casts = [
        'details' => 'collection'
    ];

    protected $fillable = [
        'order_id',
        'payment_method',
        'status',
        'attempts',
        'details'
    ];

    public $timestamps = true;
}
