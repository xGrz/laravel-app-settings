<?php

use Illuminate\Support\Facades\Route;
use xGrz\LaravelAppSettings\Http\Controllers\SettingsController;

Route::name('laravel-app-settings.')
    ->controller(SettingsController::class)
    ->prefix('laravel-app-settings')
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/test', 'test')->name('test');
    });

