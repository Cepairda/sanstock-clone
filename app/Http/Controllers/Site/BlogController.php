<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\HtmlBlock;
use App\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::joinLocalization()->paginate(12);

        return view('site.blog.index', compact('posts'));
    }

    public function post($slug)
    {
        $post = BlogPost::joinLocalization()->whereSlug($slug)->firstOrFail();

        return HtmlBlock::replaceShortCode(view('site.blog.article', compact('post'))->render());
    }
}
