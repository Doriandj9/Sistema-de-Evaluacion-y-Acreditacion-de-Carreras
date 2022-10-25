<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class Carreras extends DatabaseTable
{
    private Facultad $facultad;
    public const TABLE = 'carreras';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id');
        $this->facultad = new Facultad;
    }

    public function getDatosDocentes(string $idCarrera): \Illuminate\Support\Collection|bool
    {
        $carrera = DB::table(self::TABLE)
        ->find(trim($idCarrera));
        if ($carrera) {
            $docentes_carreras = DB::table(self::TABLE)
            ->join('docentes_carreras', 'carreras.id', '=', 'docentes_carreras.id_carreras')
            ->join('docentes', 'docentes.id', '=', 'docentes_carreras.id_docentes')
            ->where('carreras.id','=',$idCarrera)
            ->get();
            return $docentes_carreras;
        } else {
            return false;
        }
    }

    public function selectWhitFacultad($action = null, $valor = null) {

        if($action && $valor) {
            $result = DB::table(self::TABLE)
            ->join('facultad','carreras.id_facultad','=','facultad.id')
            ->where($action,'=',$valor)
        ->get([
            'carreras.id as id_carrera',
            'carreras.nombre as nombre_carrera',
            'id_facultad',
            'numero_asig',
            'total_horas_proyecto',
            'facultad.nombre as nombre_facultad'
        ]);
            
            return $result;
        }
        $result = DB::table(self::TABLE)
            ->join('facultad','carreras.id_facultad','=','facultad.id')
            ->orderBy('carreras.id')
            ->get([
            'carreras.id as id_carrera',
            'carreras.nombre as nombre_carrera',
            'id_facultad',
            'numero_asig',
            'total_horas_proyecto',
            'facultad.nombre as nombre_facultad'
        ]);
        return $result;
    }

    public function obtenerHabilitacionPorPeriodoAcademico($periodo): \Illuminate\Support\Collection
    {
        $carrerasPeriodoAcademico = DB::table('carreras_periodo_academico')
        ->select()
        ->where('id_periodo_academico','=',$periodo)
        ->get();
        $carreras = $this->select();
        $memory = [];
        foreach($carrerasPeriodoAcademico as $carrera) {
            $memory[trim($carrera->id_carreras)] = 'activo';
        }

        foreach($carreras as $key => $carrier){
            if(array_key_exists(trim($carrier->id),$memory)){
                $carreras[$key]->opcion = $memory[trim($carrier->id)];
                $carreras[$key]->periodo = trim($periodo);
            }else {
                $carreras[$key]->opcion = 'inactivo';
                $carreras[$key]->periodo = '';
            }
        }

        return $carreras;
    }
}
