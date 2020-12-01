<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelLocalization;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Resource extends Model
{
    use SoftDeletes, HasJsonRelationships;

    protected $table = 'resources';
    protected $request = null;

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

    public function setRequest($data = null)
    {
        return (isset($data) ? $this->request = $data : ($this->request ?? $this->request = request()->all()));
    }

    public function storeOrUpdate()
    {
        $this->setRequest();

        if (isset($this->request['virtual_id'])) {
            $this->virtual_id = $this->request['virtual_id'];
        }

        if (isset($this->request['slug'])) {
            $this->slug = $this->request['slug'];
        }

        if (isset($this->request['details'])) {
            $this->details = $this->request['details'];
        }

        if (isset($this->request['parent_id'])) {
            $this->parent_id = $this->request['parent_id'];
        }

        /*$this->slug = $this->request['slug'] ?? null;
        $this->details = $this->request['details'] ?? null;
        $this->parent_id = $this->request['parent_id'] ?? null;*/
        $this->save();

        if ($this->usedNodeTrait()) {

            $this->fixTree();
        }

        ResourceLocalization::updateOrCreate([
            'resource_id' => $this->id,
            'locale' => LaravelLocalization::getCurrentLocale()
        ], [
            'data' => $this->request['data'] ?? null
        ]);

        $this->updateRelations();

        return $this;
    }

    public function updateRelations()
    {
        foreach ($this->request['relations'] ?? [] as $relationType => $relationIds) {

            ResourceResource::whereRelationType($relationType)->whereResourceId($this->id)->delete();

            foreach ($relationIds ?? [] as $relationId) {

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
