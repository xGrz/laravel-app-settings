<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use xGrz\LaravelAppSettings\Enums\SettingValueType;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\Config;
use xGrz\LaravelAppSettings\Support\Facades\Settings;
use xGrz\LaravelAppSettings\Support\Services\SyncService;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Config::publish();
        SyncService::sync();
    }

    private function getSettingByType(SettingValueType $type): array
    {
        return Setting::where('type', $type)
            ->first(['key', 'value', 'type'])
            ->makeHidden('type')
            ->toArray();
    }

    /**
     * @info If test did not perform any assertions text type setting was not found in db!
     * @return void
     */
    public function test_get_text_type_value(): void
    {
        $setting = self::getSettingByType(SettingValueType::Text);
        if (!$setting) return;

        $this->assertEquals(
            $setting['value'],
            Settings::get($setting['key'])
        );
    }

    /**
     * @info If test did not perform any assertions numeric type setting was not found in db!
     * @return void
     */
    public function test_get_numeric_type_value(): void
    {
        $setting = self::getSettingByType(SettingValueType::Number);
        if (!$setting) return;

        $this->assertEquals(
            $setting['value'],
            Settings::get($setting['key'])
        );
    }

    /**
     * @info If test did not perform any assertions selectable type setting was not found in db!
     * @return void
     */
    public function test_get_selectable_type_value_as_array(): void
    {
        $setting = self::getSettingByType(SettingValueType::Selectable);
        if (!$setting) return;

        $this->assertEquals(
            $setting['value'],
            Settings::get($setting['key'])
        );
    }

    /**
     * @info If test did not perform any assertions boolean type setting was not found in db!
     * @return void
     */
    public function test_get_boolean_type_value(): void
    {
        $setting = self::getSettingByType(SettingValueType::BooleanType);
        if (!$setting) return;

        $this->assertEquals(
            $setting['value'],
            Settings::get($setting['key'])
        );
    }



}
