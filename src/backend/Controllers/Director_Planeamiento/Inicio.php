<?php

namespace App\backend\Controllers\Director_Planeamiento;

use App\backend\Controllers\Controller;
use App\backend\Frame\Autentification;
use App\backend\Models\Docente;
use App\backend\Models\Usuarios;

class Inicio implements Controller
{
    private Autentification $autentificacion;
    private Docente $usuarios;

    public function __construct()
    {
        $this->usuarios = new Docente;
        $this->autentificacion = new Autentification('correo','clave',$this->usuarios);
    }

    public function vista($variables = []): array
    {
        $_SESSION['permiso'] = Docente::DIRECTOR_PLANEAMIENTO;
        $usuario = $this->autentificacion->getUsuario();
        $variables['usuario'] = $usuario;
        return [
            'title' => 'Director Planeamiento',
            'template' => 'director_planeamiento/inicio.html.php',
            'variables' => $variables
        ];
    }
}
