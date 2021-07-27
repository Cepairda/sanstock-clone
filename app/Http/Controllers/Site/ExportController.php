<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\XMLController;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function __construct()
    {
//        ini_set('default_socket_timeout', 10000);
//        ini_set('memory_limit', -1);
//        ini_set('max_input_time', -1);
//        ini_set('max_execution_time', 10000);
//        set_time_limit(0);
    }
// http://sanstock/export-prom/U2FuZGlzdG9jaw?access=true
    public function export($token) {
        if($token !== config('app.EXPORT_TOKEN')) return '';

        if (!Storage::disk('local')->get('yml_prom_feeder.xml')) {
            (new XMLController)->createPromXMLFeeder();
        }
        //header("Content-Disposition: attachment; filename=yml_prom_feeder.xml");
//        header('Content-Type: text/xml');
//        header('Content-Type: application/xml');
        return Storage::disk('local')->get('yml_prom_feeder.xml');
    }
}
