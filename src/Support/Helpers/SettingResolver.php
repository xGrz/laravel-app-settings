<?php

namespace xGrz\LaravelAppSettings\Support\Helpers;

use xGrz\LaravelAppSettings\Exceptions\SettingsKeyNotFoundException;
use xGrz\LaravelAppSettings\Models\Setting;

class SettingResolver
{
    /**
     * @param string|int|Setting $item
     * @return Setting
     * @throws SettingsKeyNotFoundException
     */
    public static function resolve(string|int|Setting $item): Setting
    {
        if ($item instanceof Setting) return $item;
        if (is_numeric($item)) return self::loadById($item);
        return self::loadByKey($item);
    }


    /**
     * @param string $key
     * @return mixed
     * @throws SettingsKeyNotFoundException
     */
    private static function loadByKey(string $key)
    {
        $setting = Setting::where('key', $key)->first();
        if (!$setting) {
            SettingsKeyNotFoundException::missingKey($key);
        }
        return $setting;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws SettingsKeyNotFoundException
     */
    private static function loadById(int $id)
    {
        $setting = Setting::find($id);
        if (!$setting) {
            SettingsKeyNotFoundException::missingKey($id);
        }
        return $setting;
    }

}
