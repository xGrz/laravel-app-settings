<?php

namespace xGrz\LaravelAppSettings\Support\Services;

use Illuminate\Support\Collection;
use xGrz\LaravelAppSettings\Enums\SettingValueType;
use xGrz\LaravelAppSettings\Exceptions\LaravelSettingsSourceFileMissingException;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\Config;

class SyncService
{
    /**
     * @throws LaravelSettingsSourceFileMissingException
     */
    public static function getSourceSettings(): array
    {
        if (!self::isPublished()) {
            throw new LaravelSettingsSourceFileMissingException('Laravel App Setting file missing.');
        }
        return self::buildSettingsFromSource();
    }

    public static function isPublished(): bool
    {
        return file_exists(config_path(Config::getDefinitionsFilename()));
    }

    /**
     * @throws LaravelSettingsSourceFileMissingException
     */
    public static function buildSettingsFromSource(): array
    {
        $configSource = config(pathinfo(Config::getDefinitionsFilename())['filename']);
        if (!$configSource) {
            throw new LaravelSettingsSourceFileMissingException('Laravel App Setting definition file contains errors');
        }

        $settings = [];
        foreach ($configSource as $groupName => $groupKeys) {
            foreach ($groupKeys as $keyName => $definition) {
                $settings[$groupName . '.' . $keyName] = self::buildSettingItem($groupName, $keyName, $definition);
            }
        }
        sort($settings);
        return $settings;
    }

    private static function buildSettingItem(string $groupName, string $keyName, array $definition): array
    {
        return [
            'key' => join('.', [$groupName, $keyName]),
            'groupName' => $groupName,
            'keyName' => $keyName,
            'type' => $definition['type'] ?? self::detectValueType($definition['value']), // Important: `type` must be upper then `value`!!!
            'value' => $definition['value'] ?? null,
            'description' => $definition['description'] ?? '',
        ];
    }

    private static function detectValueType(mixed $value): ?SettingValueType
    {
        return match (gettype($value)) {
            'string' => SettingValueType::Text,
            'array' => SettingValueType::Selectable,
            'double', 'integer' => SettingValueType::Number,
            'boolean' => SettingValueType::BooleanType,
            default => null,
        };
    }

    /**
     * @throws LaravelSettingsSourceFileMissingException
     */
    public static function sync(): void
    {
        $sourceSettings = self::getSourceSettings();
        $sourceKeys = (new Collection($sourceSettings))->map(fn($source) => $source['key']);

        // remove keys when not in source config file
        $outdatedSettings = Setting::whereNotIn('key', $sourceKeys)->get('key')
            ->map(fn($setting) => $setting->key);

        Setting::whereIn('key', $outdatedSettings)->delete();

        // update/create current settings
        foreach ($sourceSettings as $setting) {
            $item = Setting::where('key', $setting['key'])->first();
            if ($item) {
                $item->fill(['description' => $setting['description'], 'type' => $setting['type']]);
                if ($item->isDirty(['type'])) {
                    $item->value = $setting['value'];
                }
                $item->save();
            } else {
                Setting::create($setting);
            }
        }
    }

}
