import Usuarios from "../../models/Usuarios.js";
import Notificacion from "./../../modulos/Notificacion/Notificacion.js"
import Precarga from "./../../modulos/PreCarga/Precarga.js"
import { COREO_INST, CEDULA_REG_EXPRE } from "../../modulos/RegularExpresions/ConstExpres.js";
import alerta from "./../../utiles/alertasBootstrap.js";
import { paginacionDirectorPlaneacion } from "../../utiles/paginacionDirectoresPlaneacion.js";


let precarga = undefined;
let spinner = document.createElement('div');
spinner.classList = 'spinner-border text-primary carga-medio';
spinner.setAttribute('role','status');
spinner.innerHTML = `<span class="visually-hidden">Loading...</span>`;
document.body.append(spinner);
const table = document.getElementById('presentacion');
let verificacionesInputs = {inputsNoBlanco: false, cedula: false, correo: false};
const formulario = document.getElementById('form-director');
const cedulaInput = formulario.querySelector('#cedula');
const correo = formulario.querySelector('#correo');
/**---------------------Funcionalidad para listar y editar un director de planeacion---------------- */
/**
 * Esta funcion de llamado inmediato cargara los usuarios Directores de planeacion 
 */
 (function(){
    cargarDirectores();
})();

function cargarDirectores(){
   Usuarios.obtenerDirectoresPlaneacion()
   .then(renderDirectores)
}

function renderDirectores(respuesta) {
    spinner.remove();
    if(respuesta.ident) {
        const tbody = table.querySelector('tbody');
        const contenedorNumeros = document.querySelector('.contenedor-numeros-paginacion');
        const {directores} = respuesta;
        paginacionDirectorPlaneacion(directores,2,1,tbody,contenedorNumeros,scriptEditarDirector);
        scriptEditarDirector();
    }else {
        alerta(
            'alert-danger',
            '<strong>Error: </strong> En el servido al intentar cargar los usuarios directores de planeacion',
            5000
        );
    }
}
let enviarDatosEditar = false;

function scriptEditarDirector() {
    const tbody = table.querySelector('tbody');
    const buttonsEditar = tbody.querySelectorAll('button');
    buttonsEditar.forEach((buton,i) => {
        buton.addEventListener('click', (e) => {
            const dato = JSON.parse(buton.nextElementSibling.dataset.contenido);
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
                <h5 class="modal-title" id="exampleModalLabel">Datos del Director del Departamento de Planeación ${dato.nombre + dato.apellido.split(' ')[0]}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
        
              <div class="mb-3 row">
              <label for="staticEmail" class="col-sm-4 col-form-label">Nº Cédula</label>
              <div class="col-sm-8">
                <input type="hidden"  name="id" value="${dato.id_docentes}">
                <input type="text" disabled name="id_editado" class="form-control" id="staticEmail" value="${dato.id_docentes}">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="nombre" class="col-sm-4 col-form-label">Nombres del Director</label>
              <div class="col-sm-8">
                <input type="text" name="nombre" class="form-control" value="${dato.nombre}" id="nombre">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="apellido" class="col-sm-4 col-form-label">Apellidos del Director</label>
              <div class="col-sm-8">
                <input type="text" name="apellido" value="${dato.apellido}" class="form-control" id="apellido">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="correo" class="col-sm-4 col-form-label">Correo Electronico</label>
              <div class="col-sm-8">
                <input type="email" name="correo" value="${dato.correo}" class="form-control" id="correo">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="telefono" class="col-sm-4 col-form-label">Nº de Celular</label>
              <div class="col-sm-8">
                <input type="text" name="telefono" value="${dato.telefono}" class="form-control" id="telefono">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="f_inicial" class="col-sm-4 col-form-label">Fecha de Incio del Cargo</label>
              <div class="col-sm-8">
                <input type="date" name="f_inicial" value="${dato.fecha_inicial}" class="form-control" id="f_inicial">
              </div>
            </div>
            <div class="mb-3 row">
            <label for="f_final" class="col-sm-4 col-form-label">Fecha de Finalización</label>
            <div class="col-sm-8">
              <input type="date" name="f_final" value="${dato.fecha_final}" class="form-control" id="f_final">
            </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary text-white">Guardar Cambios</button>
              </div>
            
            </div>
          </div>
          </form>
            `;
        tbody.append(modal);
        const modalBootstrap =  new bootstrap.Modal(modal,{});
        const form = modal.querySelector('form');
        form.dispatchEvent(new CustomEvent('enviodatos',{detail:false}));
        modalBootstrap.show();
        modal.addEventListener('hidden.bs.modal',(e) => {
            modal.remove();
        })
        form.addEventListener('change',(e) => {
          form.dispatchEvent(new CustomEvent('enviodatos',{detail:true}));
        })
        form.addEventListener('enviodatos',(e) => {
            enviarDatosEditar = e.detail;
        })
        form.addEventListener('submit',(e) => editarDatos(e,modal,modalBootstrap,form));
        });
    })
}


/**
 * Esta funcion realiza la edicion de una carrera mediante el modal
 * que se presenta
 * 
 * @param {Event} e evento de submit
 * @param {HTMLDivElement} modalHtml el modal en htmlElement
 * @param {*} modalBootstrap una instancia del modal de bootstrap
 * @param {HTMLFormElement} formulario es el formulario con los datos para editar
 */
 function editarDatos(e,modalHtml,modalBootstrap,formulario) {
    e.preventDefault();
    if(enviarDatosEditar){
      let precargaInterna = new Precarga;
      modalBootstrap.hide();
      modalHtml.remove();
      Usuarios.actualizarDirectorPlaneacion(new FormData(formulario))
      .then((respuesta) => {
        if(respuesta.ident){
          alerta('alert-success',respuesta.mensaje,3000);
          cargarDirectores();
          precargaInterna.end();
        }else {
          precargaInterna.end();
          new Notificacion(respuesta.mensaje,'Regresar');
        }
      })
    }else {
      alerta('alert-danger','No ha realizado ningun cambio',3000);
    }
    enviarDatosEditar = false;
}
/**-------------------------- Funcionalidad para ingresar un Director de planeacion------------------- */
formulario.addEventListener('submit',enviarDatos);
cedulaInput.addEventListener('input', (e) => restricion(e,CEDULA_REG_EXPRE,cedulaInput.value));
correo.addEventListener('input',(e) => restricion(e,COREO_INST,correo.value));
cedulaInput.addEventListener('esvalido',(e) => {
    verificacionesInputs.cedula = e.detail;
});
correo.addEventListener('esvalido',(e) => {
    verificacionesInputs.correo = e.detail;
});

/**
 * @param {Event} e
 * @param {RegExp} restric
 * @param {string} value
 */

function restricion(e,restric,value){
    if(restric.test(value)){
        if(e.target.classList.contains('is-invalid')) e.target.classList.remove('is-invalid');
        e.target.classList.add('is-valid');
        e.target.dispatchEvent(new CustomEvent('esvalido',{detail:true}));
    }else{
        if(e.target.classList.contains('is-valid')) e.target.classList.remove('is-valid');
        e.target.classList.add('is-invalid');
        e.target.dispatchEvent(new CustomEvent('esvalido',{detail:false}));
    }
}

/**
 * 
 * @param {Event} e 
 */
function enviarDatos(e){
    e.preventDefault();
    if(verificaciones()){
        precarga = new Precarga();
        precarga.run();
        Usuarios.sendDirectorPlaneacion(new FormData(e.target))
        .then(renderRespuesta)
        .catch(e => console.log(e));
    }else{
        alerta('alert-warning','Corriga los campos marcados de <strong>rojo</strong>',3000);
    }
}

function verificaciones(){
    const inpts = formulario.querySelectorAll('input:not(.opcional)');

    inpts.forEach(input => {
        if(input.value === ''){
            if(input.classList.contains('is-valid')) input.classList.remove('is-valid');
            input.classList.add('is-invalid');
        }else{
            if(input.classList.contains('is-invalid')) input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        }
    });
    verificacionesInputs.inputsNoBlanco = Array.from(inpts).every(input => input.value !== '');

    return Object.values(verificacionesInputs).every(v => v === true);
}
/**
 * 
 * @param {JSON} respuesta 
 */
function renderRespuesta(respuesta) {
    if(respuesta.ident) {
        cargarDirectores();
        precarga.end();
        new Notificacion(respuesta.mensaje,'Aceptar',false);
        rebootInputs();
    }else{
      precarga.end();
        renderError(respuesta.mensaje);
    }
}

function renderError(mensaje){
    new Notificacion(mensaje,'Regresar');
}

function rebootInputs(){
    const inpts = formulario.querySelectorAll('input');
    inpts.forEach(input => {
            input.value = '';
            if(input.classList.contains('is-valid')) input.classList.remove('is-valid');
            if(input.classList.contains('is-invalid')) input.classList.remove('is-invalid');
    });
}