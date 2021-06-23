<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'status',
    ];

    public $timestamps = true;

    /**
     * Order Products
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany('App\OrderProduct', 'order_id', 'id');
    }

    /**
     * Order Products
     * @return HasOne
     */
    public function shipping(): HasOne
    {
        return $this->hasOne('App\OrderShipping', 'order_id', 'id');
    }
}
