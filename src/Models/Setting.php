<?php

namespace xGrz\LaravelAppSettings\Models;

use Illuminate\Database\Eloquent\Model;
use xGrz\LaravelAppSettings\Enums\SettingValueType;
use xGrz\LaravelAppSettings\Support\Services\ConfigService;

class Setting extends Model
{
    protected $guarded = ['id', 'key'];
    protected $casts = ['type' => SettingValueType::class];

    public function getTable(): string
    {
        return (new ConfigService)->getDatabaseTable();
    }

}
