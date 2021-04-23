<?php

namespace App\Jobs;

use App\Classes\Imports\B2BImport;
use App\Http\Controllers\ImageController;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessImportB2B implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Количество раз, которое можно попробовать выполнить задачу.
     *
     * @var int
     */
    public $tries = 5;

    private $brandId;
    private $productRef;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($brandId, $productRef)
    {
        $this->brandId = $brandId;
        $this->productRef = $productRef;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(B2BImport $importB2B)
    {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        $importB2B->getDataJson('brand/' . 'a0ca0cab-c450-11e7-82f5-00155dacf604');
        $importB2B->importQueue($this->brandId, $this->productRef);
    }
}
