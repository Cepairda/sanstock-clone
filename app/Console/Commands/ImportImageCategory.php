<?php

namespace App\Console\Commands;

use App\Classes\ImportImageCategory as ImportImgCategory;
use Illuminate\Console\Command;

class ImportImageCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:image-category {--ref=}';

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
            $ref = $this->option('ref');

            info('UpdatePrice Add to Queue');

            ImportImgCategory::addToQueue($ref);

            $this->info('Images categories have been successfully added to the queue');
        } catch (\Exception $exception) {
            $this->error('Something went wrong.' . $exception->getMessage());
        }
    }
}
