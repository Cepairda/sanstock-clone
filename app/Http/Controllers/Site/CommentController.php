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

    public function store(Request $request)
    {
        $request->validate([
            'attachment' => 'max:' . (config('settings.comments.files.count') ?? 5),
            'attachment.*' => 'max: ' . (config('settings.comments.files.size') ? config('settings.comments.files.size') * 1024 : 1024),
            'details.name' => 'required',
            'details.phone' => 'required_without:details.email',
            'details.email' => 'required_without:details.phone',
            'details.body' => 'required',
        ]);

        $files = $request->file('attachment');
        $attachments = [];

        $comment = $this->resource->storeOrUpdate();

        if ($request->hasFile('attachment')) {
            foreach ($files as $file) {
                $attachments[] = $file->storePublicly('comments/' . $comment->id, 'public');
            }
        }

        $comment->details = array_merge(json_decode($comment->details, true), ['attachment' => $attachments]);
        $comment->save();

        return back();
    }
}
