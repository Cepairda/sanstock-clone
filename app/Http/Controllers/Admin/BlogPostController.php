<?php

namespace App\Http\Controllers\Admin;

use App\BlogPost;
use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;


class BlogPostController extends Controller
{
    use isResource;

    public function __construct(BlogPost $blogPost)
    {
        $this->resource = $blogPost;
    }

}
