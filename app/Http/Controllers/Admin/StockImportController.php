<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Classes\Imports\StockB2BImport;

class StockImportController extends Controller
{
    protected $importB2B;

    public function __construct(StockB2BImport $b2BImport)
    {
        ini_set('default_socket_timeout', 10000);
        ini_set('memory_limit', -1);
        ini_set('max_input_time', -1);
        ini_set('max_execution_time', 10000);
        set_time_limit(0);

        $this->importB2B = $b2BImport;
        $this->importB2B->getDataJson();
    }

    public function updateOrCreate()
    {
        $t['start'] = \Carbon\Carbon::now()->format('H:i:s');

        //$brand = $this->importB2B->firstOrCreateBrand();
        //$this->importB2B->firstOrCreateProducts($brand);
        $this->importB2B->parse();


        $t['end'] = \Carbon\Carbon::now()->format('H:i:s');
        //dd($t);
    }
    public function updateOrCreateOnQueue()
    {
        $this->importB2B->addToQueue();
    }
}
