<?php

namespace App\backend\Controllers\Docente;

use App\backend\Controllers\Controller;
use App\backend\Application\Utilidades\Http;
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
            'template' => 'docentes/notificaciones.html.php'
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
    public function borrarNotificacion() {
        try{
            $this->notificaciones->deleteRaw(intval(trim($_POST['id'])));
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'OK'
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }   
    }

    public function enviarNotificacion() {
        date_default_timezone_set('America/Guayaquil');
        $date = new \DateTime();
        $data_notificacion = [
            'remitente' => trim($_SESSION['ci']),
            'receptor' => trim($_POST['receptor']),
            'mensaje' => trim($_POST['mensaje']),
            'id_carrera' => trim($_SESSION['carrera']),
            'fecha' => $date->format('Y-m-d H:i:s'),
            'leido' => false
        ];
        try{
            $this->notificaciones->insert($data_notificacion);
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se envio correctamente la notificación'
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
    }
}