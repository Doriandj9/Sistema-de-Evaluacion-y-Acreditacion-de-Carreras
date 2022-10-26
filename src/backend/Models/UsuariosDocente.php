<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;
use Illuminate\Support\Collection;

class UsuariosDocente extends DatabaseTable
{
    public const TABLE = 'usuarios_docente';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id_usuarios');
    }

    /**
     * Actualiza un usuario con un query WHERE y AND
     *
     * @param int $id_usuario
     * @param string $id_docente
     * @param array $datos
     *
     * @return bool
     */
    public function updateUsuario(int $id_usuario, string $id_docente, array $datos): bool
    {

        $result = DB::table(self::TABLE)
        ->where('id_usuarios', '=', $id_usuario)
        ->where('id_docentes', '=', $id_docente)
        ->update($datos);

        return $result ? true : false;
    }
    /**
     * Obtiene todos los coordinadores con sus datos de docente
     *
     * @return \Illuminate\Support\Collection $collection
     */
    public function obtenerCoordinadores(): \Illuminate\Support\Collection
    {
        $coordinadores = DB::table(self::TABLE)
        ->join('docentes', 'docentes.id', '=', self::TABLE . '.id_docentes')
        ->select([
            'id_usuarios',
            'id_docentes',
            self::TABLE . '.id_carrera',
            'fecha_inicial',
            'fecha_final',
            'estado',
            'docentes.nombre as nombre_docente',
            'apellido',
            'correo',
            'carreras.nombre as nombre_carrera'
        ])
        ->join('carreras', 'carreras.id', '=', self::TABLE . '.id_carrera')
        ->where('id_usuarios', '=', Docente::COORDINADORES)
        ->get();

        return $coordinadores;
    }
    /**
     * Obtiene un usuario en particular
     *
     * @param string $column1
     * @param string $column2
     * @param string|int $valor1
     * @param string|int $valor2
     *
     * @return \Illuminate\Support\Collection $usuarios
     */
    public function selectFromColumnsUsuarios(
        string $column1,
        string $column2,
        string|int $valor1,
        string|int $valor2
    ): \Illuminate\Support\Collection {
        $usuarios = DB::table(self::TABLE)
        ->where($column1, '=', $valor1)
        ->where($column2, '=', $valor2)
        ->get();

        return $usuarios;
    }
     /**
     * Obtiene a los usuarios directores del departamento de planeamiento
     * con los datos de un docente
     *
     * @return \Illuminate\Support\Collection $usuarios
     */
    public function selectDirectoresPlaneamiento(): \Illuminate\Support\Collection
    {
        $usuarios = DB::table(self::TABLE)
        ->join('docentes', 'docentes.id', '=', self::TABLE . '.id_docentes')
        ->select(
            'id_usuarios',
            'id_docentes',
            'nombre',
            'apellido',
            'fecha_inicial',
            'fecha_final',
            'estado',
            'correo',
            'telefono'
        )
        ->where('id_usuarios', '=', Docente::DIRECTOR_PLANEAMIENTO)
        ->get();

        return $usuarios;
    }
}
