<?php

namespace App\Console\Commands;

use App\Classes\ImportImage as ImportImg;
use App\Classes\Imports\PriceImport;
use App\Classes\TelegramBot;
use Illuminate\Console\Command;

class ImportPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:price';

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
    public function handle(TelegramBot $bot)
    {
        try {
            PriceImport::addToQueue($bot);

            info('UpdatePrice Add to Queue');

            $this->info('Prices have been successfully added to the queue');
        } catch (\Exception $exception) {
            $this->error('Something went wrong.' . $exception->getMessage());
        }
    }
}
