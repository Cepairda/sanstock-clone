<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Category;
use Kris\LaravelFormBuilder\FormBuilderTrait;

trait isResource
{
    use FormBuilderTrait;

    public $resource;

    public function index()
    {
        $resources = $this->resource->joinLocalization();
        if ($this->resource->usedNodeTrait()) {
            $resources = $resources->with('ancestors')->get()->toFlatTree();
        } else {
            $resources = $resources->paginate(50);
        }

        return view('admin.resources.index', compact('resources'));
    }

    public function create()
    {
        $form = $this->getForm();
        return view('admin.resources.create-or-edit', compact('form'));
    }

    public function store()
    {
        return $this->storeOrUpdate();
    }

    public function edit($id)
    {
        $this->resource = $this->resource->joinLocalization()->find($id);
        $form = $this->getForm();
        return view('admin.resources.create-or-edit', compact('form'));
    }

    public function update($id)
    {
        $this->resource = $this->resource->find($id);
        return $this->storeOrUpdate();
    }

    private function storeOrUpdate()
    {
        $form = $this->getForm();
        $form->redirectIfNotValid();
        $this->resource->storeOrUpdate();
        return redirect(action([get_class($this), 'index']));
    }

    private function getForm()
    {
        return $this->form(
            ('App\\Http\\Controllers\\Admin\\Resource\\Forms\\' .
                class_basename($this->resource)) . 'Form', [
            'model' => $this->resource
        ]);
    }
}
