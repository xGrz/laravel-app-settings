<?php

use xGrz\LaravelAppSettings\Enums\SettingValueType;

/*
 * Each time you change/add/remove any element of array remember to use console:
 * php artisan laravel-app-settings:sync
 */

return [
    [
        'application' => [
            'name' => [
                'value' => 'LarApp',
                'type' => SettingValueType::Text,
                'description' => 'Application name',
            ],
            'use_custom_name' => [
                'value' => true,
                'type' => SettingValueType::BooleanType,
                'description' => 'Application name',
            ],
        ],
        'pageLength' => [
            'default' => [
                'value' => 50,
                'type' => SettingValueType::Number,
                'description' => 'Default items per page'
            ],
            'options' => [
                'value' => [10, 20, 50, 100],
                'type' => SettingValueType::Selectable,
                'description' => 'Options for items per page'
            ]
        ],
    ]
];
