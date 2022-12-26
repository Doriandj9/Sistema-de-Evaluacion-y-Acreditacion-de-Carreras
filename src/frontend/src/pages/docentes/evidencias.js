import MenuOpcionesSuperior from "../../modulos/MenuOpcionesSuperior/MenuOpcionesSuperior.js";
import alerta from "../../utiles/alertasBootstrap.js";
import Evidencias from "../../models/Evidencias.js";
import { paginacionEvidencias } from "../../utiles/paginacionEvidencias.js";
import VisualizadorPDF from "../../modulos/VisualizadorPDF/VisualizadorPDF.js";
import Precarga from "../../modulos/PreCarga/Precarga.js";
import Notificacion from "./../../modulos/Notificacion/Notificacion.js"


MenuOpcionesSuperior.correr();
const contenedorVistas = document.getElementById('cambio-vistas');
const [op1,op2] = document.querySelectorAll('#contenedor-menu-superior li');
const htmlOp1 = document.getElementById('template-listar-evidencias').innerHTML;
const htmlOp2 = htmlOp1;

let precarga = null;
let spinner = document.createElement('div');
spinner.classList = 'spinner-border text-dark carga-medio';
spinner.setAttribute('role','status');
spinner.innerHTML = `<span class="visually-hidden">Loading...</span>`;


MenuOpcionesSuperior.renderVistasAcciones([
    [op1,htmlOp1,accionListar,'focus'],
    [op2,htmlOp2,accionRegistrar]
]);

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
    Evidencias.obtenerEvidenciasResposabilidades(periodo)
    .then(r => renderEvidencias(r,'ver'))
    .catch(console.log)
}


function renderEvidencias(respuesta,opcion) {
    if(respuesta.ident){
        const tbody = contenedorVistas.querySelector('tbody');
        const contenedorNumeros = contenedorVistas.querySelector('.contenedor-numeros-paginacion');
        const busqueda = document.getElementById('busqueda');
        const {evidencias} = respuesta;
        
        paginacionEvidencias(evidencias,2,1,tbody,contenedorNumeros,opcion,opcion === 'ver' ? mostrarEvidencias: mostrarFormSubirArchivo,'nombre_evidencias',busqueda.value.trim());
        busqueda.addEventListener('input',(function(evidencias){
            return () => {
            paginacionEvidencias(evidencias,2,1,tbody,contenedorNumeros,opcion,opcion === 'ver' ? mostrarEvidencias: mostrarFormSubirArchivo,'nombre_evidencias',busqueda.value.trim());
            };
        })(evidencias))
        opcion === 'ver' ? mostrarEvidencias(): mostrarFormSubirArchivo();
      }else{
        spinner.remove();
        alerta('alert-danger','Error del servidor',3000);
      }

}

function mostrarEvidencias(){
    const tbody = contenedorVistas.querySelector('tbody');
    const buttons = tbody.querySelectorAll('section');
    const select = document.querySelector('#periodos');
    const periodo = select === null ? localStorage.periodo.trim() : select.value.trim();
    buttons.forEach(button => {
        button.addEventListener('click',e => traerEvidencias(button,periodo));
    })
}
/**
 * 
 * @param {HTMLElement} e 
 */
