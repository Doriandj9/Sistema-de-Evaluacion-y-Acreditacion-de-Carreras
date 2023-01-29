<div class="w-100" style="margin-top: 5rem;">
                           
                        <div class="contenedor-items-menu-superior tipografia-times-2" id="contenedor-menu-superior">
                            <ul>
                                <li class="is-activo-op-menu">Listar Evaluadores</li>
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
<template id="template-listar-evaluadores">
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
        <span class="text-white">Evaluador</span>
    </div>
    <div class="contenedor-busqueda w-75" id="content-busqueda">
        <span class="material-icons">&#xe8b6;</span>
        <input type="text" name="valor" id="busqueda" placeholder="Busque por el nombre del docente...">
    </div>
</div>
</div>
</div>
<div class="w-100">
<table class="table table-striped-columns w-100">
    <thead>
      <tr>
        <th class="bg-primary text-white text-center">Cédula</th>
        <th class="bg-primary text-white text-center">Nombre</th>
        <th class="bg-primary text-white text-center">Correo Electronico</th>
        <th class="bg-primary text-white text-center">Fecha Inicial de Evaluación </th>
        <th class="bg-primary text-white text-center">Fecha Final de Evaluación </th>
        <th class="bg-primary text-white text-center">Carreras a Evaluar</th>
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

<!-- TODO: Vista de registrar evaluadores -->
<template id="template-registar-evaluadores">
<div class="w-100 d-flex justify-content-center ">
<div class="desborde-auto barra-personalizada padding-all-1 sombra w-50 mb-4">
<div class="w-100 d-flex justify-content-center mb-3">
    <div class="contenedor-filtro ps-2 pe-2">
        <span class="material-icons text-white">&#xe152;</span>
        <span class="text-white">Periodo </span>
    </div>
    <div class="contenedor-busqueda w-75" id="content-busqueda">
        <select class="w-100" name="" id="periodos"> 
            <?php foreach($periodos as $periodo): ?>
                <option data-f-inicial="<?= $periodo->fecha_inicial;?>"
                data-f-final="<?= $periodo->fecha_final;?>"
                value="<?= $periodo->id?>"><?= $periodo->id?></option>
              <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="w-100 d-flex justify-content-center">
    <div class="contenedor-filtro ps-2 pe-2">
        <span class="material-icons text-white">&#xe152;</span>
        <span class="text-white">Evaluador</span>
    </div>
    <div class="contenedor-busqueda w-75" id="content-busqueda">
        <span class="material-icons">&#xe8b6;</span>
        <input type="text" name="valor" id="busqueda" placeholder="Busque por el nombre del docente...">
    </div>
</div>
</div>
</div>
<div class="w-100  tbody-h">
<table class="table table-striped-columns w-100">
    <thead>
      <tr>
        <th class="bg-primary text-white text-center">Cédula</th>
        <th class="bg-primary text-white text-center">Nombre</th>
        <th class="bg-primary text-white text-center">Correo Electronico</th>
        <th class="bg-primary text-white text-center">Carreras Perteneciente</th>
        <th class="bg-primary text-white text-center">Selecionar</th>
      </tr>
    </thead>
    <tbody>
                    <tr>
                    <td colspan="5" class="is-cargando-contenido p-5 text-center">
                        Cargando... 
                    </td>                    
                   </tr>
    </tbody>
  </table>
  <div class="contenedor-numeros-paginacion d-flex justify-content-center"></div>
</div>




<div class="centrado-linea  tbody-h">
<div class="desborde-auto barra-personalizada padding-all-1">
    <form id="form-director">
    <table class="table table-striped-columns w-100 sombra m-0">
            <thead>
                <tr class="titulo-tablas">
                    <th colspan="4">
                        <div class="d-flex align-items-center gap-1">
                        <span class="material-icons">&#xe7fe;</span>
                        <strong>Emparejar Evaluadores con la carreras</strong>
                        </div>
                    </th>
                </tr>
            </thead>
        </table>
        <div class="row w-100 sombra m-0 pt-2 pb-4 tipografia-sanSerif-3">
            <div class="row">
            <div class="mb-1">
                <label for="" class="form-label">
                    <strong>Por favor, seleccione las carreras para las cuales desea que el evaluador realice la evaluación.</strong>
                </label>
                <div style="height: 10rem;" class="w-100 d-flex gap-3 align-items-start justify-content-around  sombra p-3 mb-3 flex-wrap desborde-auto"  id="carreras">
                </div>
            </div>
            </div>
            <div class="row mb-3"> 
                <label for="staticEmail" class="col-sm-4 col-form-label">Ingrese la fecha de acceso</label>
                <div class="col-sm-6">
                <input type="date" class="form-control" id="f_i" name="f_i">
                </div>
            </div>

            <div class="row mb-5">
            <label for="staticEmail" class="col-sm-4 col-form-label">Ingrese la fecha limite de acceso</label>
                <div class="col-sm-6">
                <input type="date" class="form-control" id="f_f" name="f_f">
                </div>
            </div>
            <div class="mb-1 d-flex justify-content-center">
            <button type="submit" class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center justify-content-center m-auto gap-flex-1 w-25">
                <span class="material-icons text-white">&#xe03c;</span>
                Guardar 
            </button>
            </div>
        </div>
    </form>
    
    </div>
</div>
</template>
