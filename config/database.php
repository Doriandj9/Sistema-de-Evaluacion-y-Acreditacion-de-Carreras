<?php
require __DIR__ . './../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'pgsql',
    'host' => 'localhost',
    'database' => 'seac_2022',
    'username' => 'postgres',
    'password' => 'barcelona',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
