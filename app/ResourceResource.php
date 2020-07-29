<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceResource extends Model
{
    protected $table = 'resource_resource';
    protected $fillable = ['resource_id', 'relation_id', 'resource_type', 'relation_type'];
    public $timestamps = false;
}
