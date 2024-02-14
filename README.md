# Laravel-app-settings
Easy to use and high performance laravel module for handling settings for app.
Optimized with 1 hit cache/db each time app is reloaded.

Package handles default settings in config file so you can simply copy config file to second project with all settings already set.



## Installation


## Local/Dev Environment

### Seeding database with settings
In local/dev environment you can use our seeder class to sync settings each time you use `artisan migrate:fresh --seend`.
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

