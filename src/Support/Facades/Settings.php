<?php

namespace xGrz\LaravelAppSettings\Support\Facades;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use xGrz\LaravelAppSettings\Exceptions\SettingsKeyNotFoundException;
use xGrz\LaravelAppSettings\Exceptions\SettingValueValidationException;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Services\SettingsGroupingService;
use xGrz\LaravelAppSettings\Support\Services\SettingsService;
use xGrz\LaravelAppSettings\Support\Services\StoreSettingService;

/**
 * @method static loadSettings()
 * @method static invalidateCache()
 * @method static refreshCache()
 * @method static get(string $key)
 * @method static getAll()
 * @method static all()
 */
class Settings extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SettingsService::class;
    }

    /**
     * Update value of key. Values as validated
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     * @throws SettingValueValidationException
     * @throws SettingsKeyNotFoundException
     */
    public static function set(string|int|Setting $key, mixed $value): bool
    {
        return (new StoreSettingService($key))->update(['value' => $value]);
    }

    /**
     * Update value/description when provided in $data array.
     *
     * @param string $key
     * @param array $data
     * @return bool|null
     * @throws SettingValueValidationException
     * @throws SettingsKeyNotFoundException
     */
    public static function update(string|int|Setting $setting, array $data): ?bool
    {
        return (new StoreSettingService($setting))->update($data);
    }

    /**
     * Returns settings with group specified in grupName parameter.
     * When groupName im empty this method will return all settings divided in sections by groupName )
     *
     * @param string|null $groupName
     * @param Builder|null $queryBuilder
     * @return Collection
     */
    public static function getGroup(?string $groupName = null, ?Builder $queryBuilder = null): Collection
    {
        return SettingsGroupingService::grouped($groupName, $queryBuilder);
    }

}
