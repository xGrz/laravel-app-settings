<?php

namespace xGrz\LaravelAppSettings;

use Illuminate\Support\ServiceProvider;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Observers\SettingObserver;

class LaravelAppSettingsServiceProvider extends ServiceProvider
{

    public function register(): void
    {
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }

        $this->loadRoutesFrom(__DIR__ .'/../routes/web.php');

        $this->publishes(
            [
                __DIR__ . '/../config/laravel-app-settings-config.php' => config_path('laravel-app-settings-config.php'),
                __DIR__ . '/../config/laravel-app-settings.php' => config_path('laravel-app-settings.php')
            ],
            'laravel-app-settings'
        );

        Setting::observe(SettingObserver::class);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-app-settings');

    }

}
