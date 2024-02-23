<?php

namespace xGrz\LaravelAppSettings\Support\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use xGrz\LaravelAppSettings\Models\Setting;

class SettingsGroupingService
{
    /**
     * Groups settings by GroupName. When $groupName is provided return only this group settings
     *
     * @param string|null $groupName
     * @param Builder|null $query
     * @return Collection
     */
    public static function grouped(?string $groupName = null, ?Builder $query = null): Collection
    {
        if (!$query) $query = Setting::query();

        $collection = $query
            ->when((bool)$groupName, fn($query) => $query->where('groupName', $groupName))
            ->get()
            ->makeHidden('created_at', 'updated_at')
            ->groupBy('groupName')
            ->map(function ($settings, $groupName) {
                return [
                    'groupName' => $groupName,
                    'settings' => $settings
                ];
            });

        return $collection->values();
    }
}
