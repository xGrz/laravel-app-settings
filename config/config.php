<?php

return [
    /*
     * Database table name. Configure this before migration is fired
     */
    'database_table' => 'settings',

    /*
     * Expose example user interface with blade views for managing settings
     * This route is not protected with middlewares. Do not use it in prod.
     */
    'expose_ui' => false,

    /*
     * When UI is exposed you can set route uri (suffixes will be added)
     */
    'route_uri' => 'laravel-app-settings',

    /*
     * Cache configuration
     */
    'cache' => [
        /*
         * Set cache timeout for settings (in seconds)
         * You can set to null/false to disable cache
         */
        'timeout' => 86400,

        /* Cache key to store data. Change only when you have a conflict with other modules */
        'key' => 'LaravelSettings'
    ],

];
