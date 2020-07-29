<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Admin\Resource\isResource;

class CategoryController
{
    use isResource;

    public function __construct(Category $category)
    {
        $this->resource = $category;
    }
}
