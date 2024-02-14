<?php

namespace xGrz\LaravelAppSettings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use xGrz\LaravelAppSettings\Models\Setting;
use xGrz\LaravelAppSettings\Support\Facades\LaravelAppSettings;

class SettingsController extends Controller
{

    public function index(): View
    {
        return view('laravel-app-settings::index', [
            'title' => 'Laravel-App-Settings',
            'settings' => Setting::all(),
        ]);
    }

    public function test()
    {
        dump(
            LaravelAppSettings::grouped(),
            LaravelAppSettings::grouped('application')
        );
    }
}
