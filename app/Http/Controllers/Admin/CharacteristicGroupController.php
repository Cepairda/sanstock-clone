<?php

namespace App\Http\Controllers\Admin;

use App\CharacteristicGroup;
use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;

class CharacteristicGroupController extends Controller
{
    use isResource;

    public function __construct(CharacteristicGroup $characteristicGroup)
    {
        $this->resource = $characteristicGroup;
    }

    public function index()
    {
        $resources = $this->resource->joinLocalization()->withCategories();
        
        if ($this->resource->usedNodeTrait()) {
            $resources = $resources->with('ancestors')->get()->toFlatTree();
        } else {
            $resources = $resources->paginate(50);
        }

        return view('admin.resources.characteristic-groups.index', compact('resources'));
    }

    public function create()
    {
        $form = $this->getForm();
        return view('admin.resources.characteristic-groups.create-or-edit', compact('form'));
    }

    public function edit($id)
    {
        $this->resource = $this->resource->joinLocalization()->find($id);
        $form = $this->getForm();
        return view('admin.resources.characteristic-groups.create-or-edit', compact('form'));
    }
}
