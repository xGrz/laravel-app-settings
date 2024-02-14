<?php

namespace xGrz\LaravelAppSettings\Support\Services;

use Illuminate\Support\Facades\Artisan;

class ConfigService
{
    const ARTISAN_CALLOUT = 'app-settings';
    private string $config_filename_prefix = 'laravel-app-settings';
    private string $database_table = 'settings';
    private int $cache_timeout = 86400;
    private string $cache_key = 'LaravelSettings';


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

        if (isset($config['config_filename_prefix'])) {
            $this->config_filename_prefix = $config['config_filename_prefix'];
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
        return $this->config_filename_prefix . '-config.php';
    }

    public function getDefinitionsFilename(): string
    {
        return $this->config_filename_prefix . '-definitions.php';
    }

    public function getCacheKey(): string
    {
        return $this->cache_key;
    }

    public function getCacheTimeout(): int
    {
        return $this->cache_timeout;
    }

    public function getDatabaseTableName(): string
    {
        return $this->database_table;
    }

    public function getConfigFilenamePrefix(): string
    {
        return $this->config_filename_prefix;
    }

    public function publish(): int
    {
        return Artisan::call('vendor:publish', ['--tag' => 'laravel-app-settings']);
    }


}
