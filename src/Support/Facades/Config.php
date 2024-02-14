<?php

namespace xGrz\LaravelAppSettings\Support\Facades;

use Illuminate\Support\Facades\Facade;
use xGrz\LaravelAppSettings\Support\Services\ConfigService;

/**
 * @method static getConfigFilename()
 * @method static getDefinitionsFilename()
 * @method static getConfigFilenamePrefix()
 * @method static getDatabaseTableName()
 * @method static getCacheTimeout()
 * @method static getCacheKey()
 * @method static setConfiguration(string[]|array[] $testConfig)
 * @method static publish()
 */

class Config extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ConfigService::class;
    }

}
