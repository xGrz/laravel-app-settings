<?php

namespace xGrz\LaravelAppSettings\Support\Services;

use xGrz\LaravelAppSettings\Models\Setting;

class SettingsService
{
    public static function get()
    {
        return Setting::orderBy('key')->get();
    }
}
