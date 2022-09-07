<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\Http;
use Illuminate\Database\Eloquent\Model;
use App\backend\Application\Utilidades\DB;
class Docente extends Model
{
    
    public const DOCENTES = 1;
    public const SECRETARIAS = 2;
    public const COORDINADORES = 4;
    public const EVALUADORES = 8;
    public const ADMIN = 16;


    public static function getUsuario($correo)
    {
        //Es una consulta que permite que saber que usuario quiere ingresar con su permisos
        $resultado = DB::table('docentes')
        ->join('usuarios_docente','docentes.id','=','usuarios_docente.id_docentes')
        ->join('usuarios','usuarios.id','=','usuarios_docente.id_usuarios')
        ->get(['permisos','correo'])
        ->where('correo','=',trim($correo))
        ->first();
        return $resultado;
    }

    public static function tienePermisos($permisos)
    {
        return Docente::getUsuario($_SESSION['email'])->permisos & $permisos;
    }

    public static function getUsuarioCompleto()
    {
        //Es una consulta que permite que saber que usuario quiere ingresar con su permisos
        // $consulta = 'SELECT permisos,id_docentes,correo,carrera,estado FROM (SELECT permisos,docentes.id as id_docentes,estado,
        // docentes.correo as correo, carreras.nombre as carrera FROM docentes INNER JOIN usuarios_docente ON docentes.id =
        // usuarios_docente.id_docentes INNER JOIN usuarios ON usuarios_docente.id_usuarios = usuarios.id 
        // INNER JOIN carreras on carreras.id = usuarios_docente.id_carrera)as uno WHERE  correo = :correo';
        // $parametros = [
        //     'correo' => $this->correo
        // ];

        $resultado = DB::table('docentes')
        ->join('usuarios_docente','docentes.id','=','usuarios_docente.id_docentes')
        ->join('usuarios','usuarios_docente.id_usuarios','=','usuarios.id')
        ->join('carreras','carreras.id','=','usuarios_docente.id_carrera')
        ->get();
        return $resultado;
    }
}
