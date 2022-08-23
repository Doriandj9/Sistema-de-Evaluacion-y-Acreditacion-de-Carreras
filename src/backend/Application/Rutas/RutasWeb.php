<?php

declare(strict_types=1);

namespace App\backend\Application\Rutas;

use App\backend\Controllers\Web\Login;
use App\backend\Frame\Autentification;
use App\backend\Frame\Route;
use App\backend\Models\Docente;

class RutasWeb implements Route
{
    private $usuarios;
    private $autentification;

    public function __construct()
    {
        $this->usuarios = new Docente;
        $this->autentification = new Autentification('correo', 'clave', $this->usuarios);
    }
    public function getRoutes(): array
    {
        $loginController = new Login($this->autentification);
        return [
            '' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'vista'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'action' => 'verificarInicioSesion'
                ]
                ],
            'salir' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'cerrarSesion'
                ],
            ]
        ];
    }
    public function getTemplate(): string
    {
        return 'layout_principal.html.php';
    }
    public function getRestrict(): array
    {
        return [];
    }
}
