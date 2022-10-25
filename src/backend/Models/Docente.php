<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;

class Docente extends DatabaseTable
{
    public const TABLE = 'docentes';
    public const DOCENTES = 1;
    public const DIRECTOR_PLANEAMIENTO = 2;
    public const COORDINADORES = 4;
    public const EVALUADORES = 8;
    public const ADMIN = 16;

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id');
    }

    public static function getUsuario($correo)
    {
        //Es una consulta que permite que saber que usuario quiere ingresar con su permisos
        $resultado = DB::table(self::TABLE)
        ->join('usuarios_docente', 'docentes.id', '=', 'usuarios_docente.id_docentes')
        ->join('usuarios', 'usuarios.id', '=', 'usuarios_docente.id_usuarios')
        ->get(['permisos','correo'])
        ->where('correo', '=', trim($correo))
        ->first();
        return $resultado;
    }

    public static function tienePermisos($permisos): bool // retorna 0 o 1 que se trata como verdadero o falso
    {
        $usuario = DB::table(self::TABLE)
        ->join('usuarios_docente', 'docentes.id', '=', 'usuarios_docente.id_docentes')
        ->join('usuarios', 'usuarios.id', '=', 'usuarios_docente.id_usuarios')
        ->get(['permisos','correo'])
        ->where('correo', '=', trim($_SESSION['email']))
        ->where('permisos', '=', $permisos)
        ->first();
        if (isset($_SESSION['permiso'])) {
            return $permisos !== intval($_SESSION['permiso']) ? false : true;
        }
        return $usuario ?  true : false;
    }

    public static function getUsuarioCompleto(): \Illuminate\Support\Collection
    {
        //Es una consulta que permite que saber que usuario quiere ingresar con su permisos
        $resultado = DB::table(self::TABLE)
        ->join('usuarios_docente', 'docentes.id', '=', 'usuarios_docente.id_docentes')
        ->join('usuarios', 'usuarios_docente.id_usuarios', '=', 'usuarios.id')
        ->join('carreras', 'carreras.id', '=', 'usuarios_docente.id_carrera')
        ->get();
        return $resultado;
    }

    public function getTodosPermisos($id):\Illuminate\Support\Collection
    {
        $resultado = DB::table(self::TABLE)
        ->join('usuarios_docente', 'docentes.id', '=', 'usuarios_docente.id_docentes')
        ->join('usuarios', 'usuarios_docente.id_usuarios', '=', 'usuarios.id')
        ->get(['permisos','id_docentes'])
        ->where('id_docentes', '=', $id);
        return $resultado;
    }

    public function getCarrerasPorPermisos($id_usuarios, $id_docente)
    {
        $resultado = DB::table(Carreras::TABLE)
        ->join(UsuariosDocente::TABLE, UsuariosDocente::TABLE . '.id_carrera', '=', Carreras::TABLE . '.id')
        ->where('id_usuarios', '=', $id_usuarios)
        ->where('id_docentes', '=', $id_docente)
        ->get(['id_docentes','id_carrera','nombre']); // nombre se refiere al nombre de la carrera

        return $resultado;
    }
}
