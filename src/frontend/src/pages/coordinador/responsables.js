import MenuOpcionesSuperior from "../../modulos/MenuOpcionesSuperior/MenuOpcionesSuperior.js";
import Precarga from "../../modulos/PreCarga/precarga.js";
import alerta from "../../utiles/alertasBootstrap.js";
import Evidencias from "../../models/Evidencias.js";
import { paginacionEvidencias } from "../../utiles/paginacionEvidencias.js";
import VisualizadorPDF from "../../modulos/VisualizadorPDF/VisualizadorPDF.js";
import Usuarios from "../../models/Usuarios.js";
import { paginacionResponsables } from "../../utiles/paginacionResponsables.js";


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
            paginacionResponsables(responsables,8,1,tbody,contenedorNumeros,null,'nombre_carrera',busqueda.value.trim());
            };
        })(responsables))
    }
}







/**----------------------------------------------TODO: Registrar Responsables----------------------------------------- */
function accionRegistrar(){
    listarResponsabilidades();
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
    let htmlSelct = '';
    docentes.forEach(docente => {
        htmlSelct = `
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
            <input class="form-check-input" type="checkbox" value="" id="">
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
    let html = `
    <div class="mb-3">
    <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-4 col-form-label">
            Criterios
        </label>
        <div class="col-sm-8">
           <li>${criterio.join('</li><li>')}</li>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-4 col-form-label">
            Elementos 
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