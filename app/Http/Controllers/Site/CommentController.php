<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;
use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use isResource;

    public function __construct(Comment $comment)
    {
        $this->resource = $comment;
    }

    public function store()
    {
        $this->resource->storeOrUpdate();

        return back();
    }
}
