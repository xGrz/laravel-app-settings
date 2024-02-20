<?php

namespace Unit;

use Tests\TestCase;
use xGrz\LaravelAppSettings\Support\Facades\Config;

class ConfigTest extends TestCase
{
    public function test_config_file_name_generator()
    {
        $this->assertEquals(
            'laravel-app-settings-config.php',
            Config::getConfigFilename(),
        );
    }

    public function test_definition_file_name_generator()
    {
        $this->assertEquals(
            'laravel-app-settings-definitions.php',
            Config::getDefinitionsFileName(),
        );
    }

    public function test_default_configuration()
    {
        $this->assertEquals('settings', Config::getDatabaseTableName());
        $this->assertEquals(86400, Config::getCacheTimeout());
        $this->assertEquals('LaravelSettings', Config::getCacheKey());
    }

    public function test_custom_configuration_table_name()
    {
        $testConfig = ['database_table' => 'test_custom_table_name'];
        Config::setConfiguration($testConfig);

        $this->assertEquals('test_custom_table_name', Config::getDatabaseTableName());
    }

    public function test_custom_configuration_cache_key()
    {
        $testConfig = [
            'cache' => [
                'key' => 'customKey'
            ]
        ];
        Config::setConfiguration($testConfig);

        $this->assertEquals('customKey', Config::getCacheKey());
    }

    public function test_custom_configuration_cache_timeout()
    {
        $testConfig = [
            'cache' => [
                'timeout' => 100
            ]
        ];
        Config::setConfiguration($testConfig);

        $this->assertEquals(100, Config::getCacheTimeout());
    }

}
