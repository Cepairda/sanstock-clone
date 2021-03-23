<?php

namespace App\Console;

use App\Http\Controllers\Admin\PriceMonitoringController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('import:price')->hourly();
        $schedule->command('import:image')->hourly();
        $schedule->command('queue:work --queue=high,priceImport  --stop-when-empty')->withoutOverlapping();
        $schedule->command('queue:work --queue=high,imageImport  --stop-when-empty')->withoutOverlapping();
        // $schedule->command('price:monitoring')->hourly();
//        $schedule->call(function () {
//            $monitoring = new PriceMonitoringController();
//            $monitoring->getMonitoringListByApi();
//        })->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
