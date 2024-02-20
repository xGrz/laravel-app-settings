# Laravel-app-settings

Easy to use and high performance laravel module for handling settings for app.
Optimized with 1 hit cache/db each time app is reloaded.

Package handles default settings in config file, so you can simply copy config file to second project with all settings
already set.

## 1. Installation

**Install package via composer**

```
composer require xgrz/laravel-app-settings
```

**Publish configuration**

```
php artisan app-settings:publish
```

After publishing, you will find 2 config files in your `app/config` directory.

- `laravel-app-settings-config` contains package configuration
- `laravel-app-settings-definitions` contains settings definitions

**Set database table name (before next step)**

Fill free to update `app/config/laravel-app-settings-config.php` -> `database_table` in case on conflict with your database
schema.
Default table name is set to `settings`.

**Run migration**
```
php artisan migrate
```

**Config and sync settings**

Edit your `app/config/laravel-app-settings-definitions` file with your own settings.
After all changes are made you have to run sync command in terminal

``` 
php artisan app-settings:sync 
```

## 2. Use settings in code
In this example lets assume, that setting key `application.key` is already exists.

**Preferred way to get your setting value is use global helper function:**
> setting('*application.name*');

Function `setting($param);` accepts as a parameter only setting key.

**Second way to get your value is use Settings facade**
> use xGrz\LaravelAppSettings\Support\Facades\Settings;
> 
> Settings::get('application.name`);

This facade method accepts setting key as parameter only.

**Missing key behavior**
> **If key doesn't exist** 
> 
> xGrz\LaravelAppSettings\Exceptions\SettingsKeyNotFoundException
> 
> will be thrown.

## 3. Modify settings

If you want to modify only setting value the simplest way is use facade

> use xGrz\LaravelAppSettings\Support\Facades\Settings;
>
> Settings::set('application.name`, 'SOME NEW VALUE');

In case of managing settings you may want to change description too.

```
use xGrz\LaravelAppSettings\Support\Facades\Settings;

Settings::update('application.name`, [
    'value' => 'SOME NEW VALUE',
    'description' => 'New setting key description'
]);
```

Out of the box you can use our FormRequest to validate incoming update data in your controller.

## 4. Add/remove new settings

### 4.1 Add settings

Go to `app/config/laravel-app-settings-definitions.php`.
In this config file you will see tree of defined groups and settings.
You are allowed to add new groups and key-names. You can always remove key-name/group from definition file at any time.

After changes are made in definitions file you have to always sync by using artisan command:
> php artisan app-settings:sync

**Define new settings group**
Open definitions file and add new array item, for example lets sey we want to add new group named `seo`:

```
return [
    // some existsing settings
    'seo' => [
        // key-names for seo group.
    ]
]
```

`seo` group is empty, so lets add some keys:

```
return [
    // some existsing settings
    'seo' => [
        'google_gtm' => [
            // definition of seo.google_gtm key
        ],
        'adwords_id' => [
            // definition of seo.adwords_id
        ]
    ]
]
```

Each key should be defined with `value`, `description` and `type`. 

`type` prop expecting to provide SettingValueType (enum `xGrz\LaravelAppSettings\Enums\SettingValueType`). 
You can choose from:
- SettingValueType::Text (string), 
- SettingValueType::Number (integers, floats), 
- SettingValueType::Selectable (array),  
- SettingValueType::BooleanType (boolean values),

`value` prop is an initial value for key and must be valid for defined type of setting value.

`description` optional prop. Helpful when you administrate your settings with user interface.

Your config should look like:

```
return [
    // some existsing settings
    'seo' => [
        'google_gtm' => [
            'value' => '',
            'type' => SettingValueType::Text,
            'description' => 'Google Tag Manager'
        ],
        'adwords_id' => [
            'value' => 123093093,
            'type' => SettingValueType::Number,
            'description' => 'Google adwords id'
        ]
    ]
]
```

> **Remember to sync settings after editing definitions file**
>> php artisan app-settings:sync

## 4.2. Remove settings

Delete key name or whole group from definition file and run sync

```
php artisan app-settings:sync
```


## 5. Settings sync after database refresh (seeder).

Everytime you refresh your database you have to run sync (`php artisan app-settings:sync`) to get back your initial settings.
Typically, you want the application to be ready for use after clearing the database, so you can automate this process by adding Seeder.

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




