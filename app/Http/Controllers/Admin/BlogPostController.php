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

    public function edit($id)
    {
        $this->resource = $this->resource->joinLocalization()->withTags()->find($id);
        $form = $this->getForm();

        return view('admin.resources.create-or-edit', compact('form'));
    }

    public function createSearchString() {
        $blogPosts = $this->resource
            ->select('id', 'details', 'ua.data as ua_name', 'ru.data as ru_name')
            ->leftJoin('resource_localizations as ua', function($q) {
                $q->on('ua.resource_id', '=', 'resources.id')
                    ->where('ua.locale', 'uk');
            })
            ->leftJoin('resource_localizations as ru', function($q) {
                $q->on('ru.resource_id', '=', 'resources.id')
                    ->where('ru.locale', 'ru');
            })->get();

        foreach ($blogPosts as $blogPost) {
            BlogPost::where('id', $blogPost->id)->update([
                'search_string' =>
                    (json_decode($blogPost->ua_name, 1))['name'] . ' ' .
                    (json_decode($blogPost->ru_name, 1))['name']
            ]);
        }
    }
}
