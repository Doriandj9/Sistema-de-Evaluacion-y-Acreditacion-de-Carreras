<?php

namespace Tests\Unitarios\Modelos;

use App\backend\Models\Docente;
use App\backend\Models\UsuariosDocente;
use Tests\TestCase;

class UsuariosDocentesTest extends TestCase
{
    private UsuariosDocente $usuariosDocentes;
    private array $datosActualizar;
    public function __construct()
    {
        parent::__construct();
    }

    protected function setUp(): void
    {
        $this->usuariosDocentes = new UsuariosDocente;
        $this->datosActualizar = [
            'fecha_inicial' => '2022-10-03',
            'fecha_final' => '2052-10-03',
            'estado' => 'activo'
        ];
    }
    /**
     * @covers \App\backend\Models\UsuariosDocente::updateUsuario
     */
    public function testActualizarFechasDeUnCoordinador()
    {
        $id_usuario = Docente::COORDINADORES;
        $id_docente = '0250186664';
        $result = $this->usuariosDocentes->updateUsuario($id_usuario, $id_docente, $this->datosActualizar);

        $this->assertTrue($result);
    }
    /**
     * @covers \App\backend\Models\UsuariosDocente::obtenerCoordinadores
     */
    public function testObtenerUsuriosCoordinadores()
    {
        $coordinadores = $this->usuariosDocentes->obtenerCoordinadores();
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $coordinadores);
    }
}
