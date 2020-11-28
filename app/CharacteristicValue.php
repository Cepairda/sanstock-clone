<?php

namespace App;

class CharacteristicValue extends Resource
{
    public function getCharacteristicIdAttribute()
    {
        return $this->getDetails('characteristic_id');
    }

    public function scopeWhereCharacteristicIsFilter($query, $characteristicIds = null)
    {
        if (isset($characteristicIds)) {
            $query->whereIn('details->characteristic_id', $characteristicIds);
        } else {
            $query->whereExists(function ($query) {
                $query->select('id as characteristic_ida')->from('resources as characteristics')
                    ->where('type', 'App\Characteristic')
                    ->whereRaw('json_unquote(json_extract(`resources`.`details`, "$.characteristic_id")) = `characteristics`.`id`')
                    ->where('characteristics.details->is_filter', '1');
            });
        }
    }

    public function scopeWithCharacteristic($query, $joinLocalization = true)
    {
        return $query->with(['characteristic' => function ($query) use ($joinLocalization) {
            if ($joinLocalization) return $query->select('*')->joinLocalization();
        }]);
    }

    public function characteristic()
    {
        return $this->belongsTo('App\Characteristic', 'characteristic_id', 'id');
    }
}
