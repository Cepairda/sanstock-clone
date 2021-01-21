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
        //dd(Setting::pluck('details')->first());
        //config()->set('setting', Setting::pluck('details')->first());
        //dd(config('setting.comments.files.count'));

        $settings = $cache->remember('settings', 60 * 24, function() use ($settings) {
            return $settings->pluck('details')->first();
        });

        config()->set('settings', $settings);
        //dd(config('settings.comments.files.size'));
    }
}
