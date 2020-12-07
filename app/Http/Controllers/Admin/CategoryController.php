<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Admin\Resource\isResource;
use App\Classes\Exports\CategoryWithDataExport;
use App\Classes\Imports\CategoryWithDataImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadeRequest;

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
        $this->createSearchString();

        return redirect()->back();
    }

    public function index()
    {
        $resources = $this->resource->joinLocalization();

        if (FacadeRequest::has('id')) {
            $resources = $resources->orderBy('id', FacadeRequest::input('id'));
        } elseif (FacadeRequest::has('created_at')) {
            $resources = $resources->orderBy('created_at', FacadeRequest::input('created_at'));
        } elseif (FacadeRequest::has('updated_at')) {
            $resources = $resources->orderBy('updated_at', FacadeRequest::input('updated_at'));
        } elseif (FacadeRequest::has('deleted_at')) {
            $resources = $resources->orderBy('deleted_at', FacadeRequest::input('deleted_at'));
        }

        if (FacadeRequest::has('search')) {
            $resources = $resources->where('search_string', 'like', '%' . FacadeRequest::input('search') . '%');
        }

        $resources = $resources->with('ancestors')->get()->toFlatTree()->append(FacadeRequest::except('page'));

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

    public function createSearchString() {
        $categories = $this->resource
            ->select('id', 'details', 'ua.data as ua_name', 'ru.data as ru_name')
            ->join('resource_localizations as ua', function($q) {
                $q->on('ua.resource_id', '=', 'resources.id')
                    ->where('ua.locale', 'uk');
            })
            ->join('resource_localizations as ru', function($q) {
                $q->on('ru.resource_id', '=', 'resources.id')
                    ->where('ru.locale', 'ru');
            })->get();

        foreach ($categories as $category) {
            Category::where('id', $category->id)->update([
                'search_string' =>
                    (json_decode($category->ua_name, 1))['name'] . ' ' .
                    (json_decode($category->ru_name, 1))['name']
            ]);
        }
    }
}
