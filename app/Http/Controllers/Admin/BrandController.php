<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Http\Controllers\Admin\Resource\isResource;

class BrandController
{
    use isResource;

    public function __construct(Brand $brand)
    {
        $this->resource = $brand;
    }
}
