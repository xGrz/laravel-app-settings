<?php

namespace xGrz\LaravelAppSettings\Observers;

use xGrz\LaravelAppSettings\Support\Services\SettingsCacheService;

class SettingObserver
{
    public function created(): void
    {
        SettingsCacheService::resetCache();
    }

    public function updated(): void
    {
        SettingsCacheService::resetCache();
    }

    public function deleted(): void
    {
        SettingsCacheService::resetCache();
    }
}
