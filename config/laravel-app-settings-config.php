<?php

return [
    /*
     * Database table name. Configure this before migration is fired
     */
    'database_table' => 'settings',

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
