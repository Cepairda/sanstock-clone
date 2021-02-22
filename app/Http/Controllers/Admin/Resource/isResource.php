<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Category;
use Illuminate\Support\Facades\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;

trait isResource
{
    use FormBuilderTrait;

    public $resource;

    public function index()
    {
        $resources = $this->resource->joinLocalization();

        if (Request::has('id')) {
            $resources = $resources->orderBy('id', Request::input('id'));
        } elseif (Request::has('created_at')) {
            $resources = $resources->orderBy('created_at', Request::input('created_at'));
        } elseif (Request::has('updated_at')) {
            $resources = $resources->orderBy('updated_at', Request::input('updated_at'));
        } elseif (Request::has('deleted_at')) {
            $resources = $resources->orderBy('deleted_at', Request::input('deleted_at'));
        }

        if (Request::has('search')) {
            $resources = $resources->where('search_string', 'like', '%' . Request::input('search') . '%');
        }

        if ($this->resource->usedNodeTrait()) {
            $resources = $resources->with('ancestors')->get()->toFlatTree()->append(Request::except('page'));
        } else {
            $resources = $resources->paginate(50)->appends(Request::except('page'));
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

    public function destroy($id)
    {
        $this->resource->destroy($id);

        return redirect(action([get_class($this), 'index']));
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
