<?php

use Illuminate\Support\Facades\Route;
use xGrz\LaravelAppSettings\Http\Controllers\SettingsController;


Route::resource('settings', SettingsController::class)
    ->middleware('web')
    ->only(['index', 'edit', 'update']);
