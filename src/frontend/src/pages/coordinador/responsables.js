import MenuOpcionesSuperior from "../../modulos/MenuOpcionesSuperior/MenuOpcionesSuperior.js";
import Precarga from "../../modulos/PreCarga/precarga.js";
import alerta from "../../utiles/alertasBootstrap.js";
import Evidencias from "../../models/Evidencias.js";
import { paginacionEvidencias } from "../../utiles/paginacionEvidencias.js";
import VisualizadorPDF from "../../modulos/VisualizadorPDF/VisualizadorPDF.js";
import Usuarios from "../../models/Usuarios.js";
import { paginacionResponsables } from "../../utiles/paginacionResponsables.js";
import Notificacion from "../../modulos/Notificacion/Notificacion.js";

MenuOpcionesSuperior.correr();
const contenedorVistas = document.getElementById('cambio-vistas');
const [op1,op2] = document.querySelectorAll('#contenedor-menu-superior li');
const htmlOp1 = document.getElementById('template-listar-responsables').innerHTML;
const htmlOp2 = document.getElementById('template-insertar-responsables').innerHTML;

let precarga = null;
let spinner = document.createElement('div');
spinner.classList = 'spinner-border text-dark carga-medio';
spinner.setAttribute('role','status');
spinner.innerHTML = `<span class="visually-hidden">Loading...</span>`;


MenuOpcionesSuperior.renderVistasAcciones([
    [op1,htmlOp1,accionListar,'focus'],
    [op2,htmlOp2,accionRegistrar]
]);

/**----------------------------------------------TODO: Listar Responsables------------------------------------------ */
function accionListar(){
    contenedorVistas.prepend(spinner);
    const select  = document.getElementById('periodos');
    Usuarios.obtenerResponsables(select.value.trim())
    .then(renderResponsables)
    .catch(console.log)
}

/**
 * 
 * @param {Object} respuesta 
 */
function renderResponsables(respuesta) {
    spinner.remove();
    if(respuesta.ident) {
        const tbody = contenedorVistas.querySelector('tbody');
        const contenedorNumeros = contenedorVistas.querySelector('.contenedor-numeros-paginacion');
        const busqueda = document.getElementById('busqueda');
        const {responsables} = respuesta;
        paginacionResponsables(responsables,8,1,tbody,contenedorNumeros);
        busqueda.addEventListener('input',(function(responsables){
            return () => {
            paginacionResponsables(responsables,8,1,tbody,contenedorNumeros,null,'nombre_docente',busqueda.value.trim());
            };
        })(responsables))
    }
}







/**----------------------------------------------TODO: Registrar Responsables----------------------------------------- */
function accionRegistrar(){
    listarResponsabilidades();
    verificarDatos();
}

function listarResponsabilidades(){
    Usuarios.obtenerResponsabilidades()
    .then(renderResponsabilidades)
    .catch(console.log)
}

function renderResponsabilidades(respuesta) {
    spinner.remove();
    if(respuesta.ident) {
       renderFormulario(respuesta);
    }
}

function renderFormulario(datos) {
    const select = contenedorVistas.querySelector('#docentes');
    const contentResponsa = contenedorVistas.querySelector('#responsabilidades');
    contentResponsa.innerHTML = '';
    const {docentes,responsabilidades} = datos;
    let htmlSelct = '<option selected value="none">Seleccione un docente presentado a continuación: </option>';
    docentes.forEach(docente => {
        htmlSelct += `
        <option value="${docente.id}">Nombre: ${docente.nombre.split(' ')[0] + docente.apellido.split(' ')[0]}
        ➡ CI: ${docente.id}
        </option>
        `;
    });
    select.innerHTML = htmlSelct;
    responsabilidades.forEach(respo => {
        const div = document.createElement('div');
        const detalle = document.createElement('div');
        detalle.className = 'tipografia-georgia-2 m-auto text-decoration-underline link-primary d-flex justify-content-center';
        detalle.style.cursor ='pointer';
        detalle.textContent = 'Ver detalle';
        div.className = 'form-check w-25 sombra p-2';
        div.innerHTML =`
        <div class="form-check">
            <label class="form-check-label" for="">
            ${respo.nombre}
            </label>
            <input class="form-check-input" name="responsabilidades[]" type="checkbox" value="${respo.id}" id="">
        </div>
        <input type="hidden" value="${respo.id_evidencias}" />
        `;
        div.append(detalle);
        contentResponsa.append(div);
        detalle.addEventListener('click',e => informacion(e,detalle));
    })

}
/**
 * 
 * @param {Event} e 
 * @param {HTMLElement} div 
 */
