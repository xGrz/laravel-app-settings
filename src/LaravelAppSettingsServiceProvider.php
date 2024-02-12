<?php

namespace xGrz\LaravelAppSettings;

use Illuminate\Support\ServiceProvider;

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

        $this->publishes(
            [
                __DIR__ . '/../config/laravel-app-settings-config.php' => config_path('laravel-app-settings-config.php'),
                __DIR__ . '/../config/laravel-app-settings.php' => config_path('laravel-app-settings.php')
            ],
            'laravel-app-settings'
        );
    }

}
