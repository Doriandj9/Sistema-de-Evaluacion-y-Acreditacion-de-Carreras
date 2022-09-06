<?php

declare(strict_types=1);

namespace App\backend\Controllers\Datos;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Carreras;
use App\backend\Models\Docente;

class Docentes implements Controller
{
    private Docente $docentes;
    private Carreras $carreras;
    public function __construct()
    {
        $this->docentes = new Docente;
        $this->carreras = new Carreras;
    }
    public function vista($variables = []): array
    {
        if (isset($_GET['carrera'])) {
            $docentes = $this->carreras->getDatosDocentes($_GET['carrera']);
        } else {
            Http::responseJson(json_encode(
                ['ident' => 0,'error' => 'Error no se encontro ningun id de carrera']
            ));
        }
        return [
            'title' => '',
            'template' => 'docentes/datos.html.php',
            'variables' => [
                'docentes' => $docentes
            ]
        ];
    }
}