function informacion(e,div){
   const input = div.previousElementSibling;
   Evidencias.obtenerEvidenciaDetalle(input.value.trim())
   .then(evidencia => {
        document.dispatchEvent(new CustomEvent('deploy.evidencia',{detail:evidencia}));
   })
   .catch(console.log);
       const modal = document.createElement('div');
       modal.classList = 'modal fade';
       modal.id = `modalInformacion`;
       modal.setAttribute('tabindex','-1');
       modal.setAttribute('aria-labelledby','exampleModalLabel');
       modal.setAttribute('aria-hidden',true);
       modal.innerHTML = `
   <!-- Formulario -->
       <form>
       <div class="modal-dialog modal-lg">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">Información</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body" id="body-modal-e">

                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
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

document.addEventListener('deploy.evidencia',e => {
    const bodyModal = document.getElementById('body-modal-e');
    if(!e.detail.ident) alerta('alert-danger','Ocurrio un error intenlo mas tarde',3000);
    const {evidencia} = e.detail;
    const criterio = [...new Set(evidencia.nombre_criterio.split('---'))];
    const idElemento = [...new Set(evidencia.id_elemento.split('---'))];
    const descripcionElemento = [...new Set(evidencia.descripcion_elemento.split('---'))];
    const nombre_Evidencia = [...new Set(evidencia.nombre_evidencias.split('---'))];
    let html = `
    <div class="mb-3">
    <div class="row">
        <label for="staticEmail" class="col-sm-4 col-form-label">
           <strong> Evidencia a cargo </strong>
        </label>
        <div class="col-sm-8">
          ${nombre_Evidencia.toString()}
        </div>
    </div>
    <div id="emailHelp" class="form-text mb-3">Nota: Esta responsabilidad estará a cargo de subir esta evidencia</div>
    <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-4 col-form-label">
           <strong> Criterios </strong>
        </label>
        <div class="col-sm-8">
           <li>${criterio.join('</li><li>')}</li>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-4 col-form-label">
           <strong> Elementos  </strong>
        </label>
        <div class="col-sm-8">
            <strong>Nº Elementos:</strong> ${idElemento.toString()} <br>
            <li>${descripcionElemento.join('</li><li>')}</li>
        </div>
    </div>
    </div>
    `;
    bodyModal.innerHTML = html;
})


function verificarDatos() {
    const form =  contenedorVistas.querySelector('form');
    form.addEventListener('submit',verificarOpciones);
}
let verificarciones = {select:false,checked:false};
/**
 * 
 * @param {Event} e 
 */
function verificarOpciones(e) {
    e.preventDefault();
    const form = e.target;
    const select = form.querySelector('#docentes');
    const contentResponsa = form.querySelector('#responsabilidades')
    const ckeckeds = Array.from(form.querySelectorAll('input[type=checkbox]'));
    if(select.value.trim() === 'none') {
        select.classList.add('is-invalid');
        verificarciones.select = false; 

    }else{
        select.classList.contains('is-invalid') ? select.classList.remove('is-invalid') : select.classList.add('is-valid');
        verificarciones.select = true; 
    }

    if(ckeckeds.every(ch => ch.checked === false)){
        contentResponsa.classList.add('no-valido');
        verificarciones.select = false; 

    }else{
        contentResponsa.classList.contains('no-valido') ? contentResponsa.classList.remove('no-valido') : contentResponsa.classList.add('es-valido'); 
        verificarciones.checked = true;
    }
    
    if(!Object.values(verificarciones).every(v => v)){
        alerta('alert-warning','Por favor resive que todos los campos se encuentren completados',2000);
        return;
    }
    enviarDatos(form);
}
/**
 * 
 * @param {HTMLFormElement} form 
 */
function enviarDatos(form) {
    precarga = new Precarga();
    precarga.run()
    Usuarios.registrarResponsables(new FormData(form))
    .then(renderRespuesta)
    .catch(console.log)
}


function renderRespuesta(respuesta) {
    precarga.end();
    if(respuesta.ident == 1 || respuesta.ident == 2) {
        new Notificacion(respuesta.mensaje,'Aceptar',false);
        if(respuesta.identEmail == 1){
            new Notificacion(respuesta.email,'Aceptar',false);
        }else if (respuesta.identEmail == 0){
            new Notificacion('Ocurrio un error al enviar el correo electronico <br>' 
            + respuesta.email,'Regresar');
        }

        reiniciarDatosForm();
    }else{
        new Notificacion(respuesta.errores.toString(),'Regresar');
    }
}


function reiniciarDatosForm(){
    const form =  contenedorVistas.querySelector('form');
    const select = form.querySelector('#docentes');
    const ckeckeds = Array.from(form.querySelectorAll('input[type=checkbox]'));
    const contentResponsa = form.querySelector('#responsabilidades')
    select.classList.remove('is-valid');    
    contentResponsa.classList.remove('es-valido');
    ckeckeds.forEach(c => {
        c.checked = false;
    })

}