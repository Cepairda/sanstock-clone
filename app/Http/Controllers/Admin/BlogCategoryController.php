<?php

namespace App\Http\Controllers\Admin;

use App\BlogCategory;
use App\Http\Controllers\Admin\Resource\isResource;

class BlogCategoryController
{
    use isResource;

    public function __construct(BlogCategory $blogCategory)
    {
        $this->resource = $blogCategory;
    }
}
