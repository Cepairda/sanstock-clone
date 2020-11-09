<?php

namespace App\Http\Controllers\Admin;

use App\SmartFilter;
use App\Http\Controllers\Admin\Resource\isResource;

class SmartFilterController
{
    use isResource;

    public function __construct(SmartFilter $smartFilter)
    {
        $this->resource = $smartFilter;
    }
}
