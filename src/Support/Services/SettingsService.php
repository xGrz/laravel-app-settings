<?php

namespace xGrz\LaravelAppSettings\Support\Services;

use xGrz\LaravelAppSettings\Models\Setting;

class SettingsService
{
    protected array $settings = [];

    public function __construct()
    {
        $this->settings = cache()->remember(
            (new ConfigService())->getCacheKey(),
            (new ConfigService())->getCacheTimeout(),
            fn() => self::settingsDirectRead()
        );
    }

    private function settingsDirectRead()
    {
        return Setting::orderBy('key')
            ->get(['key', 'type', 'value'])
            ->makeHidden('type')
            ->toArray();
    }

    public static function get(string $key)
    {
        foreach (app(SettingsService::class)->settings as $settingItem) {
            if ($settingItem['key'] === $key) {
                return $settingItem['value'];
            }
        }

        // throw key not exists
    }

    public static function getAll()
    {
        return app(SettingsService::class)->settings;
    }
}
