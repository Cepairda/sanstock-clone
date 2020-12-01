<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Characteristic;
use App\CharacteristicValue;
use App\Http\Controllers\Admin\Resource\isResource;
use App\Classes\Exports\CategoryWithDataExport;
use App\Classes\Imports\CategoryWithDataImport;
use App\Product;
use App\ResourceResource;
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

    public function index()
    {
        $resources = $this->resource->joinLocalization();
        if ($this->resource->usedNodeTrait()) {
            $resources = $resources->with('ancestors')->get()->toFlatTree();
        } else {
            $resources = $resources->paginate(50);
        }

        return view('admin.resources.categories.index', compact('resources'));
    }
    /*public function edit($id)
    {
        $this->resource = $this->resource->joinLocalization()->find($id);
        $form = $this->getForm();

        $category = Category::where('id', 4)->with('products')->first();
        $characteristicsIds = [];

        foreach ($category->products as $product) {
            foreach ($product->characteristics as $characteristic) {
                $characteristicsIds[$characteristic->details['characteristic_id']] = $characteristic->details['characteristic_id'];
            }
        }

        $characteristics = Characteristic::joinLocalization()->whereIn('id', $characteristicsIds)->get();

        foreach ($characteristics as $characteristic) {
            //echo $characteristic->data['name'] . '<br>';
        }

        $productIds = Product::select('id')->where('details->category_id', $this->resource->id)->get()->keyBy('id')->keys();
        //dd($productIds);
        $characteristicValueIds = ResourceResource::whereIn('resource_id', $productIds)->where('relation_type', 'App\CharacteristicValue')->get()->keyBy('relation_id')->keys();
        //dd($characteristicValueIds);
        //$characteristicValues = CharacteristicValue::whereCharacteristicIsFilter($characteristicIds)
        //    ->whereIn('id', $characteristicValueIds)->orderBy('value')->orderBy('id')->paginate(10);

        $characteristicValues = CharacteristicValue::joinLocalization()
            ->whereIn('id', $characteristicValueIds)->orderBy('data->value')->orderBy('id')->get();


        foreach ($characteristicValues as $characteristicValue) {
            //echo $characteristicValue->getData('value') . '<br>';
        }
        return view('admin.categories.create-or-edit', compact('form', 'characteristics'));
    }*/
}
