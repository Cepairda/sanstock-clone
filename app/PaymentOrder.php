<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentOrder extends Model
{
    protected $table = 'payment_order';

    protected $fillable = [
        'order_id',
        'payment_method',
        'status',
    ];

    public $timestamps = true;
}
