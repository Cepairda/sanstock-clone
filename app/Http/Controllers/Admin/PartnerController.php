<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Resource\isResource;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Partner;
use Illuminate\Http\Request;
use App\Classes\Imports\PartnerImport;

class PartnerController extends Controller
{
    use isResource;

    public function __construct(Partner $partner)
    {
        $this->resource = $partner;
    }

    public function import(Request $request)
    {
        (new PartnerImport())->import($request->file('partners'));

        return redirect()->back();
    }

    public function createSearchString() {

    }
}
