<?php

use Illuminate\Support\Facades\Route;
use xGrz\LaravelAppSettings\Http\Controllers\ApiSettingsListingController;
use xGrz\LaravelAppSettings\Http\Controllers\EditSettingController;
use xGrz\LaravelAppSettings\Http\Controllers\SettingsGroupedController;
use xGrz\LaravelAppSettings\Http\Controllers\SettingsListingController;
use xGrz\LaravelAppSettings\Http\Controllers\ApiSettingsGroupedController;
use xGrz\LaravelAppSettings\Http\Controllers\UpdateSettingController;
use xGrz\LaravelAppSettings\Support\Facades\Config;


Route::name('laravel-app-settings.')
    ->middleware(['web'])
    ->group(function() {
        Route::get(Config::getRoute(), fn() => to_route('laravel-app-settings.listing.index'));

        Route::get(Config::getRoute('listing'), SettingsListingController::class)->name('listing.index');
        Route::get(Config::getRoute('resource/listing'), ApiSettingsListingController::class)->name('resource.listing');

        Route::get(Config::getRoute('grouped'), SettingsGroupedController::class)->name('grouped.index');
        Route::get(Config::getRoute('resource/grouped'), ApiSettingsGroupedController::class)->name('resource.grouped');

        Route::get(Config::getRoute('{setting}/edit'), EditSettingController::class)->name('edit');
        Route::patch(Config::getRoute('{setting}/edit'), UpdateSettingController::class)->name('update');
    });

