<?php

declare(strict_types=1);

namespace App\backend\Models\ConeccionDB;

/**
 * Esta clase conecta de forma directa con la API
 * PDO y por consiguiente se puede usar para realizar
 * consultas a la base de datos
 *
 * @author Dorian Armijos
 * @link <https://github.com/Doriandj9>
 */
class Coneccion extends \PDO
{
    private string $HOST;
    private string $DBNAME;
    private string $DBUSER;
    private string $PASSDATABASE;

    public function __construct()
    {
        $this->HOST = $_ENV['HOST'];
        $this->DBNAME = $_ENV['DBNAME'];
        $this->DBUSER = $_ENV['DBUSER'];
        $this->PASSDATABASE = $_ENV['PASSDATABASE'];

        try {
            parent::__construct(
                'pgsql:host=' . $this->HOST . ';port=5432;dbname=' . $this->DBNAME,
                $this->DBUSER,
                $this->PASSDATABASE
            );
            $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $error = $e->getMessage() . ' in ' . $e->getFile() . ' : ' . $e->getLine();
            throw new \PDOException($error);
        }
    }
}
