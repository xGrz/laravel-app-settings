<?php

namespace xGrz\LaravelAppSettings\Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use xGrz\LaravelAppSettings\Support\Services\SyncService;

class LaravelAppSettingsSeeder extends Seeder
{
    public function run()
    {
        Artisan::call('vendor:publish', ['--tag' => 'laravel-app-settings']);
        SyncService::sync();
    }
}
