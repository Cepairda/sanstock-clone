<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\User;
use App\BlogPost;
use App\Notifications\ContactForm;
use Illuminate\Http\Request;

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
