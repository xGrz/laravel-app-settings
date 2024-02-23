<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use xGrz\LaravelAppSettings\Enums\SettingValueType;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\Config;
use xGrz\LaravelAppSettings\Support\Services\SyncService;

class ExampleWebInterfaceTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Config::publish();
        SyncService::sync();
    }


    public function test_module_main_page_redirects_to_listing()
    {
        if (!Config::shouldExposeUI()) return;

        $this
            ->get(route('laravel-app-settings.index'))
            ->assertRedirect(route('laravel-app-settings.listing'));
    }

    public function test_listing_page_is_rendering()
    {
        if (!Config::shouldExposeUI()) return;
        $setting = Setting::where('type', SettingValueType::Text)->first();

        $this
            ->get(route('laravel-app-settings.listing'))
            ->assertStatus(200)
            ->assertSee('Laravel-App-Settings')
            ->assertSee($setting->key)
            ->assertSee($setting->value);

    }

    public function test_grouped_page_is_rendering()
    {
        if (!Config::shouldExposeUI()) return;
        $setting = Setting::where('type', SettingValueType::Text)->first();

        $this
            ->get(route('laravel-app-settings.grouped'))
            ->assertStatus(200)
            ->assertSee('Laravel-App-Settings')
            ->assertSee($setting->key)
            ->assertSee($setting->value);

    }


    public function test_update_setting_value()
    {
        if (!Config::shouldExposeUI()) return;
        $setting = Setting::where('type', SettingValueType::Text)->first();

        $testData = [
            'value' => "test"
        ];

        $this
            ->from(route('laravel-app-settings.edit', $setting))
            ->patch(route('laravel-app-settings.update', $setting), $testData)
            ->assertRedirectToRoute('laravel-app-settings.grouped');

        $this->assertDatabaseHas(Config::getDatabaseTableName(), $testData);
    }

    public function test_update_invalid__type_setting_value_backs_to_edit()
    {
        if (!Config::shouldExposeUI()) return;
        $setting = Setting::where('type', SettingValueType::Text)->first();

        $testData = [
            'value' => ['abc', 'cba']
        ];

        $this
            ->from(route('laravel-app-settings.edit', $setting))
            ->patch(route('laravel-app-settings.update', $setting), $testData)
            ->assertSessionHasErrors()
            ->assertRedirect(route('laravel-app-settings.edit', $setting));

        $setting2 = Setting::where('type', SettingValueType::Text)->first();

        // assert not changed
        $this->assertEquals($setting->value, $setting2->value);
    }

    public function test_edit_text_value_is_rendering()
    {
        if (!Config::shouldExposeUI()) return;
        $setting = Setting::where('type', SettingValueType::Text)->first();

        $this
            ->get(route('laravel-app-settings.edit', $setting))
            ->assertStatus(200)
            ->assertViewIs('laravel-app-settings::edit.edit')
            ->assertSee('Edit key')
            ->assertSee($setting->key)
            ->assertSee($setting->value);
    }

    public function test_edit_numeric_value_is_rendering()
    {
        if (!Config::shouldExposeUI()) return;
        $setting = Setting::where('type', SettingValueType::Number)->first();

        $this
            ->get(route('laravel-app-settings.edit', $setting))
            ->assertStatus(200)
            ->assertViewIs('laravel-app-settings::edit.edit')
            ->assertSee('Edit key')
            ->assertSee($setting->key)
            ->assertSee($setting->value);
    }

    public function test_edit_selectable_value_is_rendering()
    {
        if (!Config::shouldExposeUI()) return;
        $setting = Setting::where('type', SettingValueType::Selectable)->first();

        $this
            ->get(route('laravel-app-settings.edit', $setting))
            ->assertStatus(200)
            ->assertViewIs('laravel-app-settings::edit.edit')
            ->assertSee('Edit key')
            ->assertSee($setting->key)
            ->assertSee($setting->value);
    }

    public function test_edit_boolean_type_value_is_rendering()
    {
        if (!Config::shouldExposeUI()) return;
        $setting = Setting::where('type', SettingValueType::BooleanType)->first();

        $this
            ->get(route('laravel-app-settings.edit', $setting))
            ->assertStatus(200)
            ->assertViewIs('laravel-app-settings::edit.edit')
            ->assertSee('Edit key')
            ->assertSee($setting->key)
            ->assertSee($setting->value)
            ->assertSee('On')
            ->assertSee('Off');
    }

    public function test_send_update_empty_from()
    {
        if (!Config::shouldExposeUI()) return;
        $setting = Setting::where('type', SettingValueType::Text)->first();

        $testData = ['value' => null];

        $this
            ->from(route('laravel-app-settings.edit', $setting->id))
            ->patch(route('laravel-app-settings.update', $setting->id), $testData)
            ->assertRedirectToRoute('laravel-app-settings.grouped');
    }

}
