<article>
    <header>
        <h3 class="text-center tipografia-times-2">Verifique el estado de las Documentos de Información</h3>
    </header>
    <p class="text-justificado">
        Esta sección pone a su dispocición verificar que el documento que se encuentra almacenado sea el adecuado,
        además puede emitir una notificación explicando que el documento no lo puede validar por diferentes motivos, tambien 
        debera calificar el documento como la aportación a la carrara como medio,bajo o alto.
    </p>
</article>

<div class="w-100 d-flex justify-content-center">
<div class="desborde-auto barra-personalizada padding-all-1 sombra w-50 mb-4">
<div class="text-center">
     <label for=""><strong>Selecione un periodo valido para verificar las evidencias</strong> </label>
</div>
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

</div>
</div>

<div class="w-100">
<table class="table table-striped-columns w-100">
    <thead>
      <tr>
        <th class="bg-primary text-white text-center">Evidencia</th>
        <th class="bg-primary text-white text-center">Ver</th>
        <th class="bg-primary text-white text-center">Verificar</th>
        <th class="bg-primary text-white text-center"></th>
        <th class="bg-primary text-white text-center">Documento de Información</th>
        <th class="bg-primary text-white text-center">Fecha de Habilitación </th>
        <th class="bg-primary text-white text-center">Finalización de Entrega </th>
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
                    <td class="is-cargando-contenido p-5"></td>
                   </tr>
    </tbody>
  </table>
  <div class="contenedor-numeros-paginacion d-flex justify-content-center"></div>
</div>