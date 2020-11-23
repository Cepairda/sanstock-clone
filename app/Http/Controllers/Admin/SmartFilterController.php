<?php

namespace App\Http\Controllers\Admin;

use App\SmartFilter;
use App\Http\Controllers\Admin\Resource\isResource;

class SmartFilterController
{
    use isResource;

    public function __construct(SmartFilter $smartFilter)
    {
        $this->resource = $smartFilter;
    }

    public function edit($id)
    {
        if ($smartFilters = $this->resource->joinLocalization()->where('details->category_id', $id)->first()) {
            $this->resource = $smartFilters;
        }

        $form = $this->getForm();
        return view('admin.resources.create-or-edit', compact('form'));
    }

    private function storeOrUpdate()
    {
        $this->resource->storeOrUpdate();
        return redirect(action([CategoryController::class, 'index']));
    }
}
