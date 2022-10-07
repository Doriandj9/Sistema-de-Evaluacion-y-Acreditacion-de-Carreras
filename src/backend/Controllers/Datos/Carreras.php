<?php

namespace App\backend\Controllers\Datos;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Docente;


class Carreras implements Controller {
    private Docente $carreras;

    public function __construct()
    {
        $this->carreras = new Docente;
    }

    public function vista($variables = []): array
    {
        $carrerasPorUsusario = $this->carreras->getCarrerasPorPermisos(
            $_POST['id_usuarios'],
            $_POST['id_docente']
        );
        return [
            'title' => '',
            'template' => 'datos/carreras-por-usuario.html.php',
            'variables' => [
                'carreras' => $carrerasPorUsusario
            ]
        ];
    }

    public function guardarOpciones() {
        try {
            //code...
            $_SESSION['opciones'] = true;
            $_SESSION['carrera'] = trim($_POST['carrera']);
            $_SESSION['permiso'] = trim(intval($_POST['permiso']));
            Http::responseJson(json_encode(
                [
                    'ident' => 1,
                    'mensaje' => 'Se ingresaron los datos a la session correctamente'
                ]
            ));
        } catch (\Throwable | \ErrorException $th) {
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => $th->getMessage()
                ]
            ));
        }

    }
}
