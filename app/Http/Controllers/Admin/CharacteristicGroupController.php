<?php

namespace App\Http\Controllers\Admin;

use App\CharacteristicGroup;
use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;

class CharacteristicGroupController extends Controller
{
    use isResource;

    public function __construct(CharacteristicGroup $characteristicGroup)
    {
        $this->resource = $characteristicGroup;
    }
}
