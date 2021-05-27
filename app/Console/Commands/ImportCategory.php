<?php

namespace App\Console\Commands;

use App\Classes\ImportImage as ImportImg;
use App\Classes\Imports\CategoryB2BImport;
use Illuminate\Console\Command;

class ImportCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:category {--ref=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import category from B2B';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CategoryB2BImport $categoryB2BImport)
    {
        try {
            $categoryB2BImport->importQueue();

            $this->info('Categories have been successfully added');
        } catch (\Exception $exception) {
            $this->error('Something went wrong.' . $exception->getMessage());
        }
    }
}
