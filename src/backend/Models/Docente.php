<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;

class Docente extends DatabaseTable
{
    public const TABLE = 'docentes';
    public const DOCENTES = 1;
    public const SECRETARIAS = 2;
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

    public static function tienePermisos($permisos): int // retorna 0 o 1 que se trata como verdadero o falso
    {
        return Docente::getUsuario($_SESSION['email'])->permisos & $permisos; // busqueda bit a bit
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
}
