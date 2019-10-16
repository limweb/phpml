<?php 

require __DIR__. '/vendor/autoload.php';
// require dirname(__DIR__) . '/config.php';

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Cache\CacheManager as CacheManager;

$dbc = new DB;

$dbc->addConnection(array(
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'port'      => '3308',
    'database'  => 'faces',
    'username'  => 'dbuser',
    'password'  => 'dbpass',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
));

# Set the default fetch mode for all queries
$dbc->setFetchMode(PDO::FETCH_CLASS);

# Set up the cache
$container = $dbc->getContainer();

$container['config']['cache.driver'] = 'redis';
$container['config']['cache.redis'] = array('host' => '127.0.0.1', 'port' => 6379, 'database' => 0);

$container->offsetGet('config')->offsetSet('cache.driver', 'array');

$cacheManager = new CacheManager($container);

$dbc->setAsGlobal();
$dbc->bootEloquent();

global $dbc;


$faces =  DB::table('faces')->get();

$redis = new Redis();    
$redis->pconnect('127.0.0.1',6379);
// $redis->set('faces', $faces->toJson());
$fs =  json_decode($redis->get('faces'));
dump($fs[0]->gender);