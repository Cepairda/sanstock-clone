<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Backup;
use Illuminate\Support\Facades\Storage;

class MysqlBackupController extends Controller
{
    public function index()
    {
        $backups = Backup::backupFiles();

        return view('admin.backup.index', compact('backups'));
    }

    public function store()
    {
        Artisan::call('db:backup');

        return redirect()->back();
    }

    public function download($name)
    {
        return Storage::download(config('settings-file.backup_folder') . '/' . $name);
    }

    public function destroy($name)
    {
        $result = Storage::delete(config('settings-file.backup_folder') . '/' . $name);

        return redirect()->back();
    }
}
