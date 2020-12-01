<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Backup;

class ImportExportController extends Controller
{
    public function index()
    {
        ini_set('memory_limit', -1);
        ini_set('max_input_time', -1);
        ini_set('max_execution_time', 900);

        return view('admin.import-export.index');
    }
}
