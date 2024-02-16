<?php

namespace xGrz\LaravelAppSettings\Support\Services;

use Illuminate\Support\Collection;
use xGrz\LaravelAppSettings\Models\Setting;

class SettingsGroupingService
{
    /**
     * Groups settings by GroupName. When $groupName is provided return only this group settings
     *
     * @param string|null $groupName
     * @param string $model
     * @return Collection
     */
    public static function grouped(?string $groupName = null, string $model = Setting::class): Collection
    {
        $settings = collect($model::orderBy('key')
            ->when((bool)$groupName, fn($query) => $query->where('groupName', $groupName))
            ->get()
            ->makeHidden('created_at', 'updated_at')
            ->toArray()
        );

        return $settings
            ->keyBy('groupName')
            ->map(function ($group) use ($settings) {
                return $settings
                    ->filter(function ($settingItem) use ($group) {
                        return $settingItem['groupName'] === $group['groupName'];
                    })
                    ->toArray();
            })->when((bool)$groupName, function ($collection) use ($groupName) {
                return $collection[$groupName] ?? null;
            });
    }
}
