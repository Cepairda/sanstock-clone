<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Product;

class ProductController extends Controller
{
    use isResource;

    public function __construct(Product $product)
    {
        $this->resource = $product;
    }

    public function importImages()
    {
        $products = Product::select(['details->sku as sku'])->get();

        //print_r($products);
        echo $products[860]->sku;
        //ImageController::mass_download($products);
    }
}
