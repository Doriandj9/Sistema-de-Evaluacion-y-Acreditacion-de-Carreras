<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;

class CarrerasEvidencias extends DatabaseTable
{
    public const TABLE = 'carreras_evidencias';
    public $timestamps = false;

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
            'evidencias.nombre as nombre_evidencia',
            'carreras_evidencias.id_responsable as responsable'
        ])
        ->where('id_periodo_academico','=',$periodo)
        ->where('id_carrera',$carrera)
        ->get();

        return $evidencias;
    }
    /**
     * @param array<array> $datos
     */
    public function insertMasivo(array $datos,array $columnas){
        $queryMasive = 'INSERT INTO carreras_evidencias(';
        foreach($columnas as $columna) {
            $queryMasive .=  $columna . ',';
        }
        $queryMasive = rtrim($queryMasive,',');
        $queryMasive .= ')VALUES(';
        foreach($datos as $dato) {
            foreach($dato as $valor){
                $queryMasive .= '\'' . $valor .'\'' . ',';
            }
        $queryMasive = rtrim($queryMasive,',');
        $queryMasive .= '),(';
        } 
        $queryMasive = rtrim($queryMasive,',(');
        $queryMasive .= ';';
        DB::statement($queryMasive);
    }
}
