<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\Config;
use xGrz\LaravelAppSettings\Support\Facades\Settings;
use xGrz\LaravelAppSettings\Support\Services\SyncService;

class PerformanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Config::publish();
        SyncService::sync();
    }

    public function test_get_all_settings_from_db_performance_with_one_query()
    {
        $this->expectsDatabaseQueryCount(1);
        Settings::invalidateCache();
        Settings::getAll();
        Settings::get('application.name');
    }

    public function test_get_all_settings_from_cache()
    {
        $this->expectsDatabaseQueryCount(0);
        $this->assertGreaterThan('0', Settings::getAll());
    }

    public function test_get_one_settings_from_cache()
    {
        $setting = Setting::first(['key', 'value', 'type'])->makeHidden('type')->toArray();
        $this->expectsDatabaseQueryCount(0);

        $this->assertEquals(
            $setting['value'],
            Settings::get( $setting['key'])
        );
    }

}
