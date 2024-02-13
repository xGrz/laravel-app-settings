<?php

namespace xGrz\LaravelAppSettings\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use xGrz\LaravelAppSettings\Support\Services\SyncService;

class PublishCommand extends Command
{
    protected $signature = 'laravel-app-settings:publish';
    protected $description = 'Publish laravel settings config file';

    public function handle()
    {
        $this->newLine();

        $res = $this->call('vendor:publish', ['--tag' => 'laravel-app-settings']);
        dump($res);

        $this->newLine();

//        return $result
//            ? Command::SUCCESS
//            : Command::FAILURE;
    }
}

