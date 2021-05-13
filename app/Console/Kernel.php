<?php

namespace App\Console;

use App\Http\Controllers\Admin\PriceMonitoringController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs;
use Illuminate\Support\Facades\Log;

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
        //info('Schedule Work');
        //$schedule->command('queue:work --queue=high,b2bImport  --stop-when-empty')->name('b2bImport')->withoutOverlapping();

//        $schedule->command('import:price')->hourly();
//        //$schedule->command('import:image')->hourly();
//        $schedule->command('queue:work --queue=high,priceImport  --stop-when-empty')->name('priceImport')->withoutOverlapping();
//        $schedule->command('queue:work --queue=high,imageImport  --stop-when-empty --timeout=600')->name('imageImport')->withoutOverlapping();

//        if ($cache = Cache::get('lastIdPriceImport')) {
//            info('PRICEIMPORTCACHE' . $cache);
//            $lastIdPriceImport = Jobs::where('id', $cache)->first();
//        }

        //yyyyy
        // New Post Areas Import
        $schedule->call(function () {
            \App\Jobs\ImportNewPostAreas::dispatch()->onQueue('NP_Import');
        })->monthly();

        // New Post Settlements Import
        $schedule->call(function () {
            \App\Jobs\ImportNewPostSettlements::dispatch()->onQueue('NP_Import');
        })->weekly();

        // New Post Streets Import
        $schedule->call(function () {
            \App\Jobs\ImportNewPostStreets::dispatch()->onQueue('NP_Import');
        })->weekly();

        // New Post Warehouses Import
        $schedule->call(function () {
            \App\Jobs\ImportNewPostWarehouses::dispatch()->onQueue('NP_Import');
        })->weekly();

        $schedule->command('queue:work --queue=high,NP_Import  --stop-when-empty')->name('ImportNewPostAreas')->withoutOverlapping();

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
