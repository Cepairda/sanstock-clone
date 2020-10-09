<?php

namespace App\Http\Controllers\Admin;

use App\Characteristic;
use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;

class CharacteristicController extends Controller
{
    use isResource;

    public function __construct(Characteristic $characteristic)
    {
        $this->resource = $characteristic;
    }
}
