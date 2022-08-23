<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\Http;

class Docente extends DatabaseTable
{
    public $id;
    public $nombre;
    public $correo;
    public $clave;
    public const DOCENTES = 1;
    public const SECRETARIAS = 2;
    public const COORDINADORES = 4;
    public const EVALUADORES = 8;
    public const ADMIN = 16;

    public function __construct()
    {
        parent::__construct(
            'docentes',
            'id',
            '\App\backend\Models\Docente',
            ['docentes','id']
        );
    }

    public function getUsuario($correo)
    {
        //Es una consulta que permite que saber que usuario quiere ingresar con su permisos
        $consulta = 'SELECT permisos,id_docentes,correo FROM (SELECT permisos,docentes.id as id_docentes,
        docentes.correo as correo FROM docentes INNER JOIN usuarios_docente ON docentes.id =
        usuarios_docente.id_docentes INNER JOIN usuarios ON usuarios_docente.id_usuarios = usuarios.id
        )as uno WHERE  correo = :correo';
        $parametros = [
            'correo' => $correo
        ];

        $this->className = '\stdClass';

        $resultado = $this->runQuery($consulta,$parametros);

        return $resultado->fetchAll(\PDO::FETCH_CLASS, $this->className, []);
    }

    public function tienePermisos($permisos)
    {
        return $this->getUsuario($this->correo)[0]->permisos & $permisos;
    }

    public function getUsuarioCompleto(){
        //Es una consulta que permite que saber que usuario quiere ingresar con su permisos
        $consulta = 'SELECT permisos,id_docentes,correo,carrera FROM (SELECT permisos,docentes.id as id_docentes,
        docentes.correo as correo, carreras.nombre as carrera FROM docentes INNER JOIN usuarios_docente ON docentes.id =
        usuarios_docente.id_docentes INNER JOIN usuarios ON usuarios_docente.id_usuarios = usuarios.id 
        INNER JOIN carreras on carreras.id = usuarios_docente.id_carrera)as uno WHERE  correo = :correo';
        $parametros = [
            'correo' => $this->correo
        ];

        $this->className = '\stdClass';

        $resultado = $this->runQuery($consulta,$parametros);

        return $resultado->fetchAll(\PDO::FETCH_CLASS, $this->className, []);
    }
}
