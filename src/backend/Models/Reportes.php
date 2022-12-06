<?php

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;

class Reportes {


    public function obtenerDatosReporteDocente($id_carrera,$id_periodo,$id_docente) {
        $collect = new \Illuminate\Support\Collection();
        $responsabilidades = DB::table('usuarios_responsabilidad')
        ->join('responsabilidad','responsabilidad.id','=','usuarios_responsabilidad.id_responsabilidad')
        ->where('id_carrera',$id_carrera)
        ->where('id_docentes',$id_docente)
        ->where('id_periodo_academico',$id_periodo)
        ->get();
        try {
            foreach($responsabilidades as $criterio){
                $evidencias = DB::select('
                select evidencias.id as id_evidencias
                    from criterios inner join estandar on estandar.id_criterio =
                    criterios.id inner join elemento_fundamental on elemento_fundamental.id_estandar =
                    estandar.id inner join componente_elemento_fundamental on componente_elemento_fundamental.id_elemento =
                    elemento_fundamental.id inner join evidencia_componente_elemento_fundamental on 
                    evidencia_componente_elemento_fundamental.id_componente = componente_elemento_fundamental.id
                    inner join evidencias on evidencia_componente_elemento_fundamental.id_evidencias = 
                    evidencias.id
                    where criterios.id = ?
                    GROUP BY evidencias.id',[$criterio->id_criterio]);
                foreach($evidencias as $evidenciaId){
                    $evidencia = DB::table('carreras_evidencias')
                    ->join('evidencias','evidencias.id','=','carreras_evidencias.id_evidencias')
                    ->where('id_periodo_academico','=',$id_periodo)
                    ->where('id_carrera','=',$id_carrera)
                    ->where('id_evidencias',$evidenciaId->id_evidencias)
                    ->select([
                        'pdf',
                        'evidencias.nombre as nombre_evidencia',
                        'fecha_registro'
                        ])
                    ->get()
                    ->first();
                    if(!$evidencia){
                        continue;
                    }
                    if($evidencia->pdf !== null){
                        $evidencia->almacenado = true;
                    }else {
                        $evidencia->almacenado = false;
                    }            
                    $collect->push($evidencia);
                }
                
            }
        }catch(\PDOException $e){
            echo $e->getMessage() . ' in ' . $e->getFile() . ' : ' . $e->getLine(); 
        }
       
        return $collect;
    }

}