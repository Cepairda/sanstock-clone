<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
    use isResource;

    public function __construct(Product $product)
    {
        $this->resource = $product;
    }
}
