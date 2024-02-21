<?php

namespace xGrz\LaravelAppSettings\Support\Services;

use Illuminate\Support\Collection;
use xGrz\LaravelAppSettings\Exceptions\SettingsKeyNotFoundException;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\Settings;
use xGrz\LaravelAppSettings\Support\Facades\Config;

class SettingsService
{
    protected array $settings = [];

    public function __construct()
    {
        self::loadSettings();
    }

    public function loadSettings(): array
    {
        $this->settings = cache()->remember(
            Config::getCacheKey(),
            Config::getCacheTimeout(),
            fn() => self::settingsDirectRead()
        );
        return $this->settings;
    }

    private function settingsDirectRead()
    {
        return Setting::all(['key', 'type', 'value'])
            ->makeHidden('type')
            ->toArray();
    }

    public function invalidateCache(): void
    {
        cache()->forget(Config::getCacheKey());
    }

    public function refreshCache(): void
    {
        self::invalidateCache();
        Settings::loadSettings();
    }

    /**
     * @throws SettingsKeyNotFoundException
     */
    public function get(string $key)
    {
        foreach ($this->settings as $settingItem) {
            if ($settingItem['key'] === $key) {
                return $settingItem['value'];
            }
        }
        SettingsKeyNotFoundException::missingKey($key);
    }

    public function getAll(): array
    {
        return $this->settings;
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Setting::all();
    }

    public function getKeyValuePairsCollection(): Collection
    {
        return collect($this->settings)
            ->keyBy('key')
            ->map(fn($item) => $item['value'])
            ;
    }

}
