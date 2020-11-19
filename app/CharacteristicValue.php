<?php

namespace App;

class CharacteristicValue extends Resource
{
    public function scopeWhereCharacteristicIsFilter($query, $characteristicIds = null)
    {
        if (isset($characteristicIds)) {
            $query->whereIn('details->characteristic_id', $characteristicIds);
        } else {

            $query->whereExists(function ($query) {

                $query->select('id as characteristic_id')->from('resources as characteristics')
                    ->where('type', 'App\Characteristic')
                    ->whereRaw('characteristic_id = details->characteristic_id')
                    ->where('characteristics.details->is_filter', true);
            });
        }
    }
}
