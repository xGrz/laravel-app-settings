<?php

use Illuminate\Support\Facades\Route;
use xGrz\LaravelAppSettings\Http\Controllers\ApiSettingsGroupedController;
use xGrz\LaravelAppSettings\Http\Controllers\ApiSettingsListingController;
use xGrz\LaravelAppSettings\Http\Controllers\CacheViewController;
use xGrz\LaravelAppSettings\Http\Controllers\EditSettingController;
use xGrz\LaravelAppSettings\Http\Controllers\SettingsGroupedController;
use xGrz\LaravelAppSettings\Http\Controllers\SettingsListingController;
use xGrz\LaravelAppSettings\Http\Controllers\UpdateSettingController;
use xGrz\LaravelAppSettings\Support\Facades\Config;


Route::name('laravel-app-settings.')
    ->middleware(['web'])
    ->group(function () {
        Route::get(Config::getRouteUri(''), function () {
            return to_route('laravel-app-settings.listing');
        })->name('index');

        Route::get(Config::getRouteUri('listing'), SettingsListingController::class)->name('listing');
        Route::get(Config::getRouteUri('resource/listing'), ApiSettingsListingController::class)->name('resource.listing');

        Route::get(Config::getRouteUri('grouped'), SettingsGroupedController::class)->name('grouped');
        Route::get(Config::getRouteUri('resource/grouped'), ApiSettingsGroupedController::class)->name('resource.grouped');

        Route::get(Config::getRouteUri('{setting}/edit'), EditSettingController::class)->name('edit');
        Route::patch(Config::getRouteUri('{setting}/edit'), UpdateSettingController::class)->name('update');

        Route::get(Config::getRouteUri('{setting}/cache'), CacheViewController::class)->name('cache');
    });

