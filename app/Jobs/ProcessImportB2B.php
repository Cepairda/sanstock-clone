<?php

namespace App\Jobs;

use App\Access;
use App\Classes\Imports\StockB2BImport;
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

    private $skuArray;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $skuArray)
    {
        $this->skuArray = $skuArray;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(StockB2BImport $importB2B)
    {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $importB2B->importQueue($this->skuArray);
    }
}
