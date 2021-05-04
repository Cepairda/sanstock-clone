<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\NewPost\NewPostController;
use Illuminate\Console\Command;

class NewPostSettlementsImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:np_settlements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import New Post Settlements';

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
        $np = new NewPostController();
        $np->importNewPostSettlements();
        return 0;
    }
}
