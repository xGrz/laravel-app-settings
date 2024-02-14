<?php

namespace xGrz\LaravelAppSettings\Support\Services;

use xGrz\LaravelAppSettings\Exceptions\SettingsKeyNotFoundException;
use xGrz\LaravelAppSettings\Models\Setting;

class SettingsService
{
    protected array $settings = [];

    public function __construct()
    {
        self::loadSettings();
    }

    private function loadSettings(): void
    {
        $config = new ConfigService();
        $this->settings = cache()->remember(
            $config->getCacheKey(),
            $config->getCacheTimeout(),
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

    public static function invalidateCache(): void
    {
        cache()->forget((new ConfigService())->getCacheKey());
        app(SettingsService::class)->loadSettings();
    }

    /**
     * @throws SettingsKeyNotFoundException
     */
    public static function get(string $key)
    {
        foreach (app(SettingsService::class)->settings as $settingItem) {
            if ($settingItem['key'] === $key) {
                return $settingItem['value'];
            }
        }

        SettingsKeyNotFoundException::missingKey($key);
    }

    public static function getAll()
    {
        return app(SettingsService::class)->settings;
    }

}
