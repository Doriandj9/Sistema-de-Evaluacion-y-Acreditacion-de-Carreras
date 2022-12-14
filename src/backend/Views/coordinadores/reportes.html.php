<h3 class="text-center">Sección para Generar Reportes</h3>
<div class="w100 d-flex justify-content-center">
    <img width="450" height="350" src="/public/assets/img/undraw_documents_re_isxv.svg" alt="">
</div>
<p>
Esta sección en particular le permite generar un reporte sobre los documentos de informacion(Evidencias) almacenas
en su repositorio local dentro de la opción del menu de <a href="/docente/evidencias">Evidencias</a>   el cual contendra la informacion personal y los 
documentos que en el momento que genera el reporte se encuentrar guardadas en el sistema.
</p>
<form method="GET" action="/coordinador/generar/reporte" class="w-100 d-flex justify-content-center">
<div class="desborde-auto barra-personalizada padding-all-1 sombra w-50 mb-4">
<div class="w-100 d-flex justify-content-center mb-3">
    <div class="contenedor-filtro ps-2 pe-2">
        <span class="material-icons text-white">&#xe152;</span>
        <span class="text-white">Periodo </span>
    </div>
    <div class="contenedor-busqueda w-75" id="content-busqueda">
        <select class="w-100" name="periodo" id="periodos"> 
            <?php foreach($periodos as $periodo): ?>
                <option value="<?=trim($periodo->id)?>"><?= $periodo->id?></option>
              <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="w-100 d-flex justify-content-center mb-3">
    <div class="contenedor-filtro ps-2 pe-2">
        <span class="material-icons text-white">&#xe152;</span>
        <span class="text-white">Tipo</span>
    </div>
    <div class="contenedor-busqueda w-75" id="content-busqueda">
        <select class="w-100" name="tipo" id="periodos"> 
                <option value="1">Evidencias Almacenada</option>
                <option value="2">Evidencias y Docentes Encargados</option>
                <option value="3">Reporte de Autoevaluación</option>
        </select>
    </div>
</div>
    <button type="submit" class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1 m-auto ps-4 pe-4">
        <span class="material-icons text-white">&#xf090;</span> Generar Reporte
    </button>
    </div>
</form>