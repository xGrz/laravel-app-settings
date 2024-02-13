<?php

namespace xGrz\LaravelAppSettings\Support\Facades;

use xGrz\LaravelAppSettings\Exceptions\SettingsKeyNotFoundException;
use xGrz\LaravelAppSettings\Exceptions\SettingValueValidationException;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Services\SettingsService;
use xGrz\LaravelAppSettings\Support\Services\StoreSettingService;

class Settings
{

    /**
     * Return value of key provided as parameter
     *
     * @param string $key
     * @return mixed
     * @throws SettingsKeyNotFoundException
     */
    public static function get(string $key): mixed
    {
        return SettingsService::get($key);
    }

    /**
     * Update value of key. Values as validated
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     * @throws SettingValueValidationException
     */
    public static function set(string $key, mixed $value): bool
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
     */
    public static function update(string $key, array $data): ?bool
    {
        return (new StoreSettingService($key))->update($data);
    }

    /**
     * Returns all settings directly from DB (non-cached values). Helpful when you want to edit them.
     *
     * @param string $model (setting model name. Please provide your own when extending your default model)
     * @return mixed
     */
    public static function all(string $model = Setting::class)
    {
        return $model::orderBy('key')
            ->get()
            ->makeHidden(['created_at', 'updated_at'])
            ->map(function ($setting) {
                $setting['typeName'] = $setting->type->name;
                return $setting;
            })
            ->toArray();
    }

    public static function grouped(?string $groupName = null, string $model = Setting::class)
    {
        return $model::distinct()
            ->orderBy('groupName')
            ->when((bool)$groupName, fn($query) => $query->where('groupName', $groupName))
            ->get('groupName')
            ->keyBy('groupName')
            ->map(function ($group) use ($model) {
                return $model::orderBy('keyName')
                    ->where('groupName', $group->groupName)
                    ->get()
                    ->makeHidden(['created_at', 'updated_at'])
                    ->toArray();
            })
            ->when((bool)$groupName, fn($settingsInGroup) => $settingsInGroup[$groupName]);
    }


}
