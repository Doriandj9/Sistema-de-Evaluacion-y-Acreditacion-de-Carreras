<input type="hidden" value="<?= $_SESSION['carrera']?>" id="carreraID">
<div class="w-100" style="margin-top: 5rem;">
                           
                        <div class="contenedor-items-menu-superior tipografia-times-2" id="contenedor-menu-superior">
                            <ul>
                                <li class="is-activo-op-menu">Listar Responsables</li>
                                <li>Registrar Responsables</li>
                                <li>Registrar Evaluadores</li>
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
<template id="template-listar-responsables">
<div class="w-100 d-flex justify-content-center">
<div class="desborde-auto barra-personalizada padding-all-1 sombra w-50 mb-4">
<div class="w-100 d-flex justify-content-center mb-3">
    <div class="contenedor-filtro ps-2 pe-2">
        <span class="material-icons text-white">&#xe152;</span>
        <span class="text-white">Periodo </span>
    </div>
    <div class="contenedor-busqueda w-75" id="content-busqueda">
        <select class="w-100" name="" id="periodos"> 
            <?php foreach($periodos as $periodo): ?>
                <option value="<?= $periodo->id?>"><?= $periodo->id?></option>
              <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="w-100 d-flex justify-content-center">
    <div class="contenedor-filtro ps-2 pe-2">
        <span class="material-icons text-white">&#xe152;</span>
        <span class="text-white">Evidencia </span>
    </div>
    <div class="contenedor-busqueda w-75" id="content-busqueda">
        <span class="material-icons">&#xe8b6;</span>
        <input type="text" name="valor" id="busqueda" placeholder="Busque por el nombre.">
    </div>
</div>
</div>
<div class="reporte-responsables text-center">
  <img class="selector" height="40" id="pdf"  src="/public/assets/img/icons8-pdf-50.png" alt="imagen pdf" />
  <a data-dir= "/coordinador/reporte/responsables" href="" class="d-block tipografia-times-2 text-primary text-decoration-underline"
  id="reporte-responsables">Consultar Reporte</a>
</div>
</div>
<div class="w-100">
<table class="table table-striped-columns w-100">
    <thead>
      <tr>
        <th class="bg-primary text-white text-center">Cédula</th>
        <th class="bg-primary text-white text-center">Nombre</th>
        <th class="bg-primary text-white text-center">Correo Electrónico</th>
        <th class="bg-primary text-white text-center">Fecha de Habilitación </th>
        <th class="bg-primary text-white text-center">Finalización de Entrega </th>
        <th class="bg-primary text-white text-center">Criterios a Cargo</th>
       <!-- <th class="bg-primary text-white text-center">Documento de Información</th>
        
        <th class="bg-primary text-white text-center">Opción</th> -->
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

<!-- TODO: Vista de registrar responsables -->
<template id="template-insertar-responsables">
<div class="w-75">
<form class="tipografia-times-2" id="form-insert-carreras">
    <div class="mb-2">
      <label for="" class="form-label">Selecione un docente responsable</label>
      <select class="form-select" id="docentes" name="docente" multiple aria-label="multiple select example">
        <option selected>Cargando...</option>
      </select>
      </div>
      <div class="mb-2 d-flex gap-2 justify-content-between">
      <label for="periodos">Selecione el periodo de la responsabilidad</label>
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
    <div class="mb-2  d-flex justify-content-between">
      <label class="form-label  w-50" for="">Selecione la fecha de ingreso de evidencias</label>
      <input name="f_i" id="f_i" class="form-control w-50" type="date">
    </div>
    <div class="mb-2  d-flex justify-content-between">
      <label class="form-label  w-50" for="">Selecione la fecha limite de ingreso de evidencias</label>
      <input name="f_f" id="f_f" class="form-control w-50" type="date">
    </div>
    <div class="mb-2">
      <label for="id_carrera" class="form-label">Selecione las responsabilidades</label>
      <div class="w-100 h-2  sombra p-2 overflow-auto d-flex flex-wrap align-items-start gap-2" id="responsabilidades">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
    <div class="mb-2">
      <button type="submit" class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1">
      <span class="material-icons text-white">&#xe03c;</span>
      Agregar 
      </button>
  </form>
</div>
</template>

<!-- TODO: Vista de registrar evaludores -->
<template id="template-insertar-evaluadores">
<div class="w-100">
<table class="table table-striped-columns w-100">
    <thead>
    <tr class="titulo-tablas">
                        <th colspan="5" class="bg-primary text-white">
                            <div class="d-flex align-items-center">
                            <span class="material-icons text-white">&#xe241;</span>
                            <strong>Lista de Evaluadores</strong>
                            </div>
                        </th>
                    </tr>
      <tr>
        <th class="bg-primary text-white text-center">Cédula</th>
        <th class="bg-primary text-white text-center">Nombre</th>
        <th class="bg-primary text-white text-center">Correo Electrónico</th>
        <th class="bg-primary text-white text-center">Fecha del Cargo</th>
        <th class="bg-primary text-white text-center">Fecha Limite del Cargo</th>
      </tr>
    </thead>
    <tbody>
                    <tr>
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
      
                   </tr>
                   <tr>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>
                    <td class="is-cargando-contenido p-3"></td>

                   </tr>
    </tbody>
  </table>
  <div class="contenedor-numeros-paginacion d-flex justify-content-center"></div>
</div>
<table class="table table-striped-columns w-100 sombra m-0">
            <thead>
                <tr class="titulo-tablas">
                    <th colspan="4">
                        <div class="d-flex align-items-center gap-1">
                        <span class="material-icons">&#xe7fe;</span>
                        <strong>Agregar un Evaluador</strong>
                        </div>
                    </th>
                </tr>
            </thead>
        </table>
<div class="w-100 sombra p-2">
<form class="tipografia-times-2 w-75" id="">
<div class="mb-2 d-flex gap-2 justify-content-between">
      <label for="periodos">Selecione el periodo del cargo evaluador</label>
      <div class="contenedor-busqueda w-50" id="content-busqueda">
        <select class="w-100" name="periodo" id="periodos-evaluador"> 
            <?php foreach($periodos as $periodo): ?>
                <option value="<?= $periodo->id?>"><?= $periodo->id?></option>
              <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="mb-2">
      <label for="" class="form-label">Selecione un docente evaluador</label>
      <select class="form-select" id="docentes-evaluador" name="docente" multiple aria-label="multiple select example">
        <option selected>Cargando...</option>
      </select>
      </div>
    <div class="mb-2">
      <button type="submit" class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1">
      <span class="material-icons text-white">&#xe03c;</span>
      Agregar 
      </button>
  </form>
</div>
</template>