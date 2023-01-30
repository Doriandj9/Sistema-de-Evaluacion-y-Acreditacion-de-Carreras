<div class="centrado-linea">
<div class="altura-1 padding-all-1 p-relativo">
<table class="table table-striped-columns w-100 sombra" id="presentacion">
                <thead>
                    <tr class="titulo-tablas">
                        <th class="bg-secondary text-white" colspan="7">
                            <div class="d-flex align-items-center">
                            <span class="material-icons text-white">&#xe241;</span>
                            <strong>Lista de Directores del Departamento de Planeamiento</strong>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white text-center"
class="bg-primary text-white text-center">Cédula</th>
                        <th class="bg-primary text-white text-center"
class="bg-primary text-white text-center">Director</th>
<th class="bg-primary text-white text-center"
class="bg-primary text-white text-center">Correo</th>
                        <th class="bg-primary text-white text-center"
class="bg-primary text-white text-center">Incio de Cargo</th>
                        <th class="bg-primary text-white text-center"
class="bg-primary text-white text-center">Finalización de Cargo</th>
                        <th class="bg-primary text-white text-center"
class="bg-primary text-white text-center"> Estado </th>
<th class="bg-primary text-white text-center"
class="bg-primary text-white text-center"> Opción </th>
                    </tr>
                </thead>
                <tbody>
                   <tr>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>

                   </tr>
                   <tr>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>

                   </tr>
                   <tr>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>

                   </tr>
                   <tr>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>

                   </tr>
                   <tr>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>

                   </tr>
                   
                </tbody>
            </table>
            <div class="d-flex justify-content-center contenedor-numeros-paginacion"></div>
</div>
<div class="desborde-auto barra-personalizada padding-all-1">
    <form id="form-director">
    <table class="table table-striped-columns w-100 sombra m-0">
            <thead>
                <tr class="titulo-tablas">
                    <th colspan="4">
                        <div class="d-flex align-items-center gap-1">
                        <span class="material-icons">&#xe7fe;</span>
                        <strong>Agregar un Director de Planeamiento</strong>
                        </div>
                    </th>
                </tr>
            </thead>
        </table>
        <div class="row w-100 sombra m-0 pt-2 pb-4">
            <div class="col-4">
            <div class="mb-1">
                <label for="cedula" class="form-label">Ingrese el número de cédula</label>
                <input type="text" class="form-control" name="cedula" id="cedula">
            </div>
            <div class="mb-1">
                <label for="nombre" class="form-label">Ingrese los nombres</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
            <div class="mb-1">
                <label for="apellido" class="form-label">Ingrese los apellidos</label>
                <input type="text" class="form-control" id="apellido" name="apellido">
            </div>
            </div>
            <div class="col-4">
            <div class="mb-1">
                <label for="correo" class="form-label">Ingrese la direccion de correo electronico</label>
                <input type="email" name="correo" class="form-control" id="correo" placeholder="Ingrese el correo institucional...">
            </div>
            <div class="mb-1">
                <label for="telefono" class="form-label">Ingrese el número de teléfono</label>
                <input type="text" class="form-control opcional" id="telefono" name="telefono" placeholder="Opcional...">
            </div>
            <div class="mb-1">
                <label for="f_inicial" class="form-label">Ingrese la fecha inicial del cargo</label>
                <input type="date" class="form-control" id="f_inicial" name="f_inicial">
            </div>
            </div>
            <div class="col-4">
            <div class="mb-3">
                <label for="f_finalizacion" class="form-label">Ingrese la fecha de finalización del cargo</label>
                <input type="date" class="form-control" id="f_finalizacion" name="f_final">
            </div>
            <button type="submit" class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center justify-content-center m-auto gap-flex-1 w-50">
                <span class="material-icons text-white">&#xe03c;</span>
                Agregar 
                </button>
            </div>
        </div>
    </form>
    
    </div>
</div>