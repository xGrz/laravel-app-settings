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
    }

}
