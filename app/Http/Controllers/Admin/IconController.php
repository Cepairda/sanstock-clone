<?php

namespace App\Http\Controllers\Admin;

use App\Icon;
use App\Http\Controllers\Admin\Resource\isResource;

class IconController
{
    use isResource;

    public function __construct(Icon $icon)
    {
        $this->resource = $icon;
    }

    public function createSearchString(){}
}
