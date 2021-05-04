<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\NewPost\NewPostController;
use Illuminate\Console\Command;

class NewPostImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new_post:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import New Post Dataset';

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
        $np = new NewPostController ();
        $np->importNewPost();

        return 0;
    }
}
