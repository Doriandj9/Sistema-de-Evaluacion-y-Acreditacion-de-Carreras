<?php

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;

class Reportes {


    public function obtenerDatosReporteDocente($id_carrera,$id_periodo,$id_docente) {
        $collect = new \Illuminate\Support\Collection();
        $responsabilidades = DB::select(
            'select string_agg(responsabilidad.id::text,\'--\') as id_responsabilidad,
            string_agg(usuarios_responsabilidad.id_docentes,\'--\')  as id_docentes, 
            string_agg(usuarios_responsabilidad.id_periodo_academico ,\'--\') as id_periodo, 
            string_agg(usuarios_responsabilidad.id_carrera,\'--\') as carrera, 
            id_evidencias 
            from usuarios_responsabilidad inner join responsabilidad on 
            responsabilidad.id = usuarios_responsabilidad.id_responsabilidad 
            where usuarios_responsabilidad.id_docentes = ? and 
            usuarios_responsabilidad.id_carrera = ? and 
            usuarios_responsabilidad.id_periodo_academico = ?
            group by responsabilidad.id_evidencias'
        ,[$id_docente,$id_carrera,$id_periodo]);
        foreach($responsabilidades as $responsabilidad){
            $evidencia = DB::table('carreras_evidencias')
            ->join('evidencias','evidencias.id','=','carreras_evidencias.id_evidencias')
            ->where('id_periodo_academico','=',$id_periodo)
            ->where('id_carrera','=',$id_carrera)
            ->where('id_evidencias',$responsabilidad->id_evidencias)
            ->select([
                'pdf',
                'evidencias.nombre as nombre_evidencia',
                'fecha_registro'
                ])
            ->get()
            ->first();
            if($evidencia->pdf !== null){
                $evidencia->almacenado = true;
            }else {
                $evidencia->almacenado = false;
            }            
            $collect->push($evidencia);
        }
        return $collect;
    }

}