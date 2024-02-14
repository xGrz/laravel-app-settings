<?php

namespace xGrz\LaravelAppSettings;

use Illuminate\Support\ServiceProvider;
use xGrz\LaravelAppSettings\Commands\PublishCommand;
use xGrz\LaravelAppSettings\Commands\SyncCommand;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Observers\SettingObserver;
use xGrz\LaravelAppSettings\Support\Facades\Config;
use xGrz\LaravelAppSettings\Support\Services\ConfigService;
use xGrz\LaravelAppSettings\Support\Services\SettingsService;

class LaravelAppSettingsServiceProvider extends ServiceProvider
{

    public function register(): void
    {
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            $this->commands([
                PublishCommand::class,
                SyncCommand::class,
            ]);
        }

        $this->app->singleton(ConfigService::class, fn() => new ConfigService());
        $this->app->singleton(SettingsService::class, fn() => new SettingsService());

        $this->publishes(
            [
                __DIR__ . '/../config/config.php' => config_path(Config::getConfigFilename()),
                __DIR__ . '/../config/definitions.php' => config_path(Config::getDefinitionsFilename())
            ],
            'laravel-app-settings'
        );

        Setting::observe(SettingObserver::class);


        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-app-settings');

    }

}
