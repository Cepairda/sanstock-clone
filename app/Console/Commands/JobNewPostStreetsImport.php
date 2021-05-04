<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class JobNewPostStreetsImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'np_streets_import:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Job of New Post Streets Import';

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
        \App\Jobs\ImportNewPostStreets::dispatch()->onQueue('NP_Import');

        return 0;
    }
}
