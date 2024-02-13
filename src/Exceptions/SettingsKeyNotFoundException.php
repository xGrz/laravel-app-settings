<?php

namespace xGrz\LaravelAppSettings\Exceptions;

class SettingsKeyNotFoundException extends \Exception
{
    /**
     * @throws SettingsKeyNotFoundException
     */
    public static function missingKey(string $keyName)
    {
        throw new self("Setting key [$keyName] not found.");
    }

    /**
     * @throws SettingsKeyNotFoundException
     */
    private static function missingId(int $settingId)
    {
        throw new self("Setting id [$settingId] not exists.");
    }
}
