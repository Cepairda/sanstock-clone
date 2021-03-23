<?php

namespace App\Http\Controllers\Admin;

use App\BlogTag;
use App\Http\Controllers\Admin\Resource\isResource;

class BlogTagController
{
    use isResource;

    public function __construct(BlogTag $blogTag)
    {
        $this->resource = $blogTag;
    }

    public function createSearchString(){}
}
