<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\Config;
use xGrz\LaravelAppSettings\Support\Facades\Settings;
use xGrz\LaravelAppSettings\Support\Services\SyncService;

class SettingsFacadeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Config::publish();
        SyncService::sync();
    }

    public function test_load_settings_from_db_without_cache()
    {
        Settings::invalidateCache();
        $this->assertEmpty(cache()->get(Config::getCacheKey()));

        $this->expectsDatabaseQueryCount(1);
        Settings::loadSettings();
        $this->assertNotEmpty(cache()->get(Config::getCacheKey()));
    }

    public function load_settings_from_cache(): void
    {
        $this->expectsDatabaseQueryCount(0);
        Settings::loadSettings();
        $this->assertNotEmpty(cache()->get(Config::getCacheKey()));
    }

    public function test_get_setting_value()
    {
        $setting = Setting::first(['key', 'value', 'type'])->makeHidden('type')->toArray();

        $this->assertEquals(
            $setting['value'],
            Settings::get($setting['key'])
        );

    }


}
