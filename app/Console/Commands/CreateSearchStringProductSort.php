<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\ProductSortController;
use Illuminate\Console\Command;

class CreateSearchStringProductSort extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-search-string:product-sort';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Search Strong';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ProductSortController $productSort)
    {
        try {
            $productSort->createSearchString();

            $this->info('Create Search String have been successfully added to the queue');
        } catch (\Exception $exception) {
            $this->error('Something went wrong.' . $exception->getMessage());
        }
    }
}
