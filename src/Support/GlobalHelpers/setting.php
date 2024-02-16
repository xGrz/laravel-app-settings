<?php

use xGrz\LaravelAppSettings\Support\Facades\Settings;

if (!function_exists('setting')) {

    function setting(string $key): mixed
    {
        return Settings::get($key);
    }

}
