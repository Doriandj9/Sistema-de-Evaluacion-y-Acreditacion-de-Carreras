<?php

namespace Tests\Unitarios\Modelos;

use App\backend\Models\UsuariosResponsabilidad;
use Tests\TestCase;

class UsuariosResponsabilidadTest extends TestCase
{   
    private UsuariosResponsabilidad $resposablesModel;
    public function __construct()
    {
        parent::__construct();
    }

    protected function setUp(): void
    {
        $this->resposablesModel = new UsuariosResponsabilidad;
    }
    /**
     * @covers \App\backend\Models\UsuariosResponsabilidad::obtenerResponsables
     */
    public function testObtenerResponsablesDeCarrera() {
        $resposables = $this->resposablesModel->obtenerResponsables('SOFT','2022-2022');
        $this->assertIsNumeric($resposables->count());
    }   
}