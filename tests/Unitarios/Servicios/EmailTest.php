<?php

namespace Tests\Unitarios\Servicios;

use App\backend\Application\Servicios\Email\EnviarEmail;
use Tests\TestCase;

class EmailTest extends TestCase
{
    /**
     * @covers App\backend\Application\Servicios\Email\EnviarEmail::html
     */
    public function testHtmlRenderEmail()
    {
        $html = EnviarEmail::html(
            null,
            'Test',
            'Este es un correo de prueba'
        );
        $this->assertIsString($html);
        return $html;
    }
    /**
     * @depends testHtmlRenderEmail
     * @covers App\backend\Application\Servicios\Email\EnviarEmail::enviar
     */
    public function testEnviarCorreoElectronico($cuerpo)
    {
        $result = EnviarEmail::enviar(
            'Correo de Prueba',
            'dorian9armijos@gmail.com',
            'darmijos@mailes.ueb.edu.ec',
            'Notificado',
            $cuerpo
        );

        $this->assertTrue(boolval($result->ident));
    }
}
