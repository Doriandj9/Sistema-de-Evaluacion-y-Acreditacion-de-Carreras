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
        paginacionEvidenciasEvaluacion(evidencias,10,1,tbody,contenedorNumeros,mostrarEvidencias);
        busqueda.addEventListener('input',(function(evidencias,mostrarEvidencias){
            return () => {
                if(busqueda.value.trim() !== '') {
                    paginacionEvidenciasEvaluacion(evidencias,10,1,tbody,contenedorNumeros,mostrarEvidencias,'nombre_evidencias',busqueda.value.trim(),true);
                    mostrarEvidencias();
                } else {
                    paginacionEvidenciasEvaluacion(evidencias,10,1,tbody,contenedorNumeros,mostrarEvidencias);
                    mostrarEvidencias();
                }
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
        Evidencias.estaCalificadaEvidencia(periodo,button.dataset.idEvidencia)
        .then(respuesta => habilitarButton(button,respuesta))
        .catch(console.log)
        button.addEventListener('click',e => {
            e.stopPropagation();
            traerEvidencias(button,periodo,true);
        });
    })
}
function habilitarButton(button,respuesta){
    if(respuesta.ident){
        // button.setAttribute(respuesta.calificada === true ? '' : 'disabled','');
        // button.classList.add(respuesta.calificada === true ? '' : 'desactivado','');  
        if(respuesta.calificada){
            button.setAttribute('disabled','');
            button.setAttribute('title','No puede volver a calificar una misma fuente de información.');
            button.classList.add('desactivado');
        }
    }else {
        alerta('alert-danger','Ocurrio un error en el servidor algunos de las acciones pueden no funcionar correctamente.',3500);
    }
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
    opcion !== true ? desplegarModal(button.dataset.idEvidencia,periodo) : mostarFormCalificacion(button);    
}

function guardarBlobs(blobs) {
    document.dispatchEvent(new CustomEvent('archivos.deplegados',{detail:blobs}));
}

function desplegarModal(id,periodo) {
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
            <h5 class="modal-title" id="exampleModalLabel">Datos de la calificación de la fuente de información(Evidencia)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <h4 for="staticEmail" class="col-form-label">Fuente de información</h4>
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
                <label for="comentario" class="form-label">Observación</label>
                <textarea type="text" class="form-control" id="comentario" disabled>
                </textarea>
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
    const [evaluador,calificacionIn] = modal.querySelectorAll('input[type=text]');
    const observacion = modal.querySelector('textarea');
    Evidencias.obtenerCalificacionEvidencia(periodo,id)
    .then(respuesta => {
        if(respuesta.ident){
            let {calificacion} = respuesta;
            calificacion = calificacion[0];
            evaluador.value = calificacion.nombre_docente +' '+ calificacion.apellido_docente;
            calificacionIn.value = calificacion.calificacion;
            observacion.value = calificacion.observacion;

        }else{
            alerta('alert-danger','No se puede mostrar la información, ocurrio un error en el servidor.',3500);
        }
    })
    .catch(console.log)
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
    <input type="number" class="form-control" step="0.01" name="calificacion" id="cuanti"/>
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
            <h5 class="modal-title" id="exampleModalLabel">Calificar las Fuentes de Información(Evidencias)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          
          <div class="mb-3 tipografia-times-1" style="border-bottom: 1px solid #ccc;">
          <h4>Concideraciones</h4>
          <ul class="list-circle ">
          <li>
          Puede visualizar la fuente de información dando un click en la imagen pdf
          que se encuentra en la parte inferior.
          </li>
          <li>
          La calificación puede ser CUALITATIVO O CUANTITATIVO correspondiente a cada evidencia,
          se le recomienda asegurarse de ingresar correctamente la calificación.
          </li>
          <li>
          La observación que ingrese estará emparejado con la calificación, si decide no ingresar ninguna 
          observación se asumirá que la anotación es: "Sin Observaciones."
          </li>
          <li>
          Por último debe estar consciente que una vez que califica la evidencia nadie más lo va a volver a calificar.
          </li>
          </ul>
          </div>

          <div class="mb-3 pb-2" style="border-bottom: 1px solid #ccc;">
            <h4 for="staticEmail" class="col-form-label"><strong> Nombre de la fuente de información</strong></h4>
            <div class="col-sm-10">
            <p>
            ${button.dataset.nombreEvidencia}
            </p>
            </div>
        </div>

            <div class="mb-3">
                <h4 for="staticEmail" class="col-form-label">Visualice la fuente de información.</h4>
                <div class="col-sm-10">
                <label class="position-relative" for="pdf">
                <div class="spinner-border text-dark carga-medio" role="status"><span class="visually-hidden">Loading...</span></div>
                <img class="selector" height="40" id="pdf"  src="/public/assets/img/icons8-pdf-50.png" alt="imagen pdf" />
                </label>
                </div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">
                La forma de evaluar la presente fuente de información es de forma
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
                'Selecione la calificación de las opciones propuestas.' : 'Ingrese la calificación.'}</label>
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
   form.addEventListener('submit',e => verificacionDatos(e,modalBootstrap,button));
}


function verificacionDatos(e,modalB,button) {
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
    envioDatos(e.target,modalB,button);
}

function envioDatos(form,modalBootstrap,button) {
    modalBootstrap.hide();
    const periodos = document.getElementById('periodos');
    precarga = new Precarga();
    precarga.run();
    const formData = new FormData(form);
    formData.append('periodo',periodos.value.trim())
    Usuarios.registarCalificacion(formData)
    .then(res => renderRespuesta(res,button))
    .catch(console.log);
}


function renderRespuesta(respuesta,button) {
    precarga.end();
    if(respuesta.ident) {
        new Notificacion(respuesta.mensaje,'Aceptar',false);
        button.setAttribute('disabled','');
        button.classList.add('desactivado');
        button.setAttribute('title','No puede volver a calificar una misma fuente de información.');
    }else {
        new Notificacion(respuesta.mensaje,'Regresar');
    }
}