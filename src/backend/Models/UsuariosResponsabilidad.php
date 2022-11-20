<?php

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;
use Illuminate\Database\Eloquent\Collection;

class UsuariosResponsabilidad extends DatabaseTable
{
    public const TABLE = 'usuarios_responsabilidad';

    public function __construct()
    {
        parent::__construct(self::TABLE,'id_usuarios');
    }

    public function obtenerResponsables($id_carrera,$periodo) {
        $responsables = DB::select('select
                string_agg(usuarios_responsabilidad.id_carrera,\'---\') as id_carrera,
                string_agg(responsabilidad.id::text,\'---\') as id_responsabilidad, 
                string_agg(responsabilidad.nombre,\'---\') as nombre_responsabilidad, 
                string_agg(docentes.nombre,\'---\') as nombre_docente, 
                string_agg(docentes.apellido ,\'---\')as apellido, 
                string_agg(docentes.correo ,\'---\') as correo, 
                string_agg(evidencias.nombre ,\'---\') as nombre_evidencia,
                docentes.id as id_docente
                from usuarios_responsabilidad inner join responsabilidad on
                responsabilidad.id = usuarios_responsabilidad.id_responsabilidad inner join 
                evidencias on evidencias.id = responsabilidad.id_evidencias inner join 
                docentes on docentes.id = usuarios_responsabilidad.id_docentes
                where id_carrera = ? and
                id_periodo_academico = ?
                GROUP BY docentes.id'
        ,[$id_carrera, $periodo]);
        $collection = new Collection($responsables);
        return $collection;
    }
}