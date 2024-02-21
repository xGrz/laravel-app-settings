<?php

namespace xGrz\LaravelAppSettings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use xGrz\LaravelAppSettings\Exceptions\SettingsKeyNotFoundException;
use xGrz\LaravelAppSettings\Exceptions\SettingValueValidationException;
use xGrz\LaravelAppSettings\Http\Requests\UpdateSettingRequest;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\Settings;

class EditSettingController extends Controller
{

    public function  __invoke(Setting $setting): View
    {
        return view('laravel-app-settings::edit.edit', [
            'title' => 'Edit key',
            'setting' => $setting->toArray()
        ]);
    }


}
