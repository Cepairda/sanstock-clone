<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Backup;
use Illuminate\Support\Facades\Storage;

class ImportExportController extends Controller
{
    public function index()
    {
        return view('admin.import-export.index');
    }
}
