<?php

namespace App\Traits;

use App\Comment;

trait Commentable
{
    public function scopeWithComments($query)
    {
        return $query->with(['comments' => function ($query) {
            return $query->latest();
        }, 'comments.replies']);
    }

    public function scopeWithReviews($query)
    {
        return $query->with(['reviews' => function ($query) {
            return $query->latest();
        }, 'reviews.replies']);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'details->resource_id', 'id')
            ->whereNull('parent_id')
            ->where('details->status', 1)
            ->where('details->type', 1);
    }

    public function reviews()
    {
        return $this->hasMany(Comment::class, 'details->resource_id', 'id')
            ->whereNull('parent_id')
            ->where('details->status', 1)
            ->where('details->type', 2);
    }
}
