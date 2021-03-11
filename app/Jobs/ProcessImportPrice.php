<?php

namespace App\Jobs;

use App\Classes\Imports\PriceImport;
use App\Http\Controllers\ImageController;
use App\Classes\ImportImage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessImportPrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Количество раз, которое можно попробовать выполнить задачу.
     *
     * @var int
     */
    public $tries = 5;

    private $productSku;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($productSku)
    {
        $this->productSku = $productSku;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        set_time_limit(0);

        ini_set('memory_limit', '1024M');

        PriceImport::importQueue($this->productSku);
    }
}
