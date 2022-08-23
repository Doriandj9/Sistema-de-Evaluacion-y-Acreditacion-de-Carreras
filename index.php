<?php
include __DIR__ . '/vendor/autoload.php';

use App\backend\Application\ContentRoutes;
use App\backend\Frame\EntryPoint;
use Symfony\Component\Dotenv\Dotenv;



$route = rtrim(ltrim(strtok($_SERVER['REQUEST_URI'],'?'),'/'),'/');
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/config/.env');
try{

    $entryPoint = new EntryPoint($route,$_SERVER['REQUEST_METHOD'],new ContentRoutes);
    $entryPoint->run();
    
}catch(\PDOException $e){
    $titulo = 'ERROR BASE DATOS';
    $contenido = 'Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' : ' . $e->getLine();

    include __DIR__ . '/src/backend/Views/templates/layout_principal.html.php';
}