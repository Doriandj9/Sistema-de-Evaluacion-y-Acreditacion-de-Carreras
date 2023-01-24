<article>
    <header>
        <h3 class="text-center tipografia-times-2">Verifique el estado de las Documentos de Información</h3>
    </header>
    <section>
        <h4>Consideraciones</h4>
        <ol>
            <li>- En la opción ver usted podrá visualizar la documentación almacenada y verificar si es la adecuada o no.</li>
            <li>- En el apartado Valoración usted podrá dar una valoración del documento almacenado.</li>
            <li>- En la ultima opción usted podrá notificar al usuario que la documentación almacenada es incorrecta si llega a darse el caso.</li>
        </ol>
    </section>
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
<div class="w-100 d-flex justify-content-center">
    <div class="contenedor-filtro ps-2 pe-2">
        <span class="material-icons text-white">&#xe152;</span>
        <span class="text-white">Evidencia </span>
    </div>
    <div class="contenedor-busqueda w-75" id="content-busqueda">
        <span class="material-icons">&#xe8b6;</span>
        <input type="text" name="valor" id="busqueda" placeholder="Busque por el nombre de evidencia.">
    </div>
</div>
</div>
</div>

<div class="w-100">
<table class="table table-striped-columns w-100">
    <thead>
      <tr>
        <th class="bg-primary text-white text-center">Evidencia</th>
        <th class="bg-primary text-white text-center">Visualizar</th>
        <th class="bg-primary text-white text-center">Valoración</th>
        <th class="bg-primary text-white text-center">Opción</th>
      </tr>
    </thead>
    <tbody>
                    <tr>
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
                   </tr>
                   <tr>
                   <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                    <td class="is-cargando-contenido p-5"></td>
                   </tr>
    </tbody>
  </table>
  <div class="contenedor-numeros-paginacion d-flex justify-content-center"></div>
</div>