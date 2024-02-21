<?php

namespace xGrz\LaravelAppSettings\Support\Services;

use Illuminate\Support\Facades\Artisan;

class ConfigService
{
    const ARTISAN_CALLOUT = 'app-settings';
    const CONFIG_FILE_PREFIX = 'laravel-app-settings';
    private bool $expose_ui = false;
    private string $database_table = 'settings';
    private int $cache_timeout = 86400;
    private string $cache_key = 'LaravelSettings';
    private string $route_prefix = 'laravel-app-settings';


    public function __construct()
    {
        $this->loadConfigurationFromFile();
    }

    public function loadConfigurationFromFile(?string $configFileName = null): static
    {
        $configFileName = $configFileName ?? self::getConfigFileName();

        if (file_exists(config_path($configFileName))) {
            $configKey = pathinfo($configFileName)['filename'];
            $this->setConfiguration(config($configKey));
        }
        return $this;
    }

    public function setConfiguration(array $config): void
    {
        if (isset($config['database_table'])) {
            $this->database_table = $config['database_table'];
        }

        if (isset($config['expose_ui'])) {
            $this->expose_ui = $config['expose_ui'];
        }

        if (isset($config['route_uri'])) {
            $this->route_prefix = $config['route_uri'];
        }

        if (isset($config['cache']['key'])) {
            $this->cache_key = $config['cache']['key'];
        }

        if (isset($config['cache']['timeout'])) {
            $this->cache_timeout = $config['cache']['timeout'];
        }
    }

    public function getConfigFileName(): string
    {
        return self::CONFIG_FILE_PREFIX . '-config.php';
    }

    public function getDefinitionsFilename(): string
    {
        return self::CONFIG_FILE_PREFIX . '-definitions.php';
    }

    public function getCacheKey(): string
    {
        return $this->cache_key;
    }

    public function getCacheTimeout(): int
    {
        return $this->cache_timeout;
    }

    public function shouldExposeUI(): bool
    {
        return $this->expose_ui;
    }

    public function getDatabaseTableName(): string
    {
        return $this->database_table;
    }

    public function publish(): int
    {
        return Artisan::call('vendor:publish', ['--tag' => 'laravel-app-settings']);
    }

    public function getRouteUri(?string $suffix = null): string
    {
        return collect([$this->route_prefix, $suffix])->join('/');
    }


}
