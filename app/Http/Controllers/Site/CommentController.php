<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;
use App\Comment;
use Illuminate\Http\Request;
use App\Setting;

class CommentController extends Controller
{
    use isResource;

    public function __construct(Comment $comment)
    {
        $this->resource = $comment;
    }

    public function store(Request $request)
    {
        $setting = Setting::first();

        $request->validate([
            'attachment' => 'max:' . ($setting->details['comments']['files']['count'] ?? 5),
            'attachment.*' => 'max: ' . ($setting->details['comments']['files']['size'] ?? 1000),
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
        //Comment::where('id', $comment->id)->update(['details->test' => $attachments]);

        //dd($comment);
        //dd($request->all());
//        $data['details']['attachment'][0] = '1.jpg';
//        $data['details']['attachment'][1] = '2.jpg';
//        $request->merge($data);
//        dd($request->all());
//

        /*if ($request->hasFile('attachment')) {
            foreach ($files as $file) {
                $file->store('comments/' . $comment->id);
            }
        }*/

        return back();
    }
}
