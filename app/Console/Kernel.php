<?php

namespace App\Console;

use App\Http\Controllers\Admin\PriceMonitoringController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs;

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
        //$schedule->command('queue:work --queue=high,b2bImport  --stop-when-empty')->name('b2bImport')->withoutOverlapping();

        $schedule->command('import:price')->hourly();
        //$schedule->command('import:image')->hourly();
        $schedule->command('queue:work --queue=high,priceImport  --stop-when-empty')->name('priceImport')->withoutOverlapping();
        //$schedule->command('queue:work --queue=high,imageImport  --stop-when-empty')->name('imageImport')->withoutOverlapping();
        // $schedule->command('price:monitoring')->hourly();

        if ($cache = Cache::get('lastIdPriceImport')) {
            info('PRICEIMPORTCACHE' . $cache);
            $lastIdPriceImport = Jobs::where('id', $cache)->first();
        }

        if (!isset($lastIdPriceImport)) {
            info('Z-Price work');

            $schedule->call(function () {
                info('Inside Z-Price');
                $monitoring = new PriceMonitoringController();
                $monitoring->getMonitoringListByApi();
                Cache::forget('lastIdPriceImport');
            })->everyThirtyMinutes();
        }
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
