<?php

namespace Tests\Unitarios\Modelos;

use App\backend\Models\Evidencias;
use Tests\TestCase;

class EvidenciaTest extends TestCase
{
    private Evidencias $modeloEvidencias;

    public function __construct()
    {
        parent::__construct();
    }

    protected function setUp(): void
    {
        $this->modeloEvidencias = new Evidencias;
    }
    
    /**
     * @covers App\backend\Models\Evidencias::obtenerEvidenciasPorPeriodo
     */
    public function testObtenerTodasEvidenciasPorUnPeriodoAcademico() {
        $evidencias = $this->modeloEvidencias->obtenerEvidenciasPorPeriodo('2022-2022','SOFT');
        $this->assertInstanceOf(\Illuminate\Support\Collection::class,$evidencias);
    }
}