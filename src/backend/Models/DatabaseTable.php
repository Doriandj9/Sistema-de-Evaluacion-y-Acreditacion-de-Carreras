<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Esta clase abstracta tiene todos los metodos base
 * para consultar,insertar,actualizar y eliminar que
 * usa el DB propio de Eloquent ORM
 * para todo modelo que herede de esta clase
 *
 * @author Dorian Armijos
 * @link <https://github.com/Doriandj9>
 */
abstract class DatabaseTable extends Model
{
    protected $table;
    private $primaryKeyTable;
    public function __construct(string $table, string $primaryKey)
    {
        parent::__construct();
        $this->table = $table;
        $this->primaryKeyTable = $primaryKey;
    }
    /**
     * Esta funcion realiza la consulta en SQL para insertar datos
     *
     * @param array $parametros son los parametros a ingresar
     *
     * @return bool
     */
    public function insert(array $parametros): bool
    {
        $resultado = DB::table($this->table)
        ->insert($parametros);

        return$resultado;
    }
    /**
     * esta funcion obtiene todos los datos de esa tabla
     *
     * @param bool $orden determina si la busqueda se le aplique la clausula ORDER BY
     * @param string $columna es la columna por la cual se va a ordenar la busqueda
     * @param string $forma es si es ASC o DESC acendente o desendente
     * @param array $columnas son las columnas que deseen que retorne
     *
     * @return \Illuminate\Support\Collection
     */
    public function select(
        bool $orden = false,
        string $columna = null,
        string $forma = 'asc',
        array $columnas = ['*']
    ): \Illuminate\Support\Collection {
        $resultado = DB::table($this->table)
        ->select();
        if ($orden && $columna !== null) {
            $resultado = $resultado
            ->orderBy($columna, $forma);
        }

        return $resultado->get($columnas);
    }
    /**
     * Lo mismo que select solo que por columnas
     *
     * @param string $columna es la comulna por la cual se buscara
     * @param string|int $valor es el valor que buscara en la columna
     * @param array $columnas son las columnas que deseen que retorne
     *
     * @return \Illuminate\Support\Collection
     */
    public function selectFromColumn(
        string $columna,
        string|int $valor,
        array $columnas = ['*']
    ): \Illuminate\Support\Collection {
        $resultado = DB::table($this->table)
        ->select()
        ->where($columna, '=', $valor)
        ->get($columnas);
        return $resultado;
    }
    /**
     * Esta funcion actualiza los datos de esa tabla
     *
     * @param string|int $primariKey la clave primaria
     * @param array $parametros son los parametros actualizar
     *
     * @return bool
     */
    public function updateValues(string|int $primaryKey, array $parametros): bool
    {
        $resultado = DB::table($this->table)
        ->where($this->primaryKeyTable, '=', $primaryKey)
        ->update($parametros);// el metodo update regresa 1 o 0 que corresponde a true o false
        if ($resultado) {// Si es 1 verdadero regrese true caso contrario false
            return true;
        } else {
            return false;
        }
    }
    /**
     * Esta funcion elimana un dato
     *
     * @param string|int $primariKey es el primarykey de ese dato
     *
     * @return bool
     */
    public function deleteRaw(string|int $primaryKey): bool
    {
        $resultado = DB::table($this->table)
        ->where($this->primaryKeyTable, '=', $primaryKey)
        ->delete($primaryKey); // el metodo update regresa 1 o 0 que corresponde a true o false

        if ($resultado) { // Si es 1 verdadero regrese true caso contrario false
            return true;
        } else {
            return false;
        }
    }
}
