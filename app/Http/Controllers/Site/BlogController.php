<?php

namespace App\Http\Controllers\Site;

use App\BlogTag;
use App\Http\Controllers\Controller;
use App\HtmlBlock;
use App\BlogPost;

class BlogController extends Controller
{
    public function index($tag = null)
    {
        $preparedPosts = BlogPost::joinLocalization()->withTags()->where('details->published', 1);

        if ($tag) {
            BlogTag::where('id', $tag)->where('details->published', 1)->firstOrFail();//Если тега не существует 404

            $preparedPosts->whereHas('tags', function ($q) use ($tag){
                $q->whereId($tag)->where('details->published', 1);
            });
        }

        $posts = $preparedPosts->paginate(12);
        $tags = BlogTag::joinLocalization()->where('details->published', 1)->get();

        return view('site.blog.index', compact('posts', 'tags'));
    }

    public function post($slug)
    {
        $post = BlogPost::joinLocalization()->withTags()->where('details->published', 1)->whereSlug($slug)->firstOrFail();

        return HtmlBlock::replaceShortCode(view('site.blog.article', compact('post'))->render());
    }
}
