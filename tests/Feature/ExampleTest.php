<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use xGrz\LaravelAppSettings\Support\Services\ConfigService;
use xGrz\LaravelAppSettings\Support\Services\SettingsCacheService;
use xGrz\LaravelAppSettings\Support\Services\SettingsDatabaseService;
use xGrz\LaravelAppSettings\Support\Services\SyncService;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_test()
    {
//        SyncService::sync();
//        dump( SettingsDatabaseService::get('pageLength.default') );
//        SettingsDatabaseService::set('pageLength.default', '20');
//        dd(
//            SettingsCacheService::get('pageLength.default'),
//            SettingsDatabaseService::get('pageLength.default')
//        );
    }
}
