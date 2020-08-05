<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelLocalization;
use Illuminate\Support\Str;

class Resource extends Model
{
    use SoftDeletes;

    protected $table = 'resources';

    protected $fillable = [
        'type', 'slug', 'details', 'parent_id'
    ];

    protected $casts = [
        'details' => 'collection',
        'data' => 'collection'
    ];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(function ($query) {
            $query->whereType(static::class);
        });
        static::creating(function ($query) {
            $query->type = static::class;
        });
    }

    public function getDetails($key)
    {
        return $this->details[$key] ?? null;
    }

    public function getData($key)
    {
        return $this->data[$key] ?? null;
    }

    public function scopeJoinLocalization($query, $locale = null)
    {
        return $query->leftJoin('resource_localizations', function ($query) use ($locale) {
            $query->on('resource_localizations.resource_id', 'resources.id')
                ->whereLocale($locale ?? LaravelLocalization::getCurrentLocale());
        });
    }

    public function usedNodeTrait()
    {
        return isset(class_uses($this)['Kalnoy\Nestedset\NodeTrait']) ? true : false;
    }

    public function storeOrUpdate()
    {
        $this->slug = request()->slug;
        $this->details = request()->details;
        $this->parent_id = request()->parent_id;
        $this->save();
        if ($this->usedNodeTrait()) {
            $this->fixTree();
        }
        ResourceLocalization::updateOrCreate([
            'resource_id' => $this->id,
            'locale' => LaravelLocalization::getCurrentLocale()
        ], [
            'data' => request()->data
        ]);
        $this->updateRelations();
        return $this;
    }

    public function storeOrUpdateImport($data)
    {git
        $this->slug = isset($data['name']) ? Str::slug($data['name']) : null;
        $this->save();

        ResourceLocalization::updateOrCreate([
            'resource_id' => $this->id,
            'locale' => LaravelLocalization::getCurrentLocale()
        ], [
            'data' => $data
        ]);

        return $this;
    }

    public function updateRelations()
    {
        if (isset(request()->relations)) {
            foreach (request()->relations as $relationType => $relationIds) {
                ResourceResource::whereRelationType($relationType)->whereResourceId($this->id)->delete();
                if (isset($relationIds)) {
                    foreach ($relationIds as $relationId) {
                        ResourceResource::create([
                            'resource_id' => $this->id,
                            'relation_id' => $relationId,
                            'resource_type' => get_class($this),
                            'relation_type' => $relationType
                        ]);
                    }
                }
            }
        }
    }
}
