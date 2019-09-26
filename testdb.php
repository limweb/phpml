<?php
require_once __DIR__ . '/vendor/autoload.php';
$config = [
    'default' => 'default',
    'fetch' => \PDO::FETCH_OBJ,
    'connections' => [
        'default' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3307',
            'database' => 'mui',
            'username' => 'root',
            'password' => '',
            'unix_socket' => false,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
    ],
];
SwooleEloquent\Db::init($config);
$rs = SwooleEloquent\Db::table('lots')->limit(10)->get();
echo 'test';
echo json_encode($rs);
