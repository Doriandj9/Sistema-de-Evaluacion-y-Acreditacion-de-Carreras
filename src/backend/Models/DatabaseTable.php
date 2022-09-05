<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Models\ConeccionDB\Coneccion;
use phpDocumentor\Reflection\PseudoTypes\False_;

/**
 * Esta clase abstracta tiene todos los metodos base
 * para consultar,insertar,actualizar y eliminar
 * para todo modelo que herede de esta clase
 *
 * @author Dorian Armijos
 * @link <https://github.com/Doriandj9>
 */
abstract class DatabaseTable extends Coneccion
{
    protected $table;
    private $primaryKey;
    protected $className;
    protected $arguments;

    public function __construct(
        string $table,
        string $primaryKey,
        string $className = '\stdClass',
        array $arguments = []
    ) {
        parent::__construct();
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->className = $className;
        $this->arguments = $arguments;
    }
    /**
     * Esta funcion protegida quiere decir que
     * solo va ha estar presente para clases que hereden
     * de esta clase, se encarga de ejecutar cualquier
     * peticion y regresar el resultado de la misma
     *
     * @param string es la consulta en SQL
     * @param array son los argumentos los valores que se
     * insertara en la consulta
     *
     * @return \PDOStatement
     */
    protected function runQuery($consulta, $parametros = []): \PDOStatement
    {
        $resultado = $this->prepare($consulta);
        $resultado->execute($parametros);
        return $resultado;
    }
    /**
     * Esta funcion realiza la consulta en SQL para insertar datos
     * @param array son los parametros a ingresar
     *
     * @return bool
     */
    public function insert(array $parametros): bool
    {
        $consulta = 'INSERT INTO ' . $this->table . '(';

        foreach ($parametros as $indicador => $valor) {
            $consulta .= $indicador . ',';
        }

        $consulta = rtrim($consulta, ',');
        $consulta .= ') VALUES (';

        foreach ($parametros as $indicador => $valor) {
            $consulta .= ':' . $indicador . ',';
        }

        $consulta = rtrim($consulta, ',');
        $consulta .= ')';

        try {
            $this->runQuery($consulta, $parametros);
            return true;
        } catch (\PDOException $e) {
            $er = $e->getMessage();
            throw new \PDOException($er);
            return false;
        }
    }
    /**
     * esta funcion obtiene todos los datos de esa tabla
     *
     * @return array|false
     */
    public function select(bool $orden = false, string $columna = null): array|false
    {
        $consulta = 'SELECT * FROM ' . $this->table;
        if($orden && $columna !== null){
            $consulta .= 'ORDER BY ' . $columna;
        }
        $resultado = $this->runQuery($consulta);
        return $resultado->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->arguments);
    }
    /**
     * Lo mismo que select solo que por columnas
     * @param string es la comulna por la cual se buscara
     * @param string|int es el valor que buscara en la columna
     *
     * @return array|false
     */
    public function selectFromColumn(string $column, string|int $valor): array|false
    {
        $consulta = 'SELECT * FROM ' . $this->table . ' WHERE ' . $column . ' = :' . $column;
        $parametros = [':' . $column => $valor];
        $resultado = $this->runQuery($consulta, $parametros);
        return $resultado->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->arguments);
    }
    /**
     * Esta funcion actualiza los datos de esa tabla
     *
     * @param string|int es la clave primaria que va acutalizar
     * @param array son los parametros actualizar
     * @return bool
     */
    public function update(string|int $primaryKey, array $parametros): bool
    {
        unset($parametros[$this->primaryKey]);
        $consulta = 'UPDATE ' . $this->table . ' SET ';

        foreach ($parametros as $indicador => $valor) {
            $consulta .= $indicador . ' = :' . $indicador . ',';
        }

        $consulta = rtrim($consulta, ',');
        $consulta .= ' WHERE ' . $this->primaryKey . ' = :' . $this->primaryKey;
        $parametros[$this->primaryKey] = $primaryKey;

        try {
            $this->runQuery($consulta, $parametros);
            return true;
        } catch (\PDOException $e) {
            $er = $e->getMessage();
            throw new \PDOException($er);
            return false;
        }
    }
    /**
     * Esta funcion elimana un dato
     *
     * @param string|int es el primarykey de ese dato
     *
     * @return bool
     */
    public function delete(string|int $primaryKey): bool
    {
        $consulta = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = :' . $this->primaryKey;
        $parametros = [ $this->primaryKey => $primaryKey ];
        try {
            $this->runQuery($consulta, $parametros);
            return true;
        } catch (\PDOException $e) {
            $er = $e->getMessage();
            throw new \PDOException($er);
            return false;
        }
    }
}
