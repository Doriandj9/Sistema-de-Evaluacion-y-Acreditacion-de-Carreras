import MenuOpcionesSuperior from "../../modulos/MenuOpcionesSuperior/MenuOpcionesSuperior.js";
import Precarga from "../../modulos/PreCarga/Precarga.js";
import alerta from "../../utiles/alertasBootstrap.js";
import Evidencias from "../../models/Evidencias.js";
import Usuarios from "../../models/Usuarios.js";
import { paginacionResponsables } from "../../utiles/paginacionResponsables.js";
import Notificacion from "../../modulos/Notificacion/Notificacion.js";
import Docentes from "../../models/Docentes.js";
import { paginacionEvaludoresCarrera } from "../../utiles/paginacionEvaludoresCarrera.js";

MenuOpcionesSuperior.correr();
const contenedorVistas = document.getElementById('cambio-vistas');
const [op1,op2,op3] = document.querySelectorAll('#contenedor-menu-superior li');
const htmlOp1 = document.getElementById('template-listar-responsables').innerHTML;
const htmlOp2 = document.getElementById('template-insertar-responsables').innerHTML;
const htmlOp3 = document.getElementById('template-insertar-evaluadores').innerHTML;


let precarga = null;
let spinner = document.createElement('div');
spinner.classList = 'spinner-border text-dark carga-medio';
spinner.setAttribute('role','status');
spinner.innerHTML = `<span class="visually-hidden">Loading...</span>`;


MenuOpcionesSuperior.renderVistasAcciones([
    [op1,htmlOp1,accionListar,'focus'],
    [op2,htmlOp2,accionRegistrar],
    [op3, htmlOp3,accionRegistrarEvaluadores]
]);

