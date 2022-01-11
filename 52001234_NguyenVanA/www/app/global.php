<?php
use Illuminate\Database\Capsule\Manager as DB;

$capsule = new DB;
$capsule->addConnection([
    'driver'    => DB_CONNECTION,
    'host'      => DB_HOST,
    'port'      => DB_PORT,
    'database'  => DB_DATABASE,
    'username'  => DB_USERNAME,
    'password'  => DB_PASSWORD,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
], "default");
// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this DB instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();
// $users = DB::table('gm_users')->first();

?>