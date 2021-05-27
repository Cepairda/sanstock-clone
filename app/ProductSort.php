<?php

namespace App;

use App\Traits\Commentable;
use Awobaz\Compoships\Compoships;
use LaravelLocalization;
use Carbon\Carbon;
use Spatie\SchemaOrg\Schema;

class ProductSort extends Resource
{
    use Compoships;

    protected $appends = ['price_updated_at'];
    protected $markup = [3, 10, 15, 20];

    public function getNameAttribute()
    {
        return $this->getData('name');
    }

    public function getNormalPriceAttribute()
    {
        return $this->oldPrice ?: $this->price * (100 + $this->markup[$this->grade]) / 100;
    }

    public function getDifferencePriceAttribute()
    {
        return $this->normalPrice - $this->price;
    }

    public function getSkuAttribute()
    {
        return $this->getDetails('sku');
    }

    public function getSdCodeAttribute()
    {
        return $this->getDetails('sd_code');
    }

    public function getGradeAttribute()
    {
        return $this->getDetails('grade');
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description'] ?? $this->attributes['description'] =
                $this->getData('description') ??
                (($description = $this->characteristics->where('name', (LaravelLocalization::getCurrentLocale() == 'ru' ? 'Описание' : 'Опис'))->first())
                    ? $description->value
                    : null);
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

    public function getMetaTitleAttribute()
    {
        return $this->getData('meta_title');
    }

    public function getMetaDescriptionAttribute()
    {
        return $this->getData('meta_description');
    }

    public function getRelatedAttribute()
    {
        return $this->attributes['related'] ?? $this->attributes['related'] =
                self::where('details->category_id', $this->getDetails('category_id'))->
                whereType(self::class)->where('id', '!=', $this->id)->inRandomOrder()->take(4)->get();
    }

    public function scopeWhereExistsCategoryIds($query, $categoryIds)
    {
        $categoryIds = (is_object($categoryIds) || is_array($categoryIds)) ? $categoryIds : [$categoryIds];
        return $query->whereExists(function ($query) use ($categoryIds) {
            return $query->select('resource_resource.resource_id')->from('resource_resource')
                ->whereRelationType(Category::class)->whereResourceType(self::class)
                ->whereRaw('resource_resource.resource_id = resources.id')
                ->whereIn('resource_resource.relation_id', $categoryIds);
        });
    }

    public function scopeWithCategories($query, $joinLocalization = true)
    {
        return $query->with(['categories' => function ($query) use ($joinLocalization) {
            if ($joinLocalization) return $query->joinLocalization();
        }]);
    }

    public function scopeWithCharacteristics($query, $joinLocalization = true)
    {
        return $query->with(['characteristics' => function ($query) use ($joinLocalization) {
            if ($joinLocalization) return $query->select('*')->joinLocalization()->withCharacteristic();
        }]);
    }

    public function scopeWithRelateProducts($query, $joinLocalization = true)
    {
        return $query->with(['relateProducts' => function ($query) use ($joinLocalization) {
            if ($joinLocalization) return $query->select('*')->joinLocalization();
        }, 'relateProducts.icons']);
    }

    public function scopeWithIcons($query, $joinLocalization = true)
    {
        return $query->with(['icons' => function ($query) use ($joinLocalization) {
            if ($joinLocalization) return $query->select('*')->joinLocalization();
        }]);
    }

    public function scopeWithPartnerUrl($query)
    {
        return $query->with(['partnersUrl' => function($query) {
            return $query->joinLocalization();
        }, 'partnersUrl.partner']);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'resource_resource',
            'resource_id', 'relation_id')
            ->where('relation_type', Category::class);
    }

    public function characteristics()
    {
        return $this->belongsToMany(CharacteristicValue::class, 'resource_resource',
            'resource_id', 'relation_id')
            ->where('relation_type', CharacteristicValue::class);
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

    public function relateProducts()
    {
        return $this->belongsToMany(Product::class, 'resource_resource',
            'resource_id', 'relation_id')
            ->where('relation_type', Product::class)
            ->where('details->price', '>' , 0)
            ->where('details->published', 1);
    }

    public function icons()
    {
        return $this->belongsToMany(Icon::class, 'resource_resource',
            'resource_id', 'relation_id');
    }

    public function partnersUrl()
    {
        return $this->hasMany(PartnerUrl::class, 'details->sku', 'details->sku');
    }

    public function stars()
    {
        return +$this->getDetails('enable_stars') ?? null;
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
            if ($joinLocalization) return $query->select('*')->joinLocalization();
        }]);
    }

    public function products()
    {
        return $this->hasMany(Product::class, ['details->sd_code', 'details->grade'], ['details->sd_code', 'details->grade']);
    }
}
