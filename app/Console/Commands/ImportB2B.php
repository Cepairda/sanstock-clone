<?php

namespace App\Console\Commands;

use App\Classes\Imports\StockB2BImport;
use Illuminate\Console\Command;

class ImportB2B extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:b2b';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import image from B2B';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(StockB2BImport $stockB2BImport)
    {
        try {
            $stockB2BImport->addToQueue();

            $this->info('Prices have been successfully added to the queue');
        } catch (\Exception $exception) {
            $this->error('Something went wrong.' . $exception->getMessage());
        }
    }
}
