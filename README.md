# Laravel-app-settings

Easy to use and high performance laravel module for handling settings for app.
Optimized with 1 hit cache/db each time app is reloaded.

Package handles default settings in config file so you can simply copy config file to second project with all settings
already set.

## 1. Installation

### 1.1. Install package via composer:

```
composer require xgrz/laravel-app-settings
```

### 1.2. Publish configuration:

```
php artisan app-settings:publish
```

After publishing, you will find 2 config files in your `app/config` directory.

- `laravel-app-settings-config` contains package configuration
- `laravel-app-settings-definitions` contains settings definitions

#### Set database table name (before migration)

Please fill free to update `laravel-app-settings-config` -> `database_table` in case on conflict with your database
schema.
Default table name is set to `settings`.

### 1.3. Run migration

Run migrations:

```
php artisan migrate
```

### 1.4 Config and sync settings

Edit your `laravel-app-settings-definitions` file with your own settings (see #3 Defining settings).
After all changes are maid you have to run

``` 
php artisan app-settings:sync 
```

# 2. Defining settings

## 2.1. Introduction

In your config file `app/config/laravel-app-settings-definitions.php` you will keep all initial settings.
To keep it clean, definitions are divided into groups (1st. level) and setting names (2nd level). Third level
is definition of setting type. Pair of `group` and `key-name` joined with `.` is setting key, which is automatically
generated in mysql.

```
return [
    'application' => [
        'name' => [
            // ...
        ],
        'use_custom_name' => [
            // ...
        ],
    ],
    'page' => [
        'size' => [
            // ...
        ]
    ]
```

In that case you have defined three keys:

- `application.name`
- `application.use_custom_name`
- `page.size`

## 2.2. Defining key props

```
[
    'type' => Enum SettingValueType,
    'value' => 'Initial value of defined key',
    'description' => 'Setting description',
]
```

### 2.2.1. `type` prop
Definition of stored value. We expect to use predefined value in enum:
```
use xGrz\LaravelAppSettings\Enums\SettingValueType;
```

- **SettingValueType::Text** - string values,
- **SettingValueType::Number** - numeric values,
- **SettingValueType::Selectable** - string values in array,
- **SettingValueType::BooleanType** - true/false values only,

### 2.2.2. `value` prop
Define initial value for key

### 2.2.3. `description` prop
String value that describes defined key. Optional, but recommended.












## Working with Local/Dev environment

### Seeding database with settings

In local/dev environment you can use our seeder class to sync settings each time you
use `artisan migrate:fresh --seed`.
That prevents you to run sync command each time database is refreshed.

If you want to enable this feature just add
`$this->call(xGrz\LaravelAppSettings\Database\Seeders\LaravelAppSettingsSeeder::class);`
into your `Database\Seeders\DatabaseSeeder` class (in run method). It should look like:

```
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use xGrz\LaravelAppSettings\Database\Seeders\LaravelAppSettingsSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(LaravelAppSettingsSeeder::class);
        // ... [other seeders]
    }
}



```

