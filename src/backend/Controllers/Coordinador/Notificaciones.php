<?php

namespace App\backend\Controllers\Coordinador;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Notificaciones as ModelsNotificaciones;

class Notificaciones implements Controller
{
    private ModelsNotificaciones $notificaciones;
    public function __construct()
    {
        $this->notificaciones = new ModelsNotificaciones;
    }

    public function vista($variables = []): array
    {
        return [
            'title' => 'Mis Notificaciones',
            'template' => 'coordinadores/notificaciones.html.php'
        ];
    }

    public function listarNotificaciones() {
        try{
            $notificaciones = $this->notificaciones->obtenerNotificaciones(
                trim($_SESSION['carrera']),
                trim($_SESSION['ci'])
            );
            Http::responseJson(json_encode([
                'ident' => 1,
                'notificaciones' => $notificaciones
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => $e->getMessage()
            ]));
        }
    }

    public function leidoNotificacion() {
        $data = [
            'leido' => true,
        ];
        $this->notificaciones->updateValues(intval($_POST['id']),$data);
        Http::responseJson(json_encode([
            'ident' => 1
        ]));
    }
}