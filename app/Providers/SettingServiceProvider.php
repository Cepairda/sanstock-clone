<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Cache\Factory;
use App\Setting;

class SettingServiceProvider extends ServiceProvider
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
    public function boot(Factory $cache, Setting $settings)
    {
//        $settings = $cache->remember('settings', 60 * 24, function() use ($settings) {
//            return $settings->pluck('details')->first();
//        });
//
//        config()->set('settings', $settings);
    }
}
