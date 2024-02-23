<?php

namespace xGrz\LaravelAppSettings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use xGrz\LaravelAppSettings\Enums\ListingType;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\Config;

class CacheViewController extends Controller
{
    public function __invoke(Setting $setting): View
    {
        return view('laravel-app-settings::cache.view', [
            'backRoute' => self::getBackRouteName(),
            'title' => 'Cache status for ' . $setting->key,
            'original' => $setting->toArray(),
            'cache' => setting($setting->key),
            'match' => self::valuesMatch($setting->toArray()['value'], setting($setting->key)),
            'isCached' => Config::usesCache(),
        ]);
    }

    private function valuesMatch(mixed $modelValue, mixed $currentValue): bool
    {
        return $modelValue === $currentValue;
    }

    private function getBackRouteName(): string
    {
        try {
            $type = ListingType::from(request()->get('listingType'));
            return Config::getRouteUri($type->value);
        } catch (\ValueError $e) {
            return Config::getRouteUri(ListingType::LISTING->value);
        }
    }


}
