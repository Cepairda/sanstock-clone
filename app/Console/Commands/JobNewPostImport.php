<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class JobNewPostImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'np_import:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Job of Import New Post Resources';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \App\Jobs\ImportNewPostAreas::dispatch()->onQueue('NP_Import');

        \App\Jobs\ImportNewPostSettlements::dispatch()->onQueue('NP_Import');

        \App\Jobs\ImportNewPostStreets::dispatch()->onQueue('NP_Import');

        \App\Jobs\ImportNewPostWarehouses::dispatch()->onQueue('NP_Import');

        return 0;
    }
}
