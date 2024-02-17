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

    public function test_index_page_is_rendering()
    {
        $setting = Setting::where('type', SettingValueType::Text)->first();

        $this
            ->get(route('settings.index'))
            ->assertStatus(200)
            ->assertSee('Laravel-App-Settings')
            ->assertSee($setting->key)
            ->assertSee($setting->value);

    }

    public function test_edit_page_is_rendering()
    {
        $setting = Setting::where('type', SettingValueType::Text)->first();

        $this
            ->get(route('settings.edit', $setting))
            ->assertStatus(200)
            ->assertSee('Edit key')
            ->assertSee($setting->key)
            ->assertSee($setting->value);
    }

    public function test_update_setting_value()
    {
        $setting = Setting::where('type', SettingValueType::Text)->first();

        $testData = [
            'value'=> "test"
        ];

        $this
            ->from(route('settings.edit', $setting))
            ->patch(route('settings.update', $setting), $testData)
            ->assertRedirectToRoute('settings.index')
            ;

        $this->assertDatabaseHas(Config::getDatabaseTableName(), $testData);
    }

    public function test_update_invalid__type_setting_value_backs_to_edit()
    {
        $setting = Setting::where('type', SettingValueType::Text)->first();

        $testData = [
            'value'=> ['abc', 'cba']
        ];

        $this
            ->from(route('settings.edit', $setting))
            ->patch(route('settings.update', $setting), $testData)
            ->assertSessionHasErrors()
            ->assertRedirect(route('settings.edit', $setting))
        ;

        $setting2 = Setting::where('type', SettingValueType::Text)->first();

        // assert not changed
        $this->assertEquals($setting->value, $setting2->value);
    }

}
