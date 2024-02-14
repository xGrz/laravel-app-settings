<?php

namespace xGrz\LaravelAppSettings\Support\Facades;

use Illuminate\Support\Facades\Facade;
use xGrz\LaravelAppSettings\Support\Services\SettingsService;

/**
 * @method static loadSettings()
 * @method static invalidateCache()
 * @method static getAll()
 * @method static get(mixed $key)
 */
class Settings extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SettingsService::class;
    }

}
