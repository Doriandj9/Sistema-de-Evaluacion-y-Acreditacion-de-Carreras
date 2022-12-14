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
    public function obtenerDatosReporteCoordinadorEvidenciasAlmacenadas($id_carrera,$id_periodo) {
        $collect = new \Illuminate\Support\Collection();
        try {
                $evidencias = DB::select('
                select evidencias.id as id_evidencias
                    from criterios inner join estandar on estandar.id_criterio =
                    criterios.id inner join elemento_fundamental on elemento_fundamental.id_estandar =
                    estandar.id inner join componente_elemento_fundamental on componente_elemento_fundamental.id_elemento =
                    elemento_fundamental.id inner join evidencia_componente_elemento_fundamental on 
                    evidencia_componente_elemento_fundamental.id_componente = componente_elemento_fundamental.id
                    inner join evidencias on evidencia_componente_elemento_fundamental.id_evidencias = 
                    evidencias.id
                    GROUP BY evidencias.id');
                foreach($evidencias as $evidenciaId){
                    $evidencia = DB::table('carreras_evidencias')
                    ->join('evidencias','evidencias.id','=','carreras_evidencias.id_evidencias')
                    ->where('id_periodo_academico','=',$id_periodo)
                    ->where('id_carrera','=',$id_carrera)
                    ->where('id_evidencias',$evidenciaId->id_evidencias)
                    ->select([
                        'pdf',
                        'verificada',
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
                
            
        }catch(\PDOException $e){
            echo $e->getMessage() . ' in ' . $e->getFile() . ' : ' . $e->getLine(); 
        }
       
        return $collect;
    }
    public function obtenerDatosReporteCoordinadorDocentesEvidencias($id_carrera,$id_periodo) {
        $collect = new \Illuminate\Support\Collection();
        
        try {
                $evidencias = DB::select('
                select string_agg(criterios.nombre,\'---\') as nombre_criterio,
                string_agg(estandar.nombre,\'---\') as nombre_indicador,
                string_agg(estandar.id,\'---\') as numero_estandar,
                string_agg(elemento_fundamental.id,\'---\') as numero_elemento,
                evidencias.id as id_evidencias
                    from criterios inner join estandar on estandar.id_criterio =
                    criterios.id inner join elemento_fundamental on elemento_fundamental.id_estandar =
                    estandar.id inner join componente_elemento_fundamental on componente_elemento_fundamental.id_elemento =
                    elemento_fundamental.id inner join evidencia_componente_elemento_fundamental on 
                    evidencia_componente_elemento_fundamental.id_componente = componente_elemento_fundamental.id
                    inner join evidencias on evidencia_componente_elemento_fundamental.id_evidencias = 
                    evidencias.id
                    GROUP BY evidencias.id');
                foreach($evidencias as $evidenciaId){
                    $evidencia = DB::table('carreras_evidencias')
                    ->join('evidencias','evidencias.id','=','carreras_evidencias.id_evidencias')
                    ->where('id_periodo_academico','=',$id_periodo)
                    ->where('id_carrera','=',$id_carrera)
                    ->where('id_evidencias',$evidenciaId->id_evidencias)
                    ->select([
                        'pdf',
                        'verificada',
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
                    $evidencia->criterios = $evidenciaId->nombre_criterio;
                    $evidencia->indicador = $evidenciaId->nombre_indicador;      
                    $evidencia->numero_estandar = $evidenciaId->numero_estandar; 
                    $evidencia->numero_elemento = $evidenciaId->numero_elemento;
                    $evidencia->pdf = true;     
                    $collect->push($evidencia);
                }
            
        }catch(\PDOException $e){
            echo $e->getMessage() . ' in ' . $e->getFile() . ' : ' . $e->getLine(); 
        }
       
        return $collect;
    }
    public function obtenerDatosReporteCoordinadorAutevaluacion($id_carrera,$id_periodo) {
        $datos = [];
        try {
            $evidenciasDeCarreraAlmacenadas = DB::select('
                string_agg(evidencias.nombre ,\'---\') as nombre_evidencias, 
                string_agg(carreras_evidencias.cod_evidencia ,\'---\') as cod_evidencias,
                string_agg(carreras_evidencias.estado ,\'---\') as estado,
                evidencias.id as id_evidencias
                from evidencias inner join carreras_evidencias on
                carreras_evidencias.id_evidencias = evidencias.id inner join 
                evidencia_componente_elemento_fundamental 
                on evidencia_componente_elemento_fundamental.id_evidencias = carreras_evidencias.id_evidencias inner join
                componente_elemento_fundamental on 
                componente_elemento_fundamental.id = evidencia_componente_elemento_fundamental.id_componente inner join 
                elemento_fundamental on elemento_fundamental.id = componente_elemento_fundamental.id_elemento inner join 
                estandar on estandar.id = elemento_fundamental.id_estandar inner join criterios 
                on criterios.id = estandar.id_criterio where carreras_evidencias.id_carrera = ?
                and carreras_evidencias.id_periodo_academico = ?
                GROUP BY evidencias.id
                ',[]);
            
        }catch(\PDOException $e){
            echo $e->getMessage() . ' in ' . $e->getFile() . ' : ' . $e->getLine(); 
        }
       
        return;
    }
}