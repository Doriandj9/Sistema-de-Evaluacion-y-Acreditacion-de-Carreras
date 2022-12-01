import Precarga from "../../modulos/PreCarga/precarga.js";
import alerta from "../../utiles/alertasBootstrap.js";
import Evidencias from "../../models/Evidencias.js";
import { paginacionEvidenciasEvaluacion } from "../../utiles/paginacionEvidenciasEvaluacion.js";
import VisualizadorPDF from "../../modulos/VisualizadorPDF/VisualizadorPDF.js";



accionListar();

/**---------------------------------TODO: Script de la primera opcion Listar Evidencias----------------------------------------- */
function accionListar() {
    const select = document.getElementById('periodos');
    localStorage.periodo = select.value.trim();
    listarEvidencias(select.value.trim());
    buscarEvidencias(select);
}
function buscarEvidencias(select){
    select.addEventListener('change',() => {
        listarEvidencias(select.value.trim());
        localStorage.periodo = select.value.trim();
    })
}
function listarEvidencias(periodo){
    Evidencias.obtenerEvidencias(periodo,'evaluador')
    .then(r => renderEvidencias(r,'ver'))
    .catch(console.log)
}


function renderEvidencias(respuesta,opcion) {
    if(respuesta.ident){
        const tbody = document.body.querySelector('tbody');
        const contenedorNumeros = document.body.querySelector('.contenedor-numeros-paginacion');
        const busqueda = document.getElementById('busqueda');
        const {evidencias} = respuesta;
        paginacionEvidenciasEvaluacion(evidencias,8,1,tbody,contenedorNumeros,mostrarEvidencias);
        busqueda.addEventListener('input',(function(evidencias,mostrarEvidencias){
            return () => {
                paginacionEvidenciasEvaluacion(evidencias,8,1,tbody,contenedorNumeros,mostrarEvidencias,'cod_evidencias',busqueda.value.trim());
                mostrarEvidencias();
            };
        })(evidencias,mostrarEvidencias))
        mostrarEvidencias()
      }else{
        spinner.remove();
        alerta('alert-danger','Error del servidor',3000);
      }

}

function mostrarEvidencias(){
    const tbody = document.body.querySelector('tbody');
    const buttons = tbody.querySelectorAll('section');
    const select = document.querySelector('#periodos');
    const buttonsCalificar = tbody.querySelectorAll('button');
    const periodo = select === null ? localStorage.periodo.trim() : select.value.trim();
    buttons.forEach(button => {
        button.addEventListener('click',e => {
            e.stopPropagation();
            traerEvidencias(button,periodo)
        });
    })
    buttonsCalificar.forEach(button => {
        button.addEventListener('click',mostarFormCalificacion);
    })
}
/**
 * 
 * @param {HTMLElement} e 
 */
function traerEvidencias(e,periodo) {
    const input = e.nextElementSibling;
    Evidencias.obtenerEvidenciaIndvidual(periodo,input.value,'evaluador')
    .then(guardarBlobs)
    .catch(console.log)
    desplegarModal();
}

function guardarBlobs(blobs) {
    document.dispatchEvent(new CustomEvent('archivos.deplegados',{detail:blobs}));
}

function desplegarModal() {
const modal = document.createElement('div');
        modal.classList = 'modal fade';
        modal.id = `presentacionViews`;
        modal.setAttribute('tabindex','-1');
        modal.setAttribute('aria-labelledby','exampleModalLabel');
        modal.setAttribute('aria-hidden',true);
        modal.innerHTML = `
    <!-- Formulario -->
        <form>
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Visualizar o Descargar los Documentos de Información(Evidencias)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <h4 for="staticEmail" class="col-form-label">Documento de información a calificar</h4>
                <div class="col-sm-10">
                <label class="position-relative" for="pdf">
                <div class="spinner-border text-dark carga-medio" role="status"><span class="visually-hidden">Loading...</span></div>
                <img class="selector" height="40" id="pdf"  src="/public/assets/img/icons8-pdf-50.png" alt="imagen pdf" />
                </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="evaluador" class="form-label">Calificado por</label>
                <input type="text" class="form-control" id="evaluador" disabled>
            </div>
            <div class="mb-3">
                <label for="calificacion" class="form-label">Calificación</label>
                <input type="text" class="form-control" id="calificacion" disabled>
            </div>
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario</label>
                <input type="text" class="form-control" id="comentario" disabled>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
      </form>
        `;
    document.body.append(modal);
    const modalBootstrap =  new bootstrap.Modal(modal,{});
    modalBootstrap.show();
    modal.addEventListener('hidden.bs.modal',(e) => {
        modal.remove();
    })
}

document.addEventListener('archivos.deplegados',e => {
    const blobs = e.detail;
    const modal = document.getElementById('presentacionViews');
    const imgs = modal.querySelectorAll('img');
    imgs.forEach(img => {
        const beforeSpinner = img.previousElementSibling;
        beforeSpinner.remove();
        img.addEventListener('click',e => viewFile(e,blobs));
    })
})
/**
 * 
 * @param {Event} e 
 * @param {Array} blobs 
 */
function viewFile(e,blobs){
    const type = e.target.id;
    const refblob = {'pdf': blobs[0],'word': blobs[1],'excel': blobs[2]}
    const blob = refblob[type];
    const view = new VisualizadorPDF();
    view.habilitarESC();
    view.mostrar(blob);

}
window.addEventListener('close.viewpdf',e =>{
            e.detail.remove();
    })
/**
 * 
 * @param {Event} e 
 */
function mostarFormCalificacion(e){
    e.stopPropagation();
    const select = document.getElementById('periodos');
    traerEvidencias(e.target,select.value.trim());
    const modal = document.createElement('div');
        modal.classList = 'modal fade';
        modal.id = `presentacionViews`;
        modal.setAttribute('tabindex','-1');
        modal.setAttribute('aria-labelledby','exampleModalLabel');
        modal.setAttribute('aria-hidden',true);
        modal.innerHTML = `
    <!-- Formulario -->
        <form>
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Visualizar o Descargar los Documentos de Información(Evidencias)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <h4 for="staticEmail" class="col-form-label">Documento de información a calificar</h4>
                <div class="col-sm-10">
                <label class="position-relative" for="pdf">
                <div class="spinner-border text-dark carga-medio" role="status"><span class="visually-hidden">Loading...</span></div>
                <img class="selector" height="40" id="pdf"  src="/public/assets/img/icons8-pdf-50.png" alt="imagen pdf" />
                </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="evaluador" class="form-label">Calificado por</label>
                <input type="text" class="form-control" id="evaluador" disabled>
            </div>
            <div class="mb-3">
                <label for="calificacion" class="form-label">Calificación</label>
                <input type="text" class="form-control" id="calificacion" disabled>
            </div>
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario</label>
                <input type="text" class="form-control" id="comentario" disabled>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
      </form>
        `;
    document.body.append(modal);
    const modalBootstrap =  new bootstrap.Modal(modal,{});
    modalBootstrap.show();
    modal.addEventListener('hidden.bs.modal',(e) => {
        modal.remove();
    })
}