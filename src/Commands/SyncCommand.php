<?php

namespace xGrz\LaravelAppSettings\Commands;

use Illuminate\Console\Command;
use xGrz\LaravelAppSettings\Exceptions\LaravelSettingsSourceFileMissingException;
use xGrz\LaravelAppSettings\Support\Services\ConfigService;
use xGrz\LaravelAppSettings\Support\Services\SyncService;

class SyncCommand extends Command
{
    protected $signature = ConfigService::ARTISAN_CALLOUT . ':sync';
    protected $description = 'Synchronize laravel settings config definitions with application';

    public function handle()
    {
        $this->newLine();
        try {
            SyncService::sync();
        } catch (LaravelSettingsSourceFileMissingException $e) {
            $signature = ConfigService::ARTISAN_CALLOUT . ':publish';
            $this->error(' ERROR: Laravel-App-Settings definition file not synchronized. ');
            $this->info($e->getMessage());
            $this->newLine();
            $this->warn(" Use artisan $signature first! ");
            $this->newLine();
            return Command::FAILURE;

        }
        $this->newLine();

        return Command::SUCCESS;
    }
}

