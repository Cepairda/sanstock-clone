<?php

namespace App;

use Awobaz\Compoships\Compoships;
use LaravelLocalization;

class Product extends Resource
{
    use Compoships;

    public function getNameAttribute()
    {
        return $this->getData('name');
    }

    public function getDescriptionAttribute()
    {
        return $this->getData('description');
    }

    public function getCategoryIdAttribute()
    {
        return $this->getDetails('category_id');
    }

    public function getSkuAttribute()
    {
        return $this->getDetails('sku');
    }

    public function getSdCodeAttribute()
    {
        return $this->getDetails('sd_code');
    }

    public function getBalanceAttribute()
    {
        return $this->getDetails('balance');
    }

    public function getGradeAttribute()
    {
        return $this->getDetails('grade');
    }

    public function getAllDefectiveImagesAttribute()
    {
        $additional = $this->defectiveImages;

        if (isset($additional) && $additional->getDetails('additional')) {
            return $additional->getDetails('additional');
        }

        return [];
    }

    public function defectiveImages()
    {
        return $this->hasOne(ProductImage::class, 'details->product_sku', 'details->sku');
    }

    public function productSort()
    {
        return $this->hasOne(ProductSort::class,  ['details->sd_code', 'details->grade'], ['details->sd_code', 'details->grade']);
    }

//    public function scopeWithProductsSort($query)
//    {
//        return $query->with(['productSort' => function($query) {
//            return $query->whereHas('products', function ($query) {
//                $query->where('details->balance', '>', 0);
//            })->withProducts();
//        }]);
//    }

    public function scopeWithProductsSort($query)
    {
        return $query->with(['productSort' => function($query) {
            return $query->withProductGroup();
        }]);
    }
}
