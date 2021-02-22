<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Backup extends Model
{
    protected static function backupFiles()
    {
        return array_reverse(Storage::allfiles(config('settings-file.backup_folder')));
    }
}
