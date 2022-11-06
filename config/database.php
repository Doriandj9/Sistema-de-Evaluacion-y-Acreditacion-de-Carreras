<?php
require __DIR__ . './../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
$dir_env = __DIR__ . '/.env';
$dotenv = new Dotenv();
$dotenv->load($dir_env ?? __DIR__ . '/../.env');

$capsule = new Capsule;
$capsule->addConnection([
    'driver' => $_ENV['DRIVER'],
    'host' => $_ENV['HOST'],
    'database' => $_ENV['DBNAME'],
    'username' => $_ENV['DBUSER'],
    'password' => $_ENV['PASSDATABASE'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
    

    
