<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Admin\Resource\isResource;
use Illuminate\Support\Facades\Request;

class CommentController
{
    use isResource;

    public function __construct(Comment $comment)
    {
        $this->resource = $comment;
    }

    public function index()
    {
        //dd(Request::is('*comments*'));
        $resources = $this->resource->joinLocalization()->orderBy('id', 'desc');

        $resources = Request::is('*comments*')
            ? $resources->where('details->type', 1)
            : $resources->where('details->type', 2);

        if (Request::has('id')) {
            $resources = $resources->orderBy('id', Request::input('id'));
        } elseif (Request::has('created_at')) {
            $resources = $resources->orderBy('created_at', Request::input('created_at'));
        } elseif (Request::has('updated_at')) {
            $resources = $resources->orderBy('updated_at', Request::input('updated_at'));
        } elseif (Request::has('deleted_at')) {
            $resources = $resources->orderBy('deleted_at', Request::input('deleted_at'));
        }

        if (Request::has('search')) {
            $resources = $resources->where('search_string', 'like', '%' . Request::input('search') . '%');
        }

        if ($this->resource->usedNodeTrait()) {
            $resources = $resources->with('ancestors')->get()->toFlatTree()->append(Request::except('page'));
        } else {
            $resources = $resources->paginate(50)->appends(Request::except('page'));
        }

        return view('admin.resources.comments.index', compact('resources'));
    }

    public function createSearchString()
    {

    }
}
