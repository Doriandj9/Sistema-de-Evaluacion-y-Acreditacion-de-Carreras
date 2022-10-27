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
            'Coordinador de la Carrera de Software',
            'Usted ha sido notificado para utilizar
            el sistema SEAC que tiene apertura en la carrera de Software en la fecha  
            inicial 26/10/2022 hasta el 10/03/2023.<br>
            El usuario para el ingreso es su correo institucional y su controseña provicional
            es el numero de su cédula, se le recomienda cambiar la clave para una mayor seguridad.<br>',
            true,
            'http://localhost/'
        );
        $this->assertIsString($html);
       return $html;
    }
    /**
     * @depends testHtmlRenderEmail
     * @covers App\backend\Application\Servicios\Email\EnviarEmail::enviar
     */
    public function testEnviarCorreoElectronico($cuerpo) {
        $result = EnviarEmail::enviar(
            'Dorian Armijos',
            'dorian9armijos@gmail.com',
            'darmijos@mailes.ueb.edu.ec',
            'Habilitado para usar la plataforma SEAC',
            $cuerpo
        );

        $this->assertTrue(boolval($result->ident));
    }
}
