<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\PriceMonitoringController;


class GetProductMonitoringList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price:monitoring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $m = new PriceMonitoringController();
        $m->getMonitoringListByApi();
        // $m->checkPartnerUrl();
        // Получаем данные z-price
        //$m->getMonitoringListByApi();

        return 0;
    }
}
