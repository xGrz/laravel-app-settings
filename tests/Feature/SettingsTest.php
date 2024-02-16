<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use xGrz\LaravelAppSettings\Enums\SettingValueType;
use xGrz\LaravelAppSettings\Exceptions\SettingsKeyNotFoundException;
use xGrz\LaravelAppSettings\Exceptions\SettingValueValidationException;
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

    private static function getSettingByType(SettingValueType $type): array
    {
        return Setting::where('type', $type)
            ->first(['key', 'value', 'type', 'description'])
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

    public function test_set_text_type_value(): void
    {
        $setting = self::getSettingByType(SettingValueType::Text);
        if (!$setting) return;
        Settings::set($setting['key'], 'Updated text value');

        $this->assertDatabaseHas(Config::getDatabaseTableName(), [
            'key' => $setting['key'],
            'value' => 'Updated text value'
        ]);
        $this->assertEquals(
            Settings::get($setting['key']),
            'Updated text value'
        );
    }

    public function test_set_incorrect_type_value_on_text_field_throws_error()
    {
        $setting = self::getSettingByType(SettingValueType::Text);
        if (!$setting) return;

        $this->expectException(SettingValueValidationException::class);
        $this->expectExceptionMessage('The value field must be a string.');
        Settings::set($setting['key'], 123);
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

    public function test_set_numeric_type_value(): void
    {
        $setting = self::getSettingByType(SettingValueType::Number);
        if (!$setting) return;
        Settings::set($setting['key'], 123);

        $this->assertDatabaseHas(Config::getDatabaseTableName(), [
            'key' => $setting['key'],
            'value' => 123
        ]);

        $this->assertEquals(
            Settings::get($setting['key']),
            123
        );

    }

    public function test_set_incorrect_type_value_on_numeric_field_throws_error()
    {
        $setting = self::getSettingByType(SettingValueType::Number);
        if (!$setting) return;

        $this->expectException(SettingValueValidationException::class);
        $this->expectExceptionMessage('The value field must be a number.');
        Settings::set($setting['key'], "a123");
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

    public function test_set_selectable_type_value(): void
    {
        $setting = self::getSettingByType(SettingValueType::Selectable);
        if (!$setting) return;
        Settings::set($setting['key'], ['abc', 'cba']);

        $this->assertDatabaseHas(Config::getDatabaseTableName(), [
            'key' => $setting['key'],
            'value' => json_encode(['abc', 'cba'])
        ]);

        $this->assertEquals(
            Settings::get($setting['key']),
            ['abc', 'cba']
        );

    }

    public function test_set_incorrect_type_value_on_selectable_field_throws_error()
    {
        $setting = self::getSettingByType(SettingValueType::Selectable);
        if (!$setting) return;

        $this->expectException(SettingValueValidationException::class);
        $this->expectExceptionMessage('The value field must be an array.');
        Settings::set($setting['key'], "a123");
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

    public function test_set_boolean_type_value_true(): void
    {
        $setting = self::getSettingByType(SettingValueType::BooleanType);
        if (!$setting) return;
        Settings::set($setting['key'], true);

        $this->assertDatabaseHas(Config::getDatabaseTableName(), [
            'key' => $setting['key'],
            'value' => true
        ]);

        $this->assertEquals(
            Settings::get($setting['key']),
            true
        );

        Settings::set($setting['key'], false);

        $this->assertDatabaseHas(Config::getDatabaseTableName(), [
            'key' => $setting['key'],
            'value' => false
        ]);

        $this->assertEquals(
            Settings::get($setting['key']),
            false
        );
    }

    public function test_set_boolean_type_value_false(): void
    {
        $setting = self::getSettingByType(SettingValueType::BooleanType);
        if (!$setting) return;
        Settings::set($setting['key'], false);

        $this->assertDatabaseHas(Config::getDatabaseTableName(), [
            'key' => $setting['key'],
            'value' => false
        ]);

        $this->assertEquals(
            Settings::get($setting['key']),
            false
        );
    }

    public function test_set_incorrect_type_value_on_boolean_field_throws_error()
    {
        $setting = self::getSettingByType(SettingValueType::BooleanType);
        if (!$setting) return;

        $this->expectException(SettingValueValidationException::class);
        $this->expectExceptionMessage('The value field must be true or false.');
        Settings::set($setting['key'], 'nonBooleanValue');
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

    public function test_update_setting_with_description()
    {
        $setting = self::getSettingByType(SettingValueType::Text);
        if (!$setting) return;

        Settings::update($setting['key'], [
            'value' => 'newTextValue',
            'description' => 'SomeKeyDescription',
        ]);

        $this->assertDatabaseHas(Config::getDatabaseTableName(), [
            'key' => $setting['key'],
            'value' => 'newTextValue',
            'description' => 'SomeKeyDescription',
        ]);
    }

    public function test_update_setting_without_description()
    {
        $setting = self::getSettingByType(SettingValueType::Text);
        if (!$setting) return;

        Settings::update($setting['key'], [
            'value' => 'newTextValue',
        ]);

        // description should not be changed
        $this->assertDatabaseHas(Config::getDatabaseTableName(), [
            'key' => $setting['key'],
            'value' => 'newTextValue',
            'description' => $setting['description']
        ]);
    }

    public function test_update_setting_without_value()
    {
        $setting = self::getSettingByType(SettingValueType::Text);
        if (!$setting) return;

        Settings::update($setting['key'], [
            'description' => 'SomeKeyDescription',
        ]);

        $this->assertDatabaseHas(Config::getDatabaseTableName(), [
            'key' => $setting['key'],
            'value' => $setting['value'],
            'description' => 'SomeKeyDescription',
        ]);
    }

    public function test_get_with_non_existing_key_throws_error()
    {
        $this->expectException(SettingsKeyNotFoundException::class);
        $this->expectExceptionMessage('Setting key [nonExistingGroup.withNonExistingKey] not found.');
        Settings::get('nonExistingGroup.withNonExistingKey');
    }

    public function test_set_with_non_existing_key_throws_error()
    {
        $this->expectException(SettingsKeyNotFoundException::class);
        $this->expectExceptionMessage('Setting key [nonExistingGroup.withNonExistingKey] not found.');
        Settings::set('nonExistingGroup.withNonExistingKey', 'abc');
    }

}
