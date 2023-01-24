<?php

namespace App\backend\Controllers\Administrador;

use App\backend\Controllers\Controller;

class Respaldos implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Respaldos de la base de datos',
            'template' => 'administrador/respaldos.html.php'
        ];
    }

    public function generar(){
        $uuid = uniqid();
        if(system('pg_dump -U postgres -W -h localhost seac_2022 > backup_seac_'. $uuid .'.sql')){
            echo 'con exito';
        }else {
            echo 'A ocurrido un error';
        }
    }
}