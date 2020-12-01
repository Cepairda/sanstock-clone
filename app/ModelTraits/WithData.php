<?php

namespace App\ModelTraits;

use Illuminate\Support\Str;
use LaravelLocalization;

trait WithData
{
    public function getClassName()
    {
        return class_basename(__CLASS__);
    }

    public function getDataClassNamespace()
    {
        return __CLASS__ . 'Data';
    }

    public function getClassNameSnake()
    {
        return Str::snake($this->getClassName());
    }

    public function getTableName()
    {
        return Str::plural($this->getClassNameSnake());
    }

    public function getDataTableName()
    {
        return $this->getClassNameSnake() . '_data';
    }

    public function getForeignKey()
    {
        return $this->getClassNameSnake() . '_id';
    }

    public function getDataByLocaleAttribute()
    {
        if (!isset($this->attributes['data_by_locale'])) {
            $this->attributes['data_by_locale'] = $this->getRelationValue('data')->keyBy('locale');
        }
        return $this->attributes['data_by_locale'];
    }

    public function scopeJoinData($query, $locale = null)
    {
        return $query->leftJoin($this->getDataTableName(), function ($query) use ($locale) {
            $query->on($this->getDataTableName() . '.' . $this->getForeignKey(), $this->getTableName() . '.id')
                ->whereLocale(isset($locale) ? $locale : LaravelLocalization::getCurrentLocale());
        });
    }

    public function scopeWithData($query)
    {
        return $query->with('data');
    }

    public function scopeWhereAlias($query, $url)
    {
        $query->whereHas('alias', function ($query) use ($url) {
            $query->where('url', $url);
        });
    }

    public function data()
    {
        return $this->hasMany($this->getDataClassNamespace(), $this->getForeignKey(), 'id');
    }

    public function scopeWithAlias($query)
    {
        return $query->with('alias');
    }

    public function alias()
    {
        return $this->hasOne('App\Alias', 'id', 'alias_id');
    }
}