<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;

class CarrerasEvidencias extends DatabaseTable
{
    public const TABLE = 'carreras_evidencias';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id_periodo_academico');
    }

    public function obtenerEvidenciasPorPeriodo(string $periodo,string $carrera) {
        $evidencias = DB::table(self::TABLE)
        ->join('evidencias','evidencias.id','=','carreras_evidencias.id_evidencias')
        ->select([
            'evidencias.id as id_evidencias',
            'carreras_evidencias.cod_evidencia as cod_evidencias',
            'evidencias.nombre as nombre_evidencia'
        ])
        ->where('id_periodo_academico','=',$periodo)
        ->where('id_carrera',$carrera)
        ->get();

        return $evidencias;
    }
}
