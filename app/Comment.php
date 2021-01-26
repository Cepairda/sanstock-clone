<?php

namespace App;

class Comment extends Resource
{
    public function getStatusAttribute()
    {
        return +($this->getDetails('status'));
    }

    public function getBodyAttribute()
    {
        return $this->getDetails('body');
    }

    public function getNameAttribute()
    {
        return $this->getDetails('name');
    }

    public function getStarAttribute()
    {
        return +($this->getDetails('star'));
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')->where('details->status', 1)->where('parent_id', '!=', null);
    }
}
