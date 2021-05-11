<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Imports\BrandB2BImport;
use App\Http\Controllers\Controller;

class BrandB2BImportController extends Controller
{
    protected $importB2B;

    public function __construct(BrandB2BImport $b2BImport)
    {
        ini_set('default_socket_timeout', 10000);
        ini_set('memory_limit', -1);
        ini_set('max_input_time', -1);
        ini_set('max_execution_time', 10000);
        set_time_limit(0);

        $this->importB2B = $b2BImport;
        $this->importB2B->getDataJson();
    }

    public function import()
    {
        $t['start'] = \Carbon\Carbon::now()->format('H:i:s');

        $this->importB2B->import();

        $t['end'] = \Carbon\Carbon::now()->format('H:i:s');
    }
    public function updateOrCreateOnQueue()
    {
        $this->importB2B->addToQueue();
    }
}
