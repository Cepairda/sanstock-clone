<?php

namespace App;

use Awobaz\Compoships\Compoships;
use LaravelLocalization;
use Carbon\Carbon;
use Spatie\SchemaOrg\Schema;

class ProductSort extends Resource
{
    use Compoships;

    protected $appends = ['price_updated_at'];
    //protected $markup = [3, 10, 15, 20];

    public function getNormalPriceAttribute()
    {
        return $this->oldPrice;// ?: $this->price * (100 + $this->markup[$this->grade]) / 100;
    }

    public function getDifferencePriceAttribute()
    {
        return $this->normalPrice - $this->price;
    }

    public function getSdCodeAttribute()
    {
        return $this->getDetails('sd_code');
    }

    public function getGradeAttribute()
    {
        return $this->getDetails('grade');
    }

    public function getPriceAttribute()
    {
        return +($this->getDetails('price'));
    }

    public function getOldPriceAttribute()
    {
        return +($this->getDetails('old_price'));
    }

    public function getPriceUpdatedAtAttribute()
    {
        return Carbon::parse($this->getDetails('price_updated_at'), config('timezone'));
    }

    public function scopeWithCategories($query, $joinLocalization = true)
    {
        return $query->with(['categories' => function ($query) use ($joinLocalization) {
            if ($joinLocalization) return $query->joinLocalization();
        }]);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'resource_resource',
            'resource_id', 'relation_id')
            ->where('relation_type', Category::class);
    }

    public function scopeWithCategory($query)
    {
        return $query->with(['category' => function($query) {
            return $query->joinLocalization()->withAncestors();
        }]);
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'details->category_id');
    }

    public function getJsonLd()
    {
        return Schema::product()
            ->name($this->name)
            ->sku($this->sku)
            ->mpn($this->sku)
            ->url(LaravelLocalization::getLocalizedURL())
            ->category($this->category->name ?? null)
            //->image(url('image' . $this->sku))
            ->brand(
                Schema::brand()
                    ->name('Lidz')
                    ->logo(asset('images/site/logo.svg'))
            )
            ->manufacturer('Lidz')
            ->itemCondition('NewCondition')
            ->description($this->description)
            ->offers(
                Schema::offer()
                    ->availability('https://schema.org/InStock')
                    ->url(LaravelLocalization::getLocalizedURL())
                    ->priceValidUntil((date('Y') + 1) . '-05-31')
                    ->price($this->price)
                    ->priceCurrency('UAH')
            )
            ->toScript();
    }

    public function scopeWithProductGroup($query, $joinLocalization = true)
    {
        return $query->with(['productGroup' => function ($query) use ($joinLocalization) {
            if ($joinLocalization) return $query->select('*')->joinLocalization();
        }]);
    }


    public function productGroup()
    {
        return $this->hasOne(ProductGroup::class, 'details->sd_code', 'details->sd_code');
    }

    public function scopeWithProducts($query, $joinLocalization = true)
    {
        return $query->with(['products' => function ($query) use ($joinLocalization) {
            if ($joinLocalization) {
                return $query->select('*')->where('details->balance', '>', 0)->joinLocalization();
            }
        }]);
    }

//    public function products()
//    {
//        //return $this->hasMany(Product::class, ['details->sd_code', 'details->grade'], ['details->sd_code', 'details->grade'])->where('details->balance', '>', 0)->limit(10);
//    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'resource_resource',
            'relation_id', 'resource_id')->where('details->balance', '>', 0);
    }

    public function scopeWithNotShowProductsBalanceZero($query, $joinLocalization = true)
    {
        return $query->whereHas('balance', function ($query) {
            $query->where('details->balance', '>', 0);
        });
    }

    public function balance()
    {
        return $this->belongsToMany(Product::class, 'resource_resource',
            'relation_id', 'resource_id')
            ->where('resource_type', Product::class);
    }
}
