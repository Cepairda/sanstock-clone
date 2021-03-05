<?php

namespace App\Http\Controllers\Admin;

use App\HtmlBlock;
use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;

class HtmlBlockController extends Controller
{
    use isResource;

    public function __construct(HtmlBlock $htmlBlockController)
    {
        $this->resource = $htmlBlockController;
    }

    public function createSearchString()
    {

    }
}
