<?php

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;

class Evidencias extends DatabaseTable
{
    public const TABLE = 'evidencias';
    private $carreraId;
    private $periodoId;
    private $results;
    public function __construct()
    {
        parent::__construct(self::TABLE,'id');
    }
    /**
     * @param string $periodoId es el id del perio a buscar las evidencias
     * @param string $carreraId es el id de la carrera que se van a buscar las evidencias
     * 
     * @return \Illuminate\Support\Collection coleccion de evidencias
     */
    public function obtenerEvidenciasPorPeriodo(string $periodoId,string $carreraId): \Illuminate\Support\Collection
    {
        $this->periodoId = $periodoId;
        $this->carreraId = $carreraId;
        $this->results = [];
        $this->chunk(50,function($evidencias) {
            foreach($evidencias as $evidencia) {
                array_push($this->results,$evidencia);
            }
        });
        $colection = new \Illuminate\Support\Collection($this->results);
        return $colection;

    }
     /**
    * Chunk the results of the query.
    *
    * @param  int  $count
    * @param  callable  $callback
    * @return bool
    */
    private function chunk($count, callable $callback)
   {
       $page = 1;

       do {
           // We'll execute the query for the given page and get the results. If there are
           // no results we can just break and return from here. When there are results
           // we will call the callback with the current chunk of these results here.
           $results = $this->querySelectEvidencias($page, $count);
           $countResults = count($results);

           if ($countResults == 0) {
               break;
           }

           // On each chunk result set, we will pass them to the callback and then let the
           // developer take care of everything within the callback, which allows us to
           // keep the memory low for spinning through large result sets for working.
           if ($callback($results, $page) === false) {
               return false;
           }

           unset($results);

           $page++;
       } while ($countResults == $count);

       return true;
   }

