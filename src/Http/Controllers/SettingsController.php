<?php

namespace xGrz\LaravelAppSettings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use xGrz\LaravelAppSettings\Http\Requests\UpdateSettingRequest;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\Settings as SettingFacade;

class SettingsController extends Controller
{
    public function index(): View
    {
        return view('laravel-app-settings::index', [
            'title' => 'Laravel-App-Settings',
            'settings' => Setting::all(),
        ]);
    }

    public function edit(Setting $setting): View
    {
        return view('laravel-app-settings::edit', [
            'title' => 'Edit key',
            'setting' => $setting->toArray()
        ]);
    }

    public function update(UpdateSettingRequest $request, Setting $setting): RedirectResponse
    {
        SettingFacade::update($setting->key, $request->validated());
        return to_route('settings.index');
    }

}
