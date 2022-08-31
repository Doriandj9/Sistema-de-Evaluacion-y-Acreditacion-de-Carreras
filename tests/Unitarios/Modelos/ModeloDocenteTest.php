<?php

declare(strict_types=1);

namespace Tests\Unitarios\Modelos;

use App\backend\Models\Docente;
use Tests\TestCase;

class ModeloDocenteTest extends TestCase
{
    private $argumentos;
    private $modelDocente;

    public function __construct()
    {
        parent::__construct();
    }

    protected function setUp(): void
    {
        $this->argumentos = [
            'id' => '0123456789',
            'nombre' => 'Docente de Prueba',
            'correo' => 'prueba@gmail.com',
            'clave' => '1234'
        ];
        $this->modelDocente = new Docente;
    }
    /**
     * @covers App\backend\Models\Docente::insert
     */
    public function testInsertarDocente()
    {
        $result = $this->modelDocente->insert($this->argumentos);
        $this->assertTrue($result);
        return $result;
    }
    /**
     * @depends testInsertarDocente
     * @covers App\backend\Models\Docente::select
     */
    public function testSelecionDocentes()
    {
        $result = $this->modelDocente->select();
        $this->assertIsArray($result);
        $this->assertIsObject($result[0]);
        return $result;
    }
    /**
     * @depends testSelecionDocentes
     * @covers App\backend\Models\Docente::selectFromColumn
     */
    public function testSelecionDocentesPorColumna()
    {
        $result = $this->modelDocente->selectFromColumn('id', $this->argumentos['id']);
        $actual = [
            'id' => $result[0]->id,
            'nombre' => $result[0]->nombre,
            'correo' => $result[0]->correo,
            'clave' => trim($result[0]->clave)
        ];
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Docente::class, $result[0]);
        $this->assertEquals($this->argumentos, $actual);
    }
    /**
     * @depends testSelecionDocentesPorColumna
     * @covers App\backend\Models\Docente::update
     */
    public function testActualizarDocente()
    {
        $result = $this->modelDocente->update($this->argumentos['id'], $this->argumentos);
        $this->assertTrue($result);
        return $result;
    }
    /**
     * @depends testActualizarDocente
     * @covers App\backend\Models\Docente::delete
     */
    public function testBorarDocente()
    {
        $result = $this->modelDocente->delete($this->argumentos['id']);
        $this->assertTrue($result);
    }
}
