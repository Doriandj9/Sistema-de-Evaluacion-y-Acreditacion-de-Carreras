<?php

declare(strict_types=1);

namespace App\backend\Controllers\Datos;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Frame\Autentification;
use App\backend\Models\Carreras;
use App\backend\Models\Docente;

class Docentes implements Controller
{
    private Docente $docentes;
    private Carreras $carreras;
    private Autentification $autentificacion;
    public function __construct()
    {
        $this->docentes = new Docente;
        $this->carreras = new Carreras;
        $this->autentificacion = new Autentification('correo', 'clave', $this->docentes);
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
            'template' => 'datos/docentes.html.php',
            'variables' => [
                'docentes' => $docentes
            ]
        ];
    }
    public function cambioClave()
    {
        $clave =  password_hash(trim($_POST['clave']), PASSWORD_DEFAULT);
        $data_cambio_clave = [
            'clave' => $clave,
            'cambio_clave' => false
        ];
        try {
            $this->docentes->updateValues($_POST['id_docente'], $data_cambio_clave);
            $_SESSION['clave'] = $clave;
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se actualizo correctamente la clave del usuario'
            ]));
        } catch (\PDOException $e) {
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => 'Error: ' . $e->getMessage()
                ]
            ));
        }
    }
    public function comprobacionClave()
    {
        $usuario = $this->autentificacion->getUsuario();
        if ($usuario && password_verify(trim($_POST['clave']), trim($usuario->clave))) {
            Http::responseJson(json_encode(
                [
                    'ident' => 1,
                    'mensaje' => 'Las claves cionciden correctamente'
                ]
            ));
        } else {
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => 'Error: La clave es incorrecta'
                ]
            ));
        }
    }
}
