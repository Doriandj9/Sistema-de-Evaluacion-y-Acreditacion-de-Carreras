<?php

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;

class Notificaciones extends DatabaseTable
{
    public const TABLE = 'notificaciones';

    public function __construct()
    {
        parent::__construct(self::TABLE,'id');
    }

    public function obtenerNotificaciones($id_carrera,$id_docente) {
        $notificaciones = DB::table(self::TABLE)
        ->join('docentes','docentes.id','=','notificaciones.remitente')
        ->where('notificaciones.receptor','=',$id_docente)
        ->where('notificaciones.id_carrera','=',$id_carrera)
        ->select([
            'docentes.nombre as nombre_remitente',
            'docentes.apellido as apellido_remitente',
            'notificaciones.mensaje as mensaje',
            'notificaciones.fecha as fecha',
            'notificaciones.leido as leido',
            'notificaciones.id as id',
            'notificaciones.remitente as remitente'
        ])
        ->get();

        return $notificaciones;
    }
}