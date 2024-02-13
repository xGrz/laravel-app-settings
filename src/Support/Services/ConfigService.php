<?php

namespace xGrz\LaravelAppSettings\Support\Services;

class ConfigService
{
    const CONFIG_FILE_PREFIX = 'laravel1-app-settings';
    private string $database_table = 'settings';
    private int $cache_timeout = 86400;
    private string $cache_key = 'LaravelSettings';

    public function __construct(?string $configFileName = null)
    {
        $this->applyConfiguration($configFileName ?? self::getConfigFileName());
    }

    public function applyConfiguration(string $configFileName): static
    {
        if (file_exists(config_path($configFileName))) {
            $this->setConfig(config('laravel-app-settings-config'));
        }
        return $this;
    }

    public function setConfig(array $config): void
    {
        if (isset($config['database_table'])) {
            $this->database_table = $config['database_table'];
        }

        if (isset($config['cache']['key'])) {
            $this->cache_key = $config['cache']['key'];
        }

        if (isset($config['cache']['timeout'])) {
            $this->cache_timeout = $config['cache']['timeout'];
        }
    }

    public function getCacheKey(): string
    {
        return $this->cache_key;
    }

    public function getCacheTimeout(): int
    {
        return $this->cache_timeout;
    }

    public function getDatabaseTable(): string
    {
        return $this->database_table;
    }

    public static function getConfigFileName(): string
    {
        return self::CONFIG_FILE_PREFIX . '-config.php';
    }

}
