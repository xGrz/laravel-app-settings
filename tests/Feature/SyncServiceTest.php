<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use xGrz\LaravelAppSettings\Exceptions\LaravelSettingsSourceFileMissingException;
use xGrz\LaravelAppSettings\Support\Facades\Config;
use xGrz\LaravelAppSettings\Support\Services\SyncService;

class SyncServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_configuration_published()
    {
        if (!file_exists(config_path(Config::getConfigFilename()))) {
            Config::publish();
        }

        $this->assertFileExists(
            config_path(Config::getConfigFilename())
        );
    }

    public function test_definitions_published()
    {
        if (!file_exists(config_path(Config::getDefinitionsFilename()))) {
            Config::publish();
        }

        $this->assertFileExists(
            config_path(Config::getDefinitionsFilename())
        );
    }

    public function test_database_table_exists()
    {
        $tableName = Config::getDatabaseTableName();

        // POSITIVE
        $this->assertTrue(Schema::hasTable($tableName), 'Did you forget migrate?');

        // NEGATIVE
        Config::setConfiguration(['database_table' => 'nonExistingTable']);
        $nonExistingTable = Config::getDatabaseTableName();
        $this->assertFalse(Schema::hasTable($nonExistingTable));
    }

    public function test_sync_database()
    {
        $this->assertDatabaseCount(Config::getDatabaseTableName(), 0);

        SyncService::sync();
        $settingsCount = count(SyncService::buildSettingsFromSource());

        $this->assertGreaterThan(
            '2',
            $settingsCount,
            'Too few settings definitions in source file.'
        );
        $this->assertDatabaseCount(Config::getDatabaseTableName(), $settingsCount);
    }
}
