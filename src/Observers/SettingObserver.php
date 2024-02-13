<?php

namespace xGrz\LaravelAppSettings\Observers;

use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Services\SettingsService;

class SettingObserver
{
    public function created(): void
    {
        SettingsService::invalidateCache();
    }

    public function updated(Setting $setting): void
    {
        SettingsService::invalidateCache();
    }

    public function deleted(): void
    {
        SettingsService::invalidateCache();
    }
}
