<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\ImportImage as ImportImg;
use App\Product;

class ImportImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import image from B2B';

    /**
     * The process for Backup.
     *
     * @var string
     */
    protected $products;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->products = Product::select(['details->sku as sku'])->get();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            ImportImg::import($this->products);

            $this->info('The import image has been proceed successfully.');
        } catch (\Exception $exception) {
            $this->error('Something went wrong.' . $exception->getMessage());
        }
    }
}
