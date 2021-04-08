<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Classes\Imports\B2BImport;

class ImportController extends Controller
{
    protected $importB2B;

    public function __construct(B2BImport $b2BImport)
    {
        ini_set('default_socket_timeout', 10000);
        ini_set('memory_limit', -1);
        ini_set('max_input_time', -1);
        ini_set('max_execution_time', 10000);
        set_time_limit(0);

        $this->importB2B = $b2BImport;
    }

    public function updateOrCreate($brandRef = null)
    {
        $t['start'] = \Carbon\Carbon::now()->format('H:i:s');

        $data = $this->importB2B->getDataJson('brand/' . 'a0ca0cab-c450-11e7-82f5-00155dacf604');
        $this->importB2B->setData($data);

        //$brand = $this->importB2B->firstOrCreateBrand();
        //$this->importB2B->firstOrCreateProducts($brand);
        $this->importB2B->addToQueue();

        $t['end'] = \Carbon\Carbon::now()->format('H:i:s');
        //dd($t);
    }
}