/**----------------------------------------------TODO: Listar Responsables------------------------------------------ */
function accionListar(){
    contenedorVistas.prepend(spinner);
    const select  = document.getElementById('periodos');
    select.addEventListener('change',() => {
        Usuarios.obtenerResponsables(select.value.trim())
        .then(renderResponsables)
        .catch(console.log)
    });
    Usuarios.obtenerResponsables(select.value.trim())
    .then(renderResponsables)
    .catch(console.log)
    perdirReporte();
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

function perdirReporte (){
    const select  = document.getElementById('periodos');
    reporte();
    function reporte(){
        const dir = document.getElementById('reporte-responsables');
        let hrefR = dir.dataset.dir;
        hrefR += '?periodo=' + select.value.trim();
        dir.href = hrefR;
    }
    select.addEventListener('change',reporte);
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
        <input type="hidden" value="${respo.id_criterio}" />
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
    const nombre_Evidencia = [...new Set(evidencia.nombre_evidencias.split('---'))];
    let html = `
    <div class="mb-3">
    <div class="row">
        <label for="staticEmail" class="col-sm-4 col-form-label">
           <strong> Evidencias a cargo </strong>
        </label>
        <div class="col-sm-8">
          ${nombre_Evidencia.toString()}
        </div>
    </div>
    <div id="evideciaHelp" class="form-text mb-3">Nota: Esta responsabilidad estará a cargo de subir estas evidencias</div>     
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
    const periodos = contenedorVistas.querySelector('#periodos');
    const fecha_inicial = contenedorVistas.querySelector('#f_i');
    const fecha_final = contenedorVistas.querySelector('#f_f');
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

        const childresn = periodos.children;
        const option = Array.from(childresn).filter(option => option.value === periodos.value);
        if(option.length <= 0) return;
        const fecha_inicial_periodo = option[0].dataset.fechaInicial.trim().split('-');
        const f_i = fecha_inicial.value.split('-');
        let date = new Date(`${f_i[1]}-${f_i[2]}-${f_i[0]}`);
        let datePeriodo = new Date(`${fecha_inicial_periodo[1]}-${fecha_inicial_periodo[2]}-${fecha_inicial_periodo[0]}`);
        if(bowser.name.includes('Firefox')){
           date = new Date(option[0].dataset.fechaInicial.trim().replace(/-/g,'/'));
           datePeriodo = new Date(`${fecha_inicial_periodo[0]}/${fecha_inicial_periodo[1]}/${fecha_inicial_periodo[2]}`);

        }
        if(!(date.getTime() >= datePeriodo.getTime())){
            alerta('alert-warning','El tiempo que ingreso debe ser mayor a la fecha inicial '+
            'del periodo academico ' + fecha_inicial_periodo.join('-'),5000);
            return;
        }
        if(fecha_final.value === ''){
            alerta('alert-warning', 'Ingrese un fecha limite que indique hasta que fecha se pueden ingresar las evidencia a cargo del docente',5000);
            return;
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
    select.value = 'none';
    contentResponsa.classList.remove('es-valido');
    ckeckeds.forEach(c => {
        c.checked = false;
    })

}


/**------------------------------------TODO: Actiones para registrar Evaludores--------------------------------- */


function accionRegistrarEvaluadores() {
    const inputID = document.getElementById('carreraID');
    Docentes.getDatos(inputID.value.trim())
    .then(renderDoncentes)
    .catch(console.log);
    registarEvaluadores();
    listarEvaludores();
}

function renderDoncentes(respuesta) {
    if(respuesta.ident){
        const select = contenedorVistas.querySelector('#docentes-evaluador');
        const {docentes} = respuesta;
        let htmlSelct = '<option selected value="none">Seleccione un docente presentado a continuación: </option>';
        docentes.forEach(docente => {
            htmlSelct += `
            <option value="${docente.id}">Nombre: ${docente.nombre.split(' ')[0] + docente.apellido.split(' ')[0]}
            ➡ CI: ${docente.id}
            </option>
            `;
        });
        select.innerHTML = htmlSelct;
    }else {
        alerta('alert-danger','A ocurrido un error en el servidor por favor informe de este error al admnistrador del sistema',5000);
    }
}


function registarEvaluadores() {
    const form =  contenedorVistas.querySelector('form');
    form.addEventListener('submit',e => verificarDatosEvaludor(e,form));
}

function verificarDatosEvaludor(e,form) {
    e.preventDefault();
    const select = form.querySelector('#docentes-evaluador');
    if(select.value.trim() === 'none') {
        select.classList.add('is-invalid');
        alerta('alert-warning','Asegurese de selecionar un docente para el cargo',5000);
        return;
    }else{
        select.classList.contains('is-invalid') ? select.classList.remove('is-invalid') : select.classList.add('is-valid');
    }
    precarga = new Precarga();
    precarga.run();
    Usuarios.registrarEvaluadores(new FormData(form))
    .then(renderRespuestaEvaludores)
    .catch(console.log);
}


function renderRespuestaEvaludores(respuesta) {
    precarga.end();
    if(respuesta.ident) {
        new Notificacion(respuesta.mensaje,'Aceptar',false);
        new Notificacion(
            Boolean(respuesta.identEmail) === true ? '' +  respuesta.email : 'Ocurrio un error al enviar el correo electronico <br>' 
            + respuesta.email,
            'Aceptar',
            Boolean(respuesta.identEmail) === true ? false : true
          );
          const form =  contenedorVistas.querySelector('form');
          const select = form.querySelector('#docentes-evaluador');
            select.classList.remove('is-valid');   
            select.value = 'none';

    }else {
        new Notificacion(respuesta.mensaje,'Regresar');
    }
}


function listarEvaludores() {
    Usuarios.listarEvaluadoresDeCarrera()
    .then(renderListaEvaludores)
    .catch(console.log)
}

function renderListaEvaludores(respuesta) {
    if(respuesta.ident) {
        const tbody = contenedorVistas.querySelector('tbody');
        const contenedorNumeros = contenedorVistas.querySelector('.contenedor-numeros-paginacion');
        const {evaluadores} = respuesta;
        paginacionEvaludoresCarrera(evaluadores,3,1,tbody,contenedorNumeros);
    }
}