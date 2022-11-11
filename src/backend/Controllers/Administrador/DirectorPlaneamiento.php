<?php

namespace App\backend\Controllers\Administrador;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Docente;
use App\backend\Models\DocentesCarreras;
use App\backend\Models\UsuariosDocente;

class DirectorPlaneamiento implements Controller
{
    private Docente $docentes;
    private DocentesCarreras $docentesCarrera;
    private UsuariosDocente $usuariosDocentes;

    public function __construct()
    {
        $this->docentes = new Docente;
        $this->docentesCarrera = new DocentesCarreras;
        $this->usuariosDocentes = new UsuariosDocente;
    }
    public function vista($variables = []): array
    {
        return [
            'title' => 'Director de Planeamiento',
            'template' => 'administrador/director-planeamiento.html.php'
        ];
    }

    public function insertarDirector()
    {
        $data_insert_docente = [
            'id' => trim($_POST['cedula']),
            'nombre' => trim($_POST['nombre']),
            'apellido' => trim($_POST['apellido']),
            'correo' => trim($_POST['correo']),
            'clave' => password_hash(trim($_POST['cedula']), PASSWORD_DEFAULT),
            'telefono' => trim($_POST['telefono']),
            'cambio_clave' => true
        ];
        $data_insert_docente_carrera = [
            'id_carreras' => 'TICS',
            'id_docentes' => trim($_POST['cedula'])
        ];
        $data_insert_director = [
            'id_usuarios' => Docente::DIRECTOR_PLANEAMIENTO,
            'id_docentes' => trim($_POST['cedula']),
            'id_carrera' => 'TICS',
            'fecha_inicial' => trim($_POST['f_inicial']),
            'fecha_final' => trim($_POST['f_final']),
            'estado' => 'activo'
        ];
        try {
            $docente = $this->docentes->selectFromColumn('id', $data_insert_docente['id'])->first();
            if (!$docente) {
                $this->docentes->insert($data_insert_docente);
            }
            $docenteCarrera = $this->docentesCarrera->selectFromColumn('id_carreras', $_ENV['DEFAULTCARRERA']);
            if (count($docenteCarrera) >= 1) {
                $insertar = true;
                foreach ($docenteCarrera as $dcarrera) {
                    if (trim($dcarrera->id_docentes) === $data_insert_docente_carrera['id_docentes']) {
                        $insertar = false;
                        continue;
                    }
                }

                if ($insertar) {
                    $this->docentesCarrera->insert($data_insert_docente_carrera);
                }
            }

            // comprobamos que el usuario no ocupe otro rol en el sistema
            $usuarioSinRoles = UsuariosDocente::whereRaw('id_usuarios != ? and id_docentes = ?',
            [Docente::DIRECTOR_PLANEAMIENTO,'0250186665']
            )->get();
            if(count($usuarioSinRoles) >= 1) {
                throw new \PDOException('Error el usuario desempeña otro cargo');
            }


            $usuarioDocente = $this->usuariosDocentes->selectFromColumnsUsuarios(
                'id_usuarios',
                'id_docentes',
                Docente::DIRECTOR_PLANEAMIENTO,
                $data_insert_director['id_docentes']// busca por id del docente
            )->first();
            if (!$usuarioDocente) {
                $this->usuariosDocentes->insert($data_insert_director);
            } else {
                Http::responseJson(json_encode(
                    [
                        'ident' => 1,
                        'mensaje' => 'El usuario ateriormente ya fue director, por favor actualize(edite) las fechas del cargo'
                    ]
                ));
            }

            Http::responseJson(json_encode(
                [
                    'ident' => 1,
                    'mensaje' => 'Se ingreso correctamente el usuario'
                ]
            ));
        } catch (\PDOException $e) {
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => $e->getMessage()
                ]
            ));
        }
    }

    public function editarDirector()
    {
        $data_edit_docente = [
            'nombre' => trim($_POST['nombre']),
            'apellido' => trim($_POST['apellido']),
            'correo' => trim($_POST['correo']),
            'telefono' => trim($_POST['telefono']),
        ];
        $data_edit_director = [
            'fecha_inicial' => trim($_POST['f_inicial']),
            'fecha_final' => trim($_POST['f_final']),
        ];
        try {
            $this->docentes->updateValues(trim($_POST['id']), $data_edit_docente);
            $this->usuariosDocentes->updateUsuario(
                Docente::DIRECTOR_PLANEAMIENTO,
                trim($_POST['id']),
                $data_edit_director
            );

            Http::responseJson(json_encode(
                [
                    'ident' => 1,
                    'mensaje' => 'Se actualizo correctamente el usuario'
                ]
            ));
        } catch (\PDOException $e) {
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => $e->getMessage()
                ]
            ));
        }
    }
}
