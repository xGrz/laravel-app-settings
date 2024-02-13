<?php

namespace xGrz\LaravelAppSettings\Commands;

use Illuminate\Console\Command;
use xGrz\LaravelAppSettings\Support\Services\ConfigService;

class PublishCommand extends Command
{
    protected $signature = ConfigService::ARTISAN_CALLOUT . ':publish';
    protected $description = 'Publish laravel settings config file';

    public function handle()
    {
        $this->newLine();
        $this->call('vendor:publish', ['--tag' => 'laravel-app-settings']);
        $this->newLine();

        return Command::SUCCESS;
    }
}

