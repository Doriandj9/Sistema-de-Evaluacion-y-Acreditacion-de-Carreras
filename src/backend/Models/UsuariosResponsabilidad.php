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
        $responsables = DB::select(
         'select
        string_agg(docentes.apellido,\'---\') as apellido,
        string_agg(docentes.correo,\'---\') as correo,
        string_agg(criterios.nombre,\'---\') as nombre_criterio,
        string_agg(docentes.id,\'---\') as id_docente, 
        string_agg(criterios.id,\'---\') as id_criterio,
        docentes.nombre as nombre_docente
        from usuarios_responsabilidad
        inner join responsabilidad  on responsabilidad.id = usuarios_responsabilidad.id_responsabilidad
        inner join criterios on criterios.id = responsabilidad.id_criterio
        inner join docentes on docentes.id = usuarios_responsabilidad.id_docentes
        where usuarios_responsabilidad.id_carrera = ? and
        usuarios_responsabilidad.id_periodo_academico = ?
        GROUP BY docentes.nombre',
    [$id_carrera,$periodo]);
        $collection = new Collection($responsables);
        return $collection;
    }
}