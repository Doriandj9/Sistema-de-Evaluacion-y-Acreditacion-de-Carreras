<?php

namespace Tests\Unitarios\Modelos;

use App\backend\Models\Carreras;
use Tests\TestCase;

class ModeloCarreraTest extends TestCase {

    private Carreras $modeloCarrera;
    private array $parametros;
    private \stdClass $expected;
    public function __construct()
    {
        parent::__construct();
    }


    protected function setUp(): void
    {
        $this->parametros = [
            [
            'id' => 'PR',
            'nombre' => 'Carrera de Prueba',
            'numero_asig' => 15,
            'total_horas_proyecto' => 180,
            'id_facultad' => '1-AD'
            ],
            [
            'id' => 'PR2',
            'nombre' => 'Carrera de Prueba2',
            'numero_asig' => 10,
            'total_horas_proyecto' => 100,
            'id_facultad' => '1-AD'
            ]            
        ];
        $this->modeloCarrera = new Carreras;
        $this->expected = new \stdClass;
        $this->expected->id_carrera = $this->parametros[0]['id'];
        $this->expected->nombre_carrera = $this->parametros[0]['nombre'];
        $this->expected->id_facultad = $this->parametros[0]['id_facultad'];
        $this->expected->numero_asig = $this->parametros[0]['numero_asig'];
        $this->expected->total_horas_proyecto = $this->parametros[0]['total_horas_proyecto'];
        $this->expected->nombre_facultad = 'Ciencias Administrativas Gestión Empresarial e Informática';

    }
    /**
     * @covers App\backend\Models\Carreras::insert
     */
    public function testInsertarCarreras() {
        $result1 = $this->modeloCarrera->insert($this->parametros[0]);
        $result2 = $this->modeloCarrera->insert($this->parametros[1]);
        $this->assertTrue($result1);
        $this->assertTrue($result2);

        return [$result1,$result2];
    }
    /**
     * @depends testInsertarCarreras
     * @covers App\backend\Models\Carreras::selectWhitFacultad
     */
    public function testObtenerTodasLasCarrerasConLaFacultad() {
        $carreras = $this->modeloCarrera->selectWhitFacultad();
        $this->assertInstanceOf(\Illuminate\Support\Collection::class,$carreras);
        $this->assertCount(10,$carreras);
        return $carreras;
    }
    /**
     * @depends testObtenerTodasLasCarrerasConLaFacultad
     * @covers App\backend\Models\Carreras::selectWhitFacultad
     */
    public function testObtenerCarrerasConLaFacultad() {
        $carreras = $this->modeloCarrera->selectWhitFacultad('id_facultad','1-AD');
        $this->assertInstanceOf(\Illuminate\Support\Collection::class,$carreras);
        $actual = new \stdClass;
        $actual->id_carrera = trim($carreras[3]->id_carrera);
        $actual->nombre_carrera = trim($carreras[3]->nombre_carrera);
        $actual->id_facultad = trim($carreras[3]->id_facultad);
        $actual->numero_asig = trim($carreras[3]->numero_asig);
        $actual->total_horas_proyecto = trim($carreras[3]->total_horas_proyecto);
        $actual->nombre_facultad = trim($carreras[3]->nombre_facultad);
        //$this->assertEquals($this->expected,$actual);
        return $carreras;
    }
    /**
     * @depends testObtenerCarrerasConLaFacultad
     * @covers App\backend\Models\Carreras::selectWhitFacultad
     */
    public function testObtenerCarreraConLaFacultad() {
        $carreras = $this->modeloCarrera->selectWhitFacultad('carreras.id','PR');
        $this->assertInstanceOf(\Illuminate\Support\Collection::class,$carreras);
        $this->assertCount(1,$carreras);
        $actual = new \stdClass;
        $actual->id_carrera = trim($carreras[0]->id_carrera);
        $actual->nombre_carrera = trim($carreras[0]->nombre_carrera);
        $actual->id_facultad = trim($carreras[0]->id_facultad);
        $actual->numero_asig = trim($carreras[0]->numero_asig);
        $actual->total_horas_proyecto = trim($carreras[0]->total_horas_proyecto);
        $actual->nombre_facultad = trim($carreras[0]->nombre_facultad);
        $this->assertEquals($this->expected,$actual);
        return $carreras;
    }
    /**
     * @depends testObtenerCarreraConLaFacultad
     * @covers App\backend\Models\Carreras::deleteRaw
     */
    public function testBorrarCarreras() {
        $result1 = $this->modeloCarrera->deleteRaw($this->parametros[0]['id']);
        $result2 = $this->modeloCarrera->deleteRaw($this->parametros[1]['id']);
        $this->assertTrue($result1);
        $this->assertTrue($result2);
        return[$result1,$result2];
    }
    /**
     * @depends testBorrarCarreras
     * @covers App\backend\Models\Carreras::obtenerHabilitacionPorPeriodoAcademico
     */
    public function testObtenerCarrerasHabilitadasONoPorPeriodoAcademico(){
        $result = $this->modeloCarrera->obtenerHabilitacionPorPeriodoAcademico('2022-2022');
        $this->assertInstanceOf(\Illuminate\Support\Collection::class,$result);
        $this->assertInstanceOf(\stdClass::class,$result[0]);

        return $result;
    }
    /**
     * @depends testObtenerCarrerasHabilitadasONoPorPeriodoAcademico
     * @covers App\backend\Models\Carreras::getDatosDocentes
     */

     public function testObtenerDocentesPorLaCarrera(){
        $result = $this->modeloCarrera->getDatosDocentes('AGRO');
        $this->assertInstanceOf(\Illuminate\Support\Collection::class,$result);
     }
}