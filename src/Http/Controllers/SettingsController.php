<?php

namespace xGrz\LaravelAppSettings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use xGrz\LaravelAppSettings\Support\Services\SettingsCacheService;
use xGrz\LaravelAppSettings\Support\Services\SettingsDatabaseService;
use xGrz\LaravelAppSettings\Support\Services\SyncService;

class SettingsController extends Controller
{

    public function index(): View
    {
        return view('laravel-app-settings::index', [
            'title' => 'Laravel-App-Settings',

        ]);
    }

    public function test()
    {
        //SettingsDatabaseService::get('pageLength.default');
        SettingsCacheService::get('pageLength.default');

//        SyncService::sync();
//        dump( SettingsDatabaseService::get('pageLength.default') );
//        SettingsDatabaseService::set('pageLength.default', '20');
//        dd(
//            SettingsCacheService::get('pageLength.default'),
//            SettingsDatabaseService::get('pageLength.default')
//        );
    }
}