   private function querySelectEvidencias($page,$count): array
   {
    $pages = ($page - 1) * $count;
    $count = $count * $page;
    $evidencias = DB::select('
    select string_agg(criterios.nombre,\'---\') as nombre_criterio, 
    string_agg(estandar.descripcion,\'---\') as descripcion_estandar,
    string_agg(estandar.nombre,\'---\') as descripcion_estandar, 
    string_agg(estandar.tipo,\'---\') as tipo_estandar, 
    string_agg(elemento_fundamental.id,\'---\') as id_elemento,
    string_agg(elemento_fundamental.descripcion,\'---\') as descripcion_elemento, 
    string_agg(componente_elemento_fundamental.id_componente::text ,\'---\') as id_componente, 
    string_agg(componente_elemento_fundamental.descripcion ,\'---\') as descripcion_componente,
    string_agg(evidencias.nombre ,\'---\') as nombre_evidencias, 
    string_agg(carreras_evidencias.cod_evidencia ,\'---\') as cod_evidencias,
	string_agg(carreras_evidencias.fecha_inicial::text ,\'---\') as fecha_inicial,
	string_agg(carreras_evidencias.fecha_final::text ,\'---\') as fecha_final,
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
    limit ? offset ?
    ',[$this->carreraId,$this->periodoId,$count,$pages]);

    return $evidencias;
   }

   public function guardarEvidencia($carreraId,$periodoId,$evidenciaId,$datos){
    try{
        $result = DB::table('carreras_evidencias')
        ->where('id_periodo_academico','=',$periodoId)
        ->where('id_carrera','=',$carreraId)
        ->where('cod_evidencia','=',$evidenciaId)
        ->update($datos);
    }catch(\PDOException $e){
        echo $e->getMessage();
    }

    return $result ? true : false;
   }

   public function obtenerEvidenciaUnica($carreraId,$periodoId,$evidenciaId,) {
    $result = DB::table('carreras_evidencias')
        ->where('id_periodo_academico','=',$periodoId)
        ->where('id_carrera','=',$carreraId)
        ->where('cod_evidencia','=',$evidenciaId)
        ->get();

    return $result;
   }

   public function obtenrDetalleEvidencia($id_criterio,$id_carrera) {
    $evidencias = DB::select('
    select string_agg(criterios.nombre,\'---\') as nombre_criterio, 
    string_agg(estandar.descripcion,\'---\') as descripcion_estandar,
    string_agg(estandar.nombre,\'---\') as descripcion_estandar, 
    string_agg(evidencias.nombre ,\'---\') as nombre_evidencias, 
    string_agg(evidencias.id ,\'---\') as id_evidencias,
    criterios.id as id_criterio
    from evidencias  inner join 
    evidencia_componente_elemento_fundamental 
    on evidencia_componente_elemento_fundamental.id_evidencias = evidencias.id inner join
    componente_elemento_fundamental on 
    componente_elemento_fundamental.id = evidencia_componente_elemento_fundamental.id_componente inner join 
    elemento_fundamental on elemento_fundamental.id = componente_elemento_fundamental.id_elemento inner join 
    estandar on estandar.id = elemento_fundamental.id_estandar inner join criterios 
    on criterios.id = estandar.id_criterio where criterios.id = ?
    GROUP BY criterios.id
    ',[$id_criterio]);
    return $evidencias ? $evidencias[0] : $evidencias;
   }


    /**
     * @param string $periodoId es el id del perio a buscar las evidencias
     * @param string $carreraId es el id de la carrera que se van a buscar las evidencias
     * 
     * @return \Illuminate\Support\Collection coleccion de evidencias
     */
    public function obtenerEvidenciasPorPeriodoYResponsabilidades(
        string $periodoId,
        string $carreraId,
        string $docenteId
        ): \Illuminate\Support\Collection {
        $this->periodoId = $periodoId;
        $this->carreraId = $carreraId;
        $evidenciaVacia = new \stdClass();
        $collectionResult = new \Illuminate\Support\Collection();
        $docenteEvidencia =  DB::table('usuarios_responsabilidad')
        ->join('responsabilidad','responsabilidad.id','=','usuarios_responsabilidad.id_responsabilidad')
        ->where('usuarios_responsabilidad.id_docentes','=',$docenteId)
        ->where('usuarios_responsabilidad.id_carrera','=',$carreraId)
        ->where('usuarios_responsabilidad.id_periodo_academico','=',$periodoId)
        ->select([
            'responsabilidad.id as id_responsabilidad',
            'usuarios_responsabilidad.id_docentes as id_docentes',
            'usuarios_responsabilidad.id_periodo_academico as id_periodo',
            'usuarios_responsabilidad.id_carrera as carrera',
            'responsabilidad.id_evidencias as id_evidencias'
        ])
        ->get();
        foreach($docenteEvidencia as $docente) {
            $evidencia = DB::select('
                select string_agg(criterios.nombre,\'---\') as nombre_criterio, 
                string_agg(estandar.descripcion,\'---\') as descripcion_estandar,
                string_agg(estandar.nombre,\'---\') as descripcion_estandar, 
                string_agg(estandar.tipo,\'---\') as tipo_estandar, 
                string_agg(elemento_fundamental.id,\'---\') as id_elemento,
                string_agg(elemento_fundamental.descripcion,\'---\') as descripcion_elemento, 
                string_agg(componente_elemento_fundamental.id_componente::text ,\'---\') as id_componente, 
                string_agg(componente_elemento_fundamental.descripcion ,\'---\') as descripcion_componente,
                string_agg(evidencias.nombre ,\'---\') as nombre_evidencias, 
                string_agg(carreras_evidencias.cod_evidencia ,\'---\') as cod_evidencias,
                string_agg(carreras_evidencias.fecha_inicial::text ,\'---\') as fecha_inicial,
                string_agg(carreras_evidencias.fecha_final::text ,\'---\') as fecha_final,
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
                and  carreras_evidencias.id_evidencias = ?
                GROUP BY evidencias.id
                ',[$this->carreraId,$this->periodoId,$docente->id_evidencias]);

            $collectionResult->push($evidencia[0] ?? $evidenciaVacia);
        }
        return $collectionResult;
    }


       
}