function traerEvidencias(e,periodo) {
    const input = e.nextElementSibling;
    Evidencias.obtenerEvidenciaIndvidual(periodo,input.value,'docente')
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
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Visualizar o Descargar los Documentos de Información(Evidencias)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <h4 for="staticEmail" class="col-form-label">Visualice el documento en PDF</h4>
                <div class="col-sm-10">
                <label class="position-relative" for="pdf">
                <div class="spinner-border text-dark carga-medio" role="status"><span class="visually-hidden">Loading...</span></div>
                <img class="selector" height="40" id="pdf"  src="/public/assets/img/icons8-pdf-50.png" alt="imagen pdf" />
                </label>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
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


    /**------------------------------------------ Sript de la Segunda Opcion Registrar Evidencia-------------------------------------- */





    function accionRegistrar() {
    listarEvidenciasRegistro();
}

function listarEvidenciasRegistro() {
    const select = document.getElementById('periodos');
    Evidencias.obtenerEvidenciasResposabilidades(select.value.trim())
    .then(res => renderEvidencias(res,'registro'))
    .catch(console.log);

    select.addEventListener('change',() => listarEvidenciasRegistro());
}

function mostrarFormSubirArchivo() {
    const tbody = contenedorVistas.querySelector('tbody');
    const buttons = tbody.querySelectorAll('button');
    buttons.forEach((button,i) => {
    button.addEventListener('click', (e) => {
        const modal = document.createElement('div');
        modal.classList = 'modal fade';
        modal.id = `modalCarrera${i}`;
        modal.setAttribute('tabindex','-1');
        modal.setAttribute('aria-labelledby','exampleModalLabel');
        modal.setAttribute('aria-hidden',true);
        modal.innerHTML = `
    <!-- Formulario -->
        <form>
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Registro de Documentos de Información(Evidencias)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <div class="mb-3">
          <h4>Consideraciones.</h4>
          <ul  class="list-circle">
              <li>Puede arrastrar el archivo dentro del recuadro azul.</li>
              <li>También puede seleccionar un archivo del sistema dando un clic en la imagen pdf.</li>
              <li>Asegúrese de ingresar solo documentos válidos y en formato PDF.</li>
          </ul>
          </div>
            <div class="mb-3 row">
                <div class="drag" id="drag">
                    <span class="texto-transparente">Arrastre los documentos Aquí</span>
                </div>
            </div>
            <div class="mb-3">
                <h4 for="staticEmail" class="col-form-label">Haz clic en la imagen pdf esto te permitirá buscar el archivo en tu computadora y subirlo a la plataforma. </h4>
                <div class="col-sm-10">
                <label for="pdf"><img class="selector" height="40"  src="/public/assets/img/icons8-pdf-50.png" alt="imagen pdf" /></label>
                <input type="file" accept=".pdf" id="pdf" class="hidden">
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
      </form>
        `;
    tbody.append(modal);
    const modalBootstrap =  new bootstrap.Modal(modal,{});
    const form = modal.querySelector('form');
    modalBootstrap.show();
    modal.addEventListener('hidden.bs.modal',(e) => {
        modal.remove();
    })
    let fila = button.parentElement.parentElement;
    activarDrop(button,modal,modalBootstrap,fila);
    const inputs = form.querySelectorAll('input[type="file"]');
    inputs.forEach((inp) => {
        inp.onchange = (e) => {
            opcionEviar(e,button,modal,modalBootstrap,fila);
        }
    })
    });
});
}

/**
 * 
 * @param {Event} e 
 * @param {HTMLFormElement} button 
 */
function opcionEviar(e,buttonEvent,modal,modalBootstrap,fila){
    const id_evidencia = buttonEvent.nextElementSibling;
    const file = e.target.files[0];
    const formData = new FormData();
    formData.append('file',file);
    const pre =e.target.previousElementSibling;
    const select = document.getElementById('periodos');
    formData.append('periodo',select.value.trim());
    formData.append('cod_evidencia',id_evidencia.value.trim());
    subirEvidencia(formData,pre,modal,modalBootstrap,fila);
}

function subirEvidencia(formData,obje,modal,modalBootstrap,fila) {
    const modalContent = modal.querySelector('.modal-body');
    const confirmacionHML = confirmHTML(formData.get('file'));
    modalContent.append(confirmacionHML);
    const enviaButon = confirmacionHML.querySelector('#save-pdf');
    const verPDf = confirmacionHML.querySelector('#ver');
    
    enviaButon.addEventListener('click', e => {
        e.preventDefault();
        e.stopPropagation();
        confirmacionHML.remove();
        modalBootstrap.hide();
        precarga = new Precarga();
        precarga.run();
        Evidencias.subirEvidenciasDocente(formData)
        .then(res => renderRespuesta(res,modalBootstrap,fila))
        .catch(console.log)
    })
    verPDf.addEventListener('click', e => {
        const view = new VisualizadorPDF();
        view.habilitarESC();
        view.mostrar(formData.get('file'));
    })
}
function renderRespuesta(respuesta,modalBootstrap,fila) {
    precarga.end();
    if(respuesta.ident){
        const almace = fila.querySelector('#estado').querySelector('span');
        almace.innerHTML = '<strong>Almacenado: SI </strong> ';
        new Notificacion(respuesta.mensaje,'Aceptar',false);
    }else{
        alerta('alert-danger',respuesta.mensaje,10000);
        modalBootstrap.show();
    }
}
function activarDrop(button,modal,modalBootstrap,fila) {
    const id_evidencia = button.nextElementSibling;
    const drop = document.getElementById('drag');
        drop.addEventListener('dragenter',e => {
            e.preventDefault();
            e.target.classList.add('drag-active');
        })
        drop.addEventListener('dragleave',e => {
            e.preventDefault();
            e.target.classList.remove('drag-active')
        })
        // quita el efecto del navegador para arrastrar archivos
        drop.addEventListener('dragover',e =>{
            e.preventDefault();
        })
        drop.addEventListener('drop' , e => {
            e.preventDefault();
            e.target.classList.remove('drag-active');
            const file = e.dataTransfer.files[0];
            dropArchivos(file,e.target,id_evidencia.value,modal,modalBootstrap,fila);
        })
}

function dropArchivos(file,target,id_evidencia,modal,modalBootstrap,fila) {
    if(file.type === 'application/pdf') {
        const select = document.getElementById('periodos');
        const formData = new FormData();
        formData.append('file',file);
        formData.append('cod_evidencia',id_evidencia);
        formData.append('periodo',select.value.trim());
        subirEvidencia(formData,target,modal,modalBootstrap,fila);
    }else{
        alerta('alert-danger','No se permite subir otro tipo de archivo que no sea pdf.',5000);
    }
}

function confirmHTML(file){
    const div = document.createElement('div');
    div.className = 'confirmacion-envio-evidencias';
    const html = `
    <h5>Por favor, confirmar la subida del archivo a la plataforma.</h5>
    <div class="mb-3 contenedor-x75">
        <label for="" class="form-label text-center">
            <strong>Nombre del documento</strong>
        </label>
        <input class="form-control" type="text" disabled value="${file.name}">
    </div>
    <div class="mb-3">
       <span style="cursor: pointer;" id="ver" class="text-decoration-underline text-primary"> Visualizar </span>
    </div>
    <div class="mb-3">
        <button type="button" class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
        id="save-pdf">
        <span class="material-icons text-white">&#xe161;</span> Guardar
        </button>
      </div>
    `;
    div.innerHTML = html;
    return div;
}