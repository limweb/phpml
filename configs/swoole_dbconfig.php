<?php
$swooledbconfig = [
    'default' => 'default',
    'fetch' => \PDO::FETCH_OBJ,
    'connections' => [
        'default' => [
            'driver' => env('DB_CONNECTION', 'mysql'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'), // default port number
            'database' => env('DB_NAME', 'dbname'),
            'username' => env('DB_USER', 'dbuser'),
            'password' => env('DB_PASSWORD', 'dbpass'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'collation' => env('DB_COLLATE', 'utf8_unicode_ci'),
            'prefix' => env('DB_PREFIX', ''),
            'unix_socket' => false,
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
    ],
];
