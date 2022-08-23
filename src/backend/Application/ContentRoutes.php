<?php

declare(strict_types=1);

namespace App\backend\Application;

use App\backend\Application\Rutas\RutasAdministrador;
use App\backend\Application\Rutas\RutasCoordinador;
use App\backend\Application\Rutas\RutasDatos;
use App\backend\Application\Rutas\RutasDocente;
use App\backend\Application\Rutas\RutasEvaluador;
use App\backend\Application\Rutas\RutasWeb;
use App\backend\Frame\Autentification;
use App\backend\Frame\Route;
use App\backend\Models\Docente;

/**
 * Esta clase contiene todas las rutas padres
 * que hacen referencia a todas las rutas existentes
 * del sistema
 *
 * @author Dorian Armijos
 * @link <>
 * @author Nataly Fernandez
 * @link <>
 */
class ContentRoutes
{
    private $usuarios;
    private $autentificacion;

    public function __construct()
    {
        $this->usuarios = new Docente;
        $this->autentificacion = new Autentification('correo', 'clave', $this->usuarios);
    }

    public function getAllRoutes(): array
    {
        return $this->routes();
    }

    public function getRoutes(string $route): Route|bool
    {
        return $this->routes()[$route] ?? false;
    }

    private function routes(): array
    {
        return [
            '' => new RutasWeb,
            'docente' => new RutasDocente,
            'evaluador' => new RutasEvaluador,
            'coordinador' => new RutasCoordinador,
            'admin' => new RutasAdministrador,
            'datos' => new RutasDatos
        ];
    }

    public function getAutentificacion(): Autentification
    {
        return $this->autentificacion;
    }
}
