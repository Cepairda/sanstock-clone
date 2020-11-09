<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Http\Controllers\Admin\Resource\isResource;

class PageController
{
    use isResource;

    public function __construct(Page $page)
    {
        $this->resource = $page;
    }
}
