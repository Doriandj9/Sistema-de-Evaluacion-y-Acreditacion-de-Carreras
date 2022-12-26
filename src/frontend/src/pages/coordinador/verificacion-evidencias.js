import Evidencias from "../../models/Evidencias.js";
import { paginacionEvidenciasVerificacion } from "../../utiles/paginacionEvidenciasVerificar.js";
import VisualizadorPDF from "../../modulos/VisualizadorPDF/VisualizadorPDF.js";
import alerta from "../../utiles/alertasBootstrap.js";
import Docentes from "../../models/Docentes.js";
import Precarga from "../../modulos/PreCarga/Precarga.js";
import Notificacion from "../../modulos/Notificacion/Notificacion.js";


let precarga = null;
const periodo = document.getElementById('periodos');
periodo.addEventListener('change', (e) => {
    listarEvidencias(periodo.value.trim());
})
listarEvidencias(periodo.value.trim());


function listarEvidencias(periodo) {
    Evidencias.obtenerEvidenciasVerificar(periodo)
    .then(renderEvidencias)
    .catch(console.log);
}

function renderEvidencias(respuesta) {
    if(respuesta.ident){
        const tbody = document.body.querySelector('tbody');
        const contenedorNumeros = document.body.querySelector('.contenedor-numeros-paginacion');
        const busqueda = document.getElementById('busqueda');
        const {evidencias} = respuesta;
        paginacionEvidenciasVerificacion(evidencias,3,1,tbody,contenedorNumeros);
        busqueda.addEventListener('input',() => {
            paginacionEvidenciasVerificacion(evidencias,3,1,tbody,contenedorNumeros,null,null,'nombre_evidencia',busqueda.value.trim());
        })
      }else{
        spinner.remove();
        alerta('alert-danger','Error del servidor',3000);
      }
}

document.addEventListener('display.modal.verf', e => {
   const modal = e.detail;
   const form = modal.querySelector('form');
   const id_evidencias = form.querySelector('#id-evidencias')?.value;
   form.addEventListener('submit',guardarDatos);
   traerDocumento(id_evidencias);
})
document.addEventListener('display.modal.noti',(e) => {
    const [modal,modalBootstrap] = e.detail;
    const form = modal.querySelector('form');
    const textarea = modal.querySelector('#comentario-e');
    form.addEventListener('submit',(e) => {
        e.preventDefault();
        const opciones = form.querySelectorAll('input[type=radio]:checked');
        if(opciones.length <= 0 ){
            alerta('alert-danger','Por favor, indique si el docente puede volver a subir el documento de información o no es necesario.',5000);
            return;
        }
        if(textarea.value.trim() === ''){
            new Notificacion(`La fuente de información no contiene una observación,
            se enviara al docente el siguiente mensaje: Sin obsevaciones. <br> 
            Si esta de acuerdo, vuelva a enviar los datos.`,'Aceptar',false);
            textarea.textContent = 'Sin obsevaciones.';
            return;
        }
        modalBootstrap.hide();
       enviarDatos(form);
    }) 
})
function traerDocumento(id){
    Evidencias.obtenerEvidenciaIndvidual(periodo.value.trim(),id,'coordinador')
    .then(guardarBlobs)
    .catch(console.log)
}

function guardarDatos(e) {
    e.preventDefault();
const form = e.target;
    verificarDatos(form);
}

function verificarDatos(form) {
    const casillaVerif = form.querySelector('#verificacion');
    const inputsRadio = form.querySelectorAll('input[type="radio"]:checked');
    const modal = form.parentElement;
    const bacdrop = document.querySelectorAll('.modal-backdrop.fade.show');
    if(!casillaVerif.checked){
        alerta('alert-warning','Por favor selecione la casilla de Verificar para continuar',3500);
        return;
    }
    if(inputsRadio.length <= 0){
        alerta('alert-warning','Debe selecionar una valoración para continuar');
        return;
    }
    if(window.confirm('Por favor confirme la acción.')){
        bacdrop.forEach(b => b.remove());
        modal.remove();
       enviarDatos(form);
    }else {
        return;
    }
}


function guardarBlobs(blobs) {
    document.dispatchEvent(new CustomEvent('archivos.deplegados',{detail:blobs}));
}

document.addEventListener('archivos.deplegados',e => {
    const blobs = e.detail;
    const modal = document.getElementById('presentacionViews');
    const img = modal.querySelector('img');
    const beforeSpinner = img.previousElementSibling;
    beforeSpinner.remove();
    img.addEventListener('click',e => viewFile(e,blobs));
})

/**
 * 
 * @param {Event} e 
 * @param {Array} blobs 
 */
 function viewFile(e,blobs){
    const type = e.target.id;
    const refblob = {'pdf': blobs[0]}
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
 * @param {HTMLElement} form 
 */
function enviarDatos(form) {
    const formData = new FormData(form);
    formData.append('periodo',periodo.value.trim());
    precarga = new Precarga();
    precarga.run();
    Docentes.sendVerificacionEvidencia(formData)
    .then(renderRespuesta)
    .catch(console.log);
}

function renderRespuesta(respuesta) {
    precarga.end();
    if(respuesta.ident) {
        new Notificacion(respuesta.mensaje,'Aceptar',false);
    }else{
        new Notificacion(respuesta.mensaje,'Regresar');
    }
}