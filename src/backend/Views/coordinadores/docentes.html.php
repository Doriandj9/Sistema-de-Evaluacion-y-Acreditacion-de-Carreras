<div class="w-100" style="margin-top: 5rem;">
                           
                        <div class="contenedor-items-menu-superior tipografia-times-2" id="contenedor-menu-superior">
                            <ul>
                                <li class="is-activo-op-menu">Listar Docentes</li>
                                <li>Registrar Docentes</li>
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
<template id="template-listar-docentes">
<div class="w-100 d-flex justify-content-center mb-3">
    <div class="contenedor-filtro">
    <span class="material-icons text-white">&#xe152;</span>
    <span class="text-white">Busqueda </span>
</div>
<div class="contenedor-busqueda" id="content-busqueda">
     <span class="material-icons">&#xe8b6;</span>
    <input type="text" name="valor" id="busqueda" placeholder="Busque por el nombre.">
</div>
</div> 
<div class="w-100">
<table class="table table-striped-columns w-100">
    <thead>
      <tr>
        <th class="bg-primary text-white text-center">Cédula</th>
        <th class="bg-primary text-white text-center">Nombre</th>
        <th class="bg-primary text-white text-center">Correo Electronico</th>
        <th class="bg-primary text-white text-center">Nº Celular</th>
        <th class="bg-primary text-white text-center">Fecha Incial</th>
        <th class="bg-primary text-white text-center">Fecha Final</th>
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
                    <td class="is-cargando-contenido p-5"></td>
                   </tr>
                   <tr>
                    <td class="is-cargando-contenido p-5"></td>
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
                    <td class="is-cargando-contenido p-5"></td>
                   </tr>
    </tbody>
  </table>
  <div class="contenedor-numeros-paginacion d-flex justify-content-center"></div>
</div>
</template>

<!-- TODO: Vista de registrar docentes -->
<template id="template-registar-docentes">
<div class="w-75">
<form class="tipografia-times-2" id="form-insert">
    <div class="mb-2">
      <label for="cedula" class="form-label">Ingrese la cédula del Docente</label>
      <input type="text" name="cedula" class="form-control" id="cedula">
      </div>
    <div class="mb-2">
      <label for="nombres" class="form-label">Ingrese los nombres del Docente</label>
      <input autocomplete="false" type="text" name="nombres" class="form-control" id="nombres">
    </div>
    <div class="mb-2">
      <label for="apellidos" class="form-label">Ingrese los apellidos del Docente</label>
      <input type="text" class="form-control" name="apellidos" id="apellidos">
    </div>
    <div class="mb-2">
        <label for="correo" class="form-label">Ingrese el correo institucional</label>
        <input type="email"  name="correo" class="form-control" id="correo" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text">El correo debe contener ueb o mailes</div>
      </div>
      <div class="mb-2">
      <label for="telefono" class="form-label">Ingrese el número telefonico</label>
      <input placeholder="Opcional ..." type="text" class="form-control" name="telefono" id="telefono">
    </div>
    <div class="mb-2 d-flex gap-2 justify-content-between">
      <label for="periodos">Selecione el periodo vigente</label>
      <div class="contenedor-busqueda w-50" id="content-busqueda">
        <select class="w-100" name="periodo" id="periodos"> 
            <?php foreach($periodos as $periodo): ?>
                <option data-fecha-inicial="<?= $periodo->fecha_inicial;?>" 
                data-fecha-final="<?= $periodo->fecha_final;?>" value="<?= $periodo->id;?>">
                <?= $periodo->id;?>
                </option>
              <?php endforeach; ?>
        </select>
      </div>
    </div>
      <button type="submit" class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1">
      <span class="material-icons text-white">&#xe03c;</span>
      Agregar 
      </button>
  </form>
</div>
</template>
