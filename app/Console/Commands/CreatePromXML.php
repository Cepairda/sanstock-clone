<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreatePromXML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:prom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create feeder for PROM.UA';

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
        (new \App\Http\Controllers\Admin\XMLController())->createPromXMLFeeder();

        return 0;
    }
}
