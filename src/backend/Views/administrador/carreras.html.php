<div class="w-100" style="margin-top: 5rem;">
                           
                        <div class="contenedor-items-menu-superior tipografia-times-2" id="contenedor-menu-superior">
                            <ul>
                                <li class="is-activo-op-menu">Listas de Carreras</li>
                                <li>Ingresar Carrera</li>
                                <li>Habilitar Carrera</li>
                            </ul>
                        </div>
                        <div class="w100" id="cambio-vistas">
                          <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                            <div class="spinner-border text-primary" role="status">
                              <span class="visually-hidden">Loading...</span>
                            </div>
                          </div>
                        </div>

</div>
<!-- Vistas  -->
<template id="template-listar-carreras">
<div class="w-100 d-flex justify-content-center mb-3">
                        <div class="contenedor-filtro">
                        <span class="material-icons text-white">&#xe152;</span>
                            <select class="filtro" name="opcion" id="filtro-busqueda">
                                <option value="carrera">Carrera</option>
                                <option value="facultad">Facultad</option>
                            </select>
                        </div>
                            <div class="contenedor-busqueda" id="content-busqueda">
                            <span class="material-icons">&#xe8b6;</span>
                            <input type="text" name="valor" id="busqueda" placeholder="Escriba aquí...">
                            <span class="material-icons text-danger">&#xe5c9;</span>
                            </div>
</div> 
<div class="w-100">
<table class="table table-striped-columns w-100">
    <thead>
      <tr>
        <th class="bg-primary text-white text-center">Identificador</th>
        <th class="bg-primary text-white text-center">Nombre</th>
        <th class="bg-primary text-white text-center">Facultad</th>
        <th class="bg-primary text-white text-center">Numero de Asignaturas</th>
        <th class="bg-primary text-white text-center">Horas de Proyecto de Carrera</th>
        <th class="bg-primary text-white text-center">Opción</th>
      </tr>
    </thead>
    <tbody>
                    <tr>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                   </tr>
                   <tr>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                   </tr>
                   <tr>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                   </tr>
    </tbody>
  </table>
  <div class="contenedor-numeros-paginacion d-flex justify-content-center"></div>
</div>
</template>
<template id="template-insertar-carreras">
<div class="w-75">
<form class="tipografia-times-2" id="form-insert-carreras">
    <div class="mb-2">
      <label for="" class="form-label">Selecione la Facultad a la que corresponda</label>
        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="facultad" id="select-facultades-insert">
        <option value="none">Cargando...</option>
        </select>
      </div>
    <div class="mb-2">
      <label for="id_carrera" class="form-label">Ingrese el identificador de carrera</label>
      <input autocomplete="false" type="text" name="id" class="form-control" id="id_carrera" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text">El codigo de la carrera debe ser unico</div>
    </div>
    <div class="mb-2">
      <label for="nombre" class="form-label">Ingrese el nombre de la carrera</label>
      <input type="text" class="form-control" name="nombre" id="nombre">
    </div>
    <div class="mb-2">
        <label for="numero_asig" class="form-label">Ingrese el numero de asignaturas de la carrera</label>
        <input type="number" min="1" name="numero_asig" class="form-control" id="numero_asig">
      </div>
      <div class="mb-2">
        <label for="horas_proyecto" class="form-label">Ingrese el total de horas del proyecto de carrera</label>
        <input type="number" min="1" name="horas_proyecto" class="form-control" id="horas_proyecto">
      </div>
      <button type="submit" class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1">
      <span class="material-icons text-white">&#xe03c;</span>
      Agregar 
      </button>
  </form>
</div>
</template>
<template id="template-habilitar-carreras">
<div class="w-100 d-flex justify-content-center mb-3">
                                <div class="contenedor-filtro">
                                <span class="material-icons text-white p-1">&#xf8cf;</span>
                                <span class="text-white p-1">Selecione un Periodo Academico</span> 
                                </div>
                                    <div class="contenedor-busqueda" id="content-busqueda">
                                        <select class="flex-grow-1" name="opcion" id="periodos-academicos">
                                            <option value="none">Cargando...</option>
                                        </select>
                                    </div>
                                    
                            </div>
                            <div class="w-100">
                                <table class="table table-striped-columns w-100">
                                    <thead>
                                      <tr>
                                          <th class="bg-primary text-white text-center">Habilitado</th>
                                          <th class="bg-primary text-white text-center">Identificador</th>
                                        <th class="bg-primary text-white text-center">Nombre</th>
                                        <th class="bg-primary text-white text-center">Periodo Academico</th>
                                      </tr>
                                    </thead>
                                    <tbody class="tbody-h">
                                                    <tr>
                                                    <td class="is-cargando-contenido p-4"></td>
                                                    <td class="is-cargando-contenido p-4"></td>
                                                    <td class="is-cargando-contenido p-4"></td>
                                                    <td class="is-cargando-contenido p-4"></td>
                                                   </tr>
                                                   <tr>
                                                    <td class="is-cargando-contenido p-4"></td>
                                                    <td class="is-cargando-contenido p-4"></td>
                                                    <td class="is-cargando-contenido p-4"></td>
                                                    <td class="is-cargando-contenido p-4"></td>
                                                   </tr>
                                                   <tr>
                                                    <td class="is-cargando-contenido p-4"></td>
                                                    <td class="is-cargando-contenido p-4"></td>
                                                    <td class="is-cargando-contenido p-4"></td>
                                                    <td class="is-cargando-contenido p-4"></td>
                                                   </tr>
                                    </tbody>
                                  </table>
                                  <div class="contenedor-numeros-paginacion d-flex justify-content-center"></div>
                                </div>
                                <div class="w-100 d-flex justify-content-around align-items-center contenedor-habilitacion">
                                    <div class="form-check d-flex align-items-center gap-2" id="checkHabilitarContenedor">
                                        <input class="form-check-input" type="checkbox" value="" id="checkHabilitar">
                                        <label class="form-check-label" for="checkHabilitar">
                                            Habilitar Auto Evaluación 
                                        </label>
                                      </div>
                                    <div class="">
                                        <button class="boton boton-enviar is-hover-boton-enviar d-flex align-items-center gap-flex-1"
                                        id="boton-g-habilitacion">
                                            <span class="material-icons text-white">&#xe163;</span>
                                            Guardar
                                        </button>
                                    </div>
                                </div>
</template>
