import Precarga from "../../modulos/PreCarga/Precarga.js";
import alerta from "../../utiles/alertasBootstrap.js";
import Evidencias from "../../models/Evidencias.js";
import { paginacionEvidenciasEvaluacion } from "../../utiles/paginacionEvidenciasEvaluacion.js";
import VisualizadorPDF from "../../modulos/VisualizadorPDF/VisualizadorPDF.js";
import { CONTROL_MAX_MIN_CUALITATIVAS_EVIDENCIAS,CONTROL_MAX_MIN_CUANTITIVAS_EVIDENCIAS } from "../../config.js";
import Usuarios from "../../models/Usuarios.js";
import Notificacion from "../../modulos/Notificacion/Notificacion.js";


let precarga = null;
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


function renderEvidencias(respuesta) {
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
        button.addEventListener('click',e => {
            e.stopPropagation();
            traerEvidencias(button,periodo,true);
        });
    })
}
/**
 * 
 * @param {HTMLElement} button 
 */
function traerEvidencias(button,periodo,opcion=null) {
    const input = button.nextElementSibling;
    Evidencias.obtenerEvidenciaIndvidual(periodo,input.value,'evaluador')
    .then(guardarBlobs)
    .catch(console.log)
    opcion !== true ? desplegarModal() : mostarFormCalificacion(button);    
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
 * @param {HTMLButtonElement} button
 */
function mostarFormCalificacion(button){
    const valoresCualitativas = Object.entries(CONTROL_MAX_MIN_CUALITATIVAS_EVIDENCIAS);
    let optionsHTML = '<option value="none">Por favor selecione la opción...</option>';
    valoresCualitativas.forEach( v => {
        const [key,value] = v;
        optionsHTML += `
        <option value="${value}">${key} ➡ ${value} </option>
        `;
});
    const calificacionCualitativa = `
    <select class="form-select" aria-label="Default select example" 
    id="cuali" name="calificacion">
    ${optionsHTML}
    </select>
    `;
    const {max,min} = CONTROL_MAX_MIN_CUANTITIVAS_EVIDENCIAS;
    const calificacionCuantitativa = `
    <input type="number" max="${max}" min="${min}" name="calificacion" id="cuanti"/>
    `;
    const modal = document.createElement('div');
        modal.classList = 'modal fade';
        modal.id = `presentacionViews`;
        modal.setAttribute('tabindex','-1');
        modal.setAttribute('aria-labelledby','exampleModalLabel');
        modal.setAttribute('aria-hidden',true);
        modal.innerHTML = `
    <!-- Formulario -->
        <form>
        <input type="hidden" name="id_evidencia" value="${button.dataset.idEvidencia}"/>
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Calificar los Documentos de Información(Evidencias)</h5>
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
                <label for="" class="form-label">
                La forma de evaluar el presente documento de información es de forma
                <strong> ${button.dataset.infoTipo}</strong>  
                </label>
                <input type="text" value="${
                    button.dataset.infoTipo.toUpperCase() === 'CUALITATIVO' ?
                    'La calificación de este documento de información es cualitativa.' :
                    'La calificación de este documento de información es cuatitativa por favor revise las formulas y asegurese de ingresar unicamente el valor en la casilla.'
                }"
                 class="form-control" id="" disabled>
            </div>
            <div class="mb-3">
                <label for="calificacion" class="form-label">${button.dataset.infoTipo.toUpperCase() === 'CUALITATIVO' ?
                'Selecione calificación de las opciones propuestas.' : 'Ingrese la calificación.'}</label>
                ${button.dataset.infoTipo.toUpperCase() === 'CUALITATIVO' ? calificacionCualitativa :
                calificacionCuantitativa}
            </div>
            <div class="mb-3">
                <label for="observacion" class="form-label">Observación</label>
                <textarea name="observacion" class="form-control" style="resize:none;" autocapitalize="on" cols="48" rows="5"
                  placeholder="Aa"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary text-white">Guardar Calificación</button>
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

   const form = modal.querySelector('form');
   form.addEventListener('submit',e => verificacionDatos(e,modalBootstrap));
}


function verificacionDatos(e,modalB) {
    e.preventDefault();
    const cuanti = e.target.querySelector('#cuanti');
    const cuali = e.target.querySelector('#cuali');
    if(cuanti) {
        const {max,min} = CONTROL_MAX_MIN_CUANTITIVAS_EVIDENCIAS;
        if(!(Number(cuanti.value) >= min && Number(cuanti.value) <= max)){
            alerta('alert-warning',`El valor de la calificación no debe ser menor a
            <strong>${min}</strong> y mayor a <strong>${max}.</strong>
            `,3500);
            cuanti.classList.add('is-invalid');
            return;
        }
    }
    if(cuali) {
        if(cuali.value === 'none'){
            alerta('alert-warning','Debe selecionar un valor valido para continuar.',3500);
            cuali.classList.add('is-invalid');
            return;
        }
    }
    envioDatos(e.target,modalB);
}

function envioDatos(form,modalBootstrap) {
    modalBootstrap.hide();
    const periodos = document.getElementById('periodos');
    precarga = new Precarga();
    precarga.run();
    const formData = new FormData(form);
    formData.append('periodo',periodos.value.trim())
    Usuarios.registarCalificacion(formData)
    .then(renderRespuesta)
    .catch(console.log);
}


function renderRespuesta(respuesta) {
    precarga.end();
    if(respuesta.ident) {
        new Notificacion(respuesta.mensaje,'Aceptar',false);
    }else {
        new Notificacion(respuesta.mensaje,'Regresar');
    }
}