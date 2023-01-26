<div class="w-100" style="margin-top: 5rem;">
                           
                        <div class="contenedor-items-menu-superior tipografia-times-2" id="contenedor-menu-superior">
                            <ul>
                                <li class="is-activo-op-menu">Lista de Coordinadores</li>
                                <li>Ingresar un Coordinador</li>
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

<template id="template-ingresar-coordinador">
<div class="w-75">
<form class="tipografia-times-2" id="form-insert-carreras">
    <div class="mb-2">
      <label for="" class="form-label">Selecione la carrera en el que se registrara</label>
      <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="carreras" id="carreras">
        <option value="none" >Presione aquí ...</option>
        <?php foreach($carreras as $carrera): ?>
        <option value="<?= trim($carrera->id); ?>"> <?= $carrera->nombre; ?></option>
        <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
      <label for="id_carrera" class="form-label">Selecione el docente</label>
        <select  class="form-select form-select-sm" aria-label=".form-select-sm example"  name="coordinador" id="coordinador">
            <option value="none">Presione aquí ...</option>
        </select>
    </div>
    <div class="mb-3">
      <label for="nombre" class="form-label">Ingrese la fecha inicial de cargo</label>
      <input type="date" class="form-control" id="f_i" name="fecha_inicial">
    </div>
    <div class="mb-4">
        <label for="numero_asig" class="form-label">Ingrese la fecha de finalización de cargo</label>
        <input type="date" class="form-control" id="f_f" name="fecha_final">
      </div>
      <button type="submit" class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1">
      <span class="material-icons text-white">&#xe03c;</span>
      Agregar 
      </button>
  </form>
</div>
<div class="100 d-flex justify-content-center align-items-center pt-5">
    <button id="ingreso-manual" type="submit" data-bs-toggle="modal"
    class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1">
        <span class="material-icons text-white">&#xe764;</span>
        Ingresar Manualmente un Coordinador 
    </button>
  </div>
<!-- <div class="centrado-linea">
<div class="desborde-auto barra-personalizada padding-all-1 ">
    <form>
        <table class="tabla tabla-vertical contenedor-x100 sombra centrado-linea">
            <thead>
                <tr>
                    <th>Carreras</th>
                    <th>Coordinador</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Finalización</th>
                    <th>Guardar</th>
                </tr>
            </thead>
            <tbody>
                <tr class="p-relativo">
                    <td>
                        <div class="flex-linea flex-items-center input-personalizado-login">
                        <label for="carreras"><span class="material-icons">&#xe152;</span></label> 
                        </div>
                    </td>
                    <td>
                        <div class="flex-linea flex-items-center input-personalizado-login">
                            <label for="coordinador"><span class="material-icons">&#xe03b;</span></label> 
                            <select name="coordinador" id="coordinador">
                            <option value="none">Presione aquí ...</option>

                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="flex-linea flex-items-center input-personalizado-login">
                            <label for="f_i"><span class="material-icons">&#xebcc;</span></label> 
                            <input type="date" id="f_i" name="fecha_inicial">
                        </div>
                    </td>
                    <td>
                        <div class="flex-linea flex-items-center input-personalizado-login">
                           <label for="f_f"><span class="material-icons">&#xe916;</span></label> 
                            <input type="date" id="f_f" name="fecha_final">
                        </div>
                    </td>
                    <td>
                        <button class="boton boton-enviar is-hover-boton-enviar block centrado-linea">Agregar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
</div> -->
</template>

<template id="template-lista-coordinadores">
<div class="w-100 d-flex justify-content-center mb-3">
                        <div class="contenedor-filtro">
                        <span class="material-icons text-white">&#xe152;</span>
                          <span class="text-white">Búsqueda </span>
                        </div>
                            <div class="contenedor-busqueda" id="content-busqueda">
                            <span class="material-icons">&#xe8b6;</span>
                            <input type="text" name="valor" id="busqueda" placeholder="Busque por el nombre de la carrera ...">
                            </div>
</div> 
<div class="w-100">
<table class="table table-striped-columns w-100" id="tabla-coordinadores">
    <thead>
      <tr>
        <th class="bg-primary text-white text-center">Nº Cédula</th>
        <th class="bg-primary text-white text-center">Coordinador</th>
        <th class="bg-primary text-white text-center">Correo Institucional</th>
        <th class="bg-primary text-white text-center">Fecha Inicial</th>
        <th class="bg-primary text-white text-center">Fecha Final</th>
        <th class="bg-primary text-white text-center">Carrera</th>
        <th class="bg-primary text-white text-center">Estado</th>
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
</div>
</template>