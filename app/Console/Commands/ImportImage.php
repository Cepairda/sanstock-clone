<?php

namespace App\Console\Commands;

use App\Classes\ImportImage as ImportImg;
use Illuminate\Console\Command;

class ImportImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:image {--sku=}';

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
    public function handle()
    {
        try {
            $sku = $this->option('sku');

            ImportImg::addToQueue($sku);

            $this->info('Images have been successfully added to the queue');
        } catch (\Exception $exception) {
            $this->error('Something went wrong.' . $exception->getMessage());
        }
    }
}
