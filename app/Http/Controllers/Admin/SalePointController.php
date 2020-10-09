<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\SalePoint;

class SalePointController extends Controller
{
    use isResource;

    public function __construct(SalePoint $salePoint)
    {
        $this->resource = $salePoint;
    }
}
