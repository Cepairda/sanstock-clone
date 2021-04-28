<?php

namespace App;

class OrderProduct extends Resource
{
    protected $table = 'order_product';

    protected $fillable = [
        'order_id',
        'product_barcode',
        'details',
    ];

    public $timestamps = true;
}
