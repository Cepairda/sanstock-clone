<?php

namespace App\Providers;

use App\Classes\TelegramBot;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(TelegramBot $bot)
    {
        Queue::failing(function (JobFailed $event) use ($bot) {
            $str = strpos($event->exception, 'Stack trace:');
            $exception = substr($event->exception, 0, $str);

            $bot->sendSubscribes('sendMessage', "Ошибка очереди: {$event->job->getQueue()}." . PHP_EOL . "{$exception}");
        });
    }
}
