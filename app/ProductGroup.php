<?php

namespace App;

use App\Traits\Commentable;
use LaravelLocalization;
use Spatie\SchemaOrg\Schema;

class ProductGroup extends Resource
{
    use Commentable;

    public function getNameAttribute()
    {
        return $this->getData('name');
    }

    public function getSdCodeAttribute()
    {
        return $this->getDetails('sd_code');
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description'] ?? $this->attributes['description'] =
                $this->getData('description') ??
                (($description = $this->characteristics->where('name', (LaravelLocalization::getCurrentLocale() == 'ru' ? 'Описание' : 'Опис'))->first())
                    ? $description->value
                    : null);
    }

    public function getMetaTitleAttribute()
    {
        return $this->getData('meta_title');
    }

    public function getMainImagePathAttribute()
    {
        $path = public_path("storage/product/{$this->sdCode}");
        $mainImagePath = "/storage/product/{$this->sdCode}/{$this->sdCode}.jpg";

        if(!file_exists(public_path($mainImagePath)) && file_exists($path)) {
            $mainImagePath = "/storage/product/{$this->sdCode}/additional/{$this->sdCode}_1.jpg";

            if (!file_exists(public_path($mainImagePath))) {
                $dirPath = public_path("storage/product/{$this->sdCode}");
                $dir = scandir($dirPath);

                for ($i = 0; $i < count($dir); $i++) {
                    if (
                        is_dir($dirPath . '/' . $dir[$i]) &&
                        $dir[$i] != '.' &&
                        $dir[$i] != '..' &&
                        $dir[$i] != 'additional'
                    ) {
                        $sku = $dir[$i];
                        break;
                    }
                }

                $mainImagePath = "/storage/product/{$this->sdCode}/{$sku}/{$sku}_1.jpg";
            }
        }

        return $mainImagePath;
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
            return $query->select('*')->joinLocalization()->withAncestors();
        }]);
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'details->ref', 'details->category_id');
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

    public function productsSort()
    {
        return $this->hasMany(ProductSort::class, 'details->sd_code', 'details->sd_code');
    }

    public function scopeWithProductsSort($query)
    {
        return $query->with(['productsSort' => function($query) {
            return $query->whereHas('products', function ($query) {
                $query->where('details->balance', '>', 0);
            })->withProducts();
        }]);
    }
}
