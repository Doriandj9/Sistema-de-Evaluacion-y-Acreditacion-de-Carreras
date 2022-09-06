<?php
include __DIR__ . '/vendor/autoload.php';

use App\backend\Application\ContentRoutes;
use App\backend\Frame\EntryPoint;



$route = rtrim(ltrim(strtok($_SERVER['REQUEST_URI'],'?'),'/'),'/');

try{

    $entryPoint = new EntryPoint($route,$_SERVER['REQUEST_METHOD'],new ContentRoutes);
    $entryPoint->run();
    
}catch(\PDOException $e){
    $titulo = 'ERROR BASE DATOS';
    $contenido = 'Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' : ' . $e->getLine();

    include __DIR__ . '/src/backend/Views/templates/layout_principal.html.php';
}