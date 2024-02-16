<?php

namespace xGrz\LaravelAppSettings\Observers;

use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\Settings;
use xGrz\LaravelAppSettings\Support\Services\SettingsService;

class SettingObserver
{
    public function created(): void
    {
        Settings::refreshCache();
    }

    public function updated(): void
    {
        Settings::refreshCache();
    }

    public function deleted(): void
    {
        Settings::refreshCache();
    }
}
