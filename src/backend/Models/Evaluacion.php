<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;

class Evaluacion extends DatabaseTable
{
    public const TABLE = 'evaluacion';
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id');
    }
    /**
     * @param string $evidencia es el id de la evidencia
     * @param string $carrera es el id de la carrera
     * @param string $periodo es el id del periodo academico
     * 
     */
    public function obtenerCalificacion($evidencia,$carrera,$periodo) {
        $calificacion = DB::table(self::TABLE)
        ->join(
            'evidencias_evaluacion',
            'evidencias_evaluacion.id_evaluacion',
            '=',
            'evaluacion.id'
        )->join(
            'evaluacion_docentes',
            'evaluacion_docentes.id_evaluacion',
            '=',
            'evaluacion.id'
        )->join(
            'docentes',
            'docentes.id',
            'evaluacion_docentes.id_docente'
        )->where('evidencias_evaluacion.id_evidencia','=',$evidencia)
        ->where('evidencias_evaluacion.id_carrera','=',$carrera)
        ->where('evidencias_evaluacion.id_periodo','=',$periodo)
        ->select([
            'docentes.nombre as nombre_docente',
            'docentes.apellido as apellido_docente',
            'evaluacion.nota as calificacion',
            'evaluacion.observacion as observacion'
        ])
        ->get();
        return $calificacion;
    }
     /**
     * @param string $evidencia es el id de la evidencia
     * @param string $carrera es el id de la carrera
     * @param string $periodo es el id del periodo academico
     * 
     */
    public function verCalificacion($evidencia,$carrera,$periodo) {
        $calificacion = DB::table('evidencias_evaluacion')
        ->where('evidencias_evaluacion.id_evidencia','=',$evidencia)
        ->where('evidencias_evaluacion.id_carrera','=',$carrera)
        ->where('evidencias_evaluacion.id_periodo','=',$periodo)
        ->get()->first();
        if(!$calificacion){
            return false;
        }

        return true;
    }
}
