<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Characteristic;
use App\Http\Controllers\Admin\Resource\isResource;
use App\Classes\Exports\CategoryWithDataExport;
use App\Classes\Imports\CategoryWithDataImport;
use Illuminate\Http\Request;

class CategoryController
{
    use isResource;

    public function __construct(Category $category)
    {
        $this->resource = $category;
    }

    public function export()
    {
        return (new CategoryWithDataExport())->download();
    }

    public function import(Request $request)
    {
        (new CategoryWithDataImport())->import($request->file('categories'));

        return redirect()->back();
    }

    public function edit($id)
    {
        $this->resource = $this->resource->joinLocalization()->find($id);
        $form = $this->getForm();

        $category = Category::where('id', 11)->with('products')->first();

        $characteristicsIds = [];

        foreach ($category->products as $product) {
            foreach ($product->characteristics as $characteristic) {
                $characteristicsIds[$characteristic->details['characteristic_id']] = $characteristic->details['characteristic_id'];
            }
        }

        $characteristics = Characteristic::joinLocalization()->whereIn('id', $characteristicsIds)->get();

        foreach ($characteristics as $characteristic) {
            $characteristic->data['name'];
        }

        return view('admin.categories.create-or-edit', compact('form', 'characteristics'));
    }
}
