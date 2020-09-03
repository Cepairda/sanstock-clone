<?php

namespace App\Http\Controllers\Admin;

use App\Category;
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
}
