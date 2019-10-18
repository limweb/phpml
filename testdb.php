<?php
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'facedb',
    'database'  => 'faces',
    'username'  => 'dbuser',
    'password'  => 'dbpass',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

class Asset extends Model
{
        protected	$table='assets';
        protected	$primaryKey='id';
        public	$timestamps = false;

}

$asset = new Asset();
$asset->name = 'name';
$asset->gender = 'male';
$asset->acces = 'door 1 in';
$asset->created_at = '2019-10-16 00:00:00';
$asset->updated_at = '2020-10-16 00:00:00';
$asset->save();
