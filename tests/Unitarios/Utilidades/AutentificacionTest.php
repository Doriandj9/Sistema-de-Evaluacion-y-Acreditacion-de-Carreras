<?php

declare(strict_types=1);

namespace Tests\Utilidades;

use App\backend\Frame\Autentification;
use App\backend\Models\Docente;
use Tests\TestCase;

class AutentificacionTest extends TestCase
{
    private Autentification $autentificacion;

    public function __construct()
    {
        parent::__construct();
    }

    protected function setUp(): void
    {
        $this->autentificacion = new Autentification('correo', 'clave', new Docente);
    }
    /**
     * @covers App\backend\Frame\Autentification::verificacionCredenciales
     */
    public function testUsuarioInvalido()
    {
        $resultado = $this->autentificacion->verificacionCredenciales(
            'darmijos@gmail.com',
            '12345'
        );

        $this->assertFalse($resultado);
    }
}
