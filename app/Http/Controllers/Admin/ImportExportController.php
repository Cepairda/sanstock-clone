<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Backup;

class ImportExportController extends Controller
{
    public function index()
    {
        return view('admin.import-export.index');
    }
}
