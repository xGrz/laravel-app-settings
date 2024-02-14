<?php

namespace xGrz\LaravelAppSettings\Observers;

use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\Settings;
use xGrz\LaravelAppSettings\Support\Services\SettingsService;

class SettingObserver
{
    public function created(): void
    {
        Settings::invalidateCache();
    }

    public function updated(): void
    {
        Settings::invalidateCache();
    }

    public function deleted(): void
    {
        Settings::invalidateCache();
    }
}
