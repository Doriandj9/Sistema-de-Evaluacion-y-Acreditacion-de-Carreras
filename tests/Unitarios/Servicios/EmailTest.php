<?php

namespace Tests\Unitarios\Servicios;

use App\backend\Application\Servicios\Email\EnviarEmail;
use Tests\TestCase;

class EmailTest extends TestCase {
    /**
     * @covers App\backend\Application\Servicios\Email\EnviarEmail::enviar
     */
    public function testEnviarCorreoElectronico() {
        $result = EnviarEmail::enviar(
            'Docente',
            'dorian9armijos@gmail.com',
            'darmijos@mailes.ueb.edu.ec',
            'Habilitado para usar la plataforma SEAC',
            '<h2>Prueba correcta</h2>'
        );

        $this->assertTrue(boolval($result->ident));
    }
}