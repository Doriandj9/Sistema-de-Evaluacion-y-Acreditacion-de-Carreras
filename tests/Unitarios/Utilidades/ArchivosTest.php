<?php

namespace Tests\Unitarios\Utilidades;

use App\backend\Application\Utilidades\ArchivosTransformar;
use Tests\TestCase;

class Archivos extends TestCase
{
    private $pathFile;
    public function __construct()
    {
        parent::__construct();
    }

    protected function setUp(): void
    {
        $this->pathFile = './src/backend/datos/archivos/pagina 6 imp.pdf';
    }
    /**
     * @covers App\backend\Application\Utilidades\ArchivosTransformar::base64
     */
    public function testNoExisteElArchivo() {
        $result = ArchivosTransformar::base64('./desconocido.lll');
        $this->assertFalse($result);
    }
    /**
     * @covers App\backend\Application\Utilidades\ArchivosTransformar::base64
     */
    public function testArchivoTransformadoABase64() {
        $result = ArchivosTransformar::base64($this->pathFile);
        $this->assertIsString($result);
    }

}