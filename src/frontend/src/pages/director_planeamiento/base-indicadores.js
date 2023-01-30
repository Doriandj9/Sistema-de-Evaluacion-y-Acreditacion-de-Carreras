import Precarga from "./../../modulos/PreCarga/Precarga.js";
import MenuOpcionesSuperior from "../../modulos/MenuOpcionesSuperior/MenuOpcionesSuperior.js";
import alerta from "../../utiles/alertasBootstrap.js";
import Notificacion from "../../modulos/Notificacion/Notificacion.js";
import BaseIndicadores from "../../models/BaseIndicadores.js";
import { paginacionCriterios,paginacionEstandares,paginacionElementosFundamentals,paginacionComponentes,paginacionEvidencias } from "../../utiles/paginacionCriterios.js";

(function(){
    MenuOpcionesSuperior.correr();
})();
let carga = null;
let precarga = document.createElement('div');
precarga.classList = 'spinner-border text-primary carga-medio';
precarga.setAttribute('role','status');
precarga.innerHTML = `<span class="visually-hidden">Loading...</span>`;
document.body.append(precarga);

const contenedorVistas = document.getElementById('cambio-vistas');
const [op1,op2,op3,op4,op5] = document.querySelectorAll('#contenedor-menu-superior li');
const htmlOp1 = document.getElementById('template-criterios').innerHTML;
const htmlOp2 = document.getElementById('template-estandares').innerHTML;
const htmlOp3 = document.getElementById('template-elementos-fundamentales').innerHTML;
const htmlOp4 = document.getElementById('template-componentes').innerHTML;
const htmlOp5 = document.getElementById('template-evidencias').innerHTML;

MenuOpcionesSuperior.renderVistasAcciones([
  [op1,htmlOp1,accionCriterios,'focus'],
  [op2,htmlOp2,accionEstandares],
  [op3,htmlOp3,accionElementos],
  [op4,htmlOp4,accionComponentes],
  [op5,htmlOp5,accionEvidencias]
]);

/**----------------------------- TODO: Script para la primera opcion Criterios---------------------------- */

function accionCriterios() {
    precarga.remove();
    listarCriterios();
    ingresarCriterio();
}

function listarCriterios() {
    BaseIndicadores.obtenerCriterios()
    .then(renderCriterios)
    .catch(console.log)
}

function renderCriterios(respuesta) {
    if(respuesta.ident){
        const tbody = contenedorVistas.querySelector('tbody');
        const contenedorNumeros = contenedorVistas.querySelector('.contenedor-numeros-paginacion');
        const {criterios} = respuesta;
        paginacionCriterios(criterios,5,1,tbody,contenedorNumeros,accionRefrescarCriterios);
        accionRefrescarCriterios();
      }else{
        spinner.remove();
        alerta('alert-danger','Error del servidor',3000);
      }
}

function accionRefrescarCriterios() {
    const tbody = contenedorVistas.querySelector('tbody');
    const buttons = tbody.querySelectorAll('button');
    buttons.forEach(button => {
        const modal = document.createElement('div');
        button.addEventListener('click', (e) => {
            const datos  = JSON.parse(button.dataset.datos);
            modal.classList = 'modal fade';
            modal.id = `modalCarrera`;
            modal.setAttribute('tabindex','-1');
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
        <!-- Formulario -->
            <form>
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar la información del criterio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              <div class="mb-3">
              <h4>Consideraciones.</h4>
              <ul  class="list-circle">
                  <li>Puede editar la información como el identificador y el nombre del criterio, 
                  puede guardar los cambio dando un click en la opcion Guardar Cambios</li>
              </ul>
              </div>
              <div class="mb-3 row">
              <label for="staticEmail" class="col-sm-2 col-form-label">Identificador</label>
              <div class="col-sm-10">
                <input type="hidden" name="id" value="${datos.id}">
                <input type="text" name="id_editado" class="form-control" id="staticEmail" value="${datos.id}">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="nombre" class="col-sm-2 col-form-label">Nombre del criterio</label>
              <div class="col-sm-10">
                <input type="text" name="nombre" class="form-control" value="${datos.nombre}" id="nombre">
              </div>
            </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary text-white">Guardar Cambios</button>
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

        form.addEventListener('submit',e =>  editarDatos(e,modalBootstrap));

        });  
    })
}

function editarDatos(e,modalBootstrap) {
    e.preventDefault();
    carga = new Precarga();
    const form = e.target;
    modalBootstrap.hide();
    carga.run();
    BaseIndicadores.editarCriterios(new FormData(form))
    .then(renderEditCriterios)
    .catch(console.log)
}

function renderEditCriterios(respuesta){
    carga.end();
    if(respuesta.ident){
        new Notificacion(respuesta.mensaje,'Aceptar',false);
        listarCriterios();
    }else {
        new Notificacion(respuesta.mensaje,'Regresar');
    }
}

function ingresarCriterio() {
    const button = contenedorVistas.querySelector('#ingreso-criterio');
    const modal = document.createElement('div');
    button.addEventListener('click',() => {
            modal.classList = 'modal fade';
            modal.id = `modalCarrera`;
            modal.setAttribute('tabindex','-1');
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
        <!-- Formulario -->
            <form>
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingresar la información del criterio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              <div class="mb-3">
              <h4>Consideraciones.</h4>
              <ul  class="list-circle">
                  <li>Puede ingresar un nuevo criterio, ingresando el identificador que debe ser un numero
                  y el nombre del criterio, puede guardar el criterio dando en click en la opcion guardar.</li>
                  <li>Recuerde que no se puede eliminar un criterio ya que se encuentra ligado a estandares,elementos fundamentales
                  etc.</li>
              </ul>
              </div>
              <div class="mb-3 row">
              <label for="id" class="col-sm-4 col-form-label">Identificador del criterio</label>
              <div class="col-sm-8">
                <input type="text" name="id" class="form-control" id="id" >
              </div>
            </div>
            <div class="mb-3 row">
              <label for="nombre" class="col-sm-4 col-form-label">Nombre del criterio</label>
              <div class="col-sm-8">
                <input type="text" name="nombre" class="form-control"  id="nombre">
              </div>
            </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary text-white">Guardar</button>
              </div>
            </div>
          </div>
          </form>
            `;
        document.body.append(modal);
        const modalBootstrap =  new bootstrap.Modal(modal,{});
        const form = modal.querySelector('form');
        modalBootstrap.show();
        modal.addEventListener('hidden.bs.modal',(e) => {
            modal.remove();
        })

        form.addEventListener('submit',e => enviarDatos(e,modalBootstrap));
    })
}

function enviarDatos(e,modalBootstrap) {
    e.preventDefault();
    const form = e.target;
    const inputs = Array.from(form.querySelectorAll('input[type=text]'));
    if(inputs.some(inp => inp.value === '')){
        alerta('alert-warning','Por favor ingreso todos los campos para continuar',4000);
        return;
    }
    modalBootstrap.hide();
    carga = new Precarga();
    carga.run();
    BaseIndicadores.insertarCriterios(new FormData(form))
    .then(renderInsertCriterios)
    .catch(console.log)

}
function renderInsertCriterios(respuesta){
    carga.end();
    if(respuesta.ident){
        new Notificacion(respuesta.mensaje,'Aceptar',false);
        listarCriterios();
    }else {
        new Notificacion(respuesta.mensaje,'Regresar');
    }
}

/*------------------------------TODO: segunda opcion de estandares------------------------------ */

function accionEstandares() {
    listarEstandares();
    ingresarEstandar();
}

function listarEstandares() {
    BaseIndicadores.obtnerEstandares()
    .then(renderEstandares)
    .catch(console.log)
}

function renderEstandares(respuesta){
    if(respuesta.ident) {
        if(respuesta.ident){
            const tbody = contenedorVistas.querySelector('tbody');
            const contenedorNumeros = contenedorVistas.querySelector('.contenedor-numeros-paginacion');
            const {estandares} = respuesta;
            paginacionEstandares(estandares,10,1,tbody,contenedorNumeros,accionRefrescarEstandares);
            accionRefrescarEstandares()
          }else{
            spinner.remove();
            alerta('alert-danger','Error del servidor',3000);
          }
    }
}


function accionRefrescarEstandares() {
    const tbody = contenedorVistas.querySelector('tbody');
    const buttons = tbody.querySelectorAll('button');
    buttons.forEach(button => {
        const modal = document.createElement('div');
        button.addEventListener('click', (e) => {
            const datos  = JSON.parse(button.dataset.datos);
            modal.classList = 'modal fade';
            modal.id = `modalCarrera`;
            modal.setAttribute('tabindex','-1');
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
        <!-- Formulario -->
            <form>
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar la información del estándar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              <div class="mb-3">
              <h4>Consideraciones.</h4>
              <ul  class="list-circle">
                  <li>Puede editar la información como el identificador, el nombre, el tipo y la descripción del estándar, 
                  puede guardar los cambio dando un click en la opcion Guardar Cambios</li>
                  <li>Recuerde que el tipo de estándar debe ser <strong> CUALITATIVO o CUANTITATIVO</strong>.</li>
              </ul>
              </div>
              <div class="mb-3 row">
              <label for="staticEmail" class="col-sm-4 col-form-label">Identificador</label>
              <div class="col-sm-8">
                <input type="hidden" name="id" value="${datos.id_estandar}">
                <input type="text" name="id_editado" class="form-control" id="staticEmail" value="${datos.id_estandar}">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="nombre" class="col-sm-4 col-form-label">Nombre del indicador</label>
              <div class="col-sm-8">
                <input type="text" name="nombre" class="form-control" value="${datos.nombre_indicador}">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="descripcion" class="col-sm-4 col-form-label">Descripción del estándar</label>
              <div class="col-sm-8">
                <textarea name="descripcion" class="form-control">${datos.descripcion}</textarea>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="tipo" class="col-sm-4 col-form-label">Tipo de estándar</label>
              <div class="col-sm-8">
                <input type="text" name="tipo" class="form-control" value="${datos.tipo}">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="criterio" class="col-sm-4 col-form-label">Nombre del criterio al que pertenece</label>
              <div class="col-sm-8">
                <input type="text" disabled name="criterio" class="form-control" value="${datos.nombre_criterio}">
              </div>
            </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary text-white">Guardar Cambios</button>
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

        form.addEventListener('submit',e =>  editarDatosEstandares(e,modalBootstrap));

        });  
    })
}


function editarDatosEstandares(e,modalBootstrap) {
    e.preventDefault();
    carga = new Precarga();
    const form = e.target;
    modalBootstrap.hide();
    carga.run();
    BaseIndicadores.editarEstandares(new FormData(form))
    .then(renderEstandaresEdit)
    .catch(console.log)
}

function renderEstandaresEdit(respuesta){
    carga.end();
    if(respuesta.ident){
        new Notificacion(respuesta.mensaje,'Aceptar',false);
        listarEstandares();
    }else {
        new Notificacion(respuesta.mensaje,'Regresar');
    }
}
function ingresarEstandar() {
  
    const button = contenedorVistas.querySelector('#ingreso-estandar');
    const modal = document.createElement('div');
    button.addEventListener('click',() => {
            modal.classList = 'modal fade';
            modal.id = `modalCarrera`;
            modal.setAttribute('tabindex','-1');
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
        <!-- Formulario -->
            <form>
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar un nuevo estándar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              <div class="mb-3">
              <h4>Consideraciones.</h4>
              <ul  class="list-circle">
                  <li>Recuerde seleccionar correctamente de qué tipo es el estándar cuantitativo o cualitativo, además de
                  a qué criterio pertenece.</li>
              </ul>
              </div>
              <div class="mb-3 row">
              <label for="staticEmail" class="col-sm-4 col-form-label">Ingrese el identificador</label>
              <div class="col-sm-8">
                <input type="text" placeholder="Ingrese un numero..." name="id" class="form-control">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="nombre" class="col-sm-4 col-form-label">Ingrese el nombre del indicador</label>
              <div class="col-sm-8">
                <input type="text" placeholder="Ingrese el nombre..." name="nombre" class="form-control">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="descripcion" class="col-sm-4 col-form-label">Ingrese la descripción del estándar</label>
              <div class="col-sm-8">
                <textarea name="descripcion" class="form-control" placeholder="Aa"></textarea>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="tipo" class="col-sm-4 col-form-label">Seleccione el tipo de estándar</label>
              <div class="col-sm-8">
                <select class="form-select" name="tipo">
                  <option value="CUALITATIVO">CUALITATIVO</option>
                  <option value="CUANTITATIVO">CUANTITATIVO</option>
                </select>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="criterio" class="col-sm-4 col-form-label">Seleccione el criterio al que pertenece</label>
              <div class="col-sm-8">
                <select class="form-select" name="criterio" id="select-criterios">
                <option >Cargando...</option>
                </select>
              </div>
            </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary text-white">Guardar</button>
              </div>
            </div>
          </div>
          </form>
            `;
        document.body.append(modal);
        const modalBootstrap =  new bootstrap.Modal(modal,{});
        const form = modal.querySelector('form');
        modalBootstrap.show();
        modal.addEventListener('hidden.bs.modal',(e) => {
            modal.remove();
        })
        BaseIndicadores.obtenerCriterios()
        .then(respuesta => {
          const select = modal.querySelector('#select-criterios');
          let html= '';
          respuesta.criterios.forEach(cr => {
              html += `<option value="${cr.id}">${cr.nombre}</option>`;
          })
    
          select.innerHTML = html;
        })
        .catch(console.log)
        form.addEventListener('submit',e => enviarDatosEstandar(e,modalBootstrap));
    })
}

function enviarDatosEstandar(e,modalBootstrap) {
  e.preventDefault();
  const form = e.target;
  const inputs = Array.from(form.querySelectorAll('input'));
  //compramos que todo este ingresado

  if(inputs.some(inp => inp === '')){
    alerta('alert-warning','Por favor, rellene todos los campos para continuar.',3500);
    return;
  }

  modalBootstrap.hide();
  carga = new Precarga();
  carga.run();

  BaseIndicadores.insertarEstandares(new FormData(form))
  .then(renderRespuesEstandares)
  .catch(console.log)
}

function renderRespuesEstandares(respuesta) {
  carga.end();
    if(respuesta.ident){
        new Notificacion(respuesta.mensaje,'Aceptar',false);
        listarEstandares();
    }else {
        new Notificacion(respuesta.mensaje,'Regresar');
    }
}

/**--------------------------------TODO: Tercera opcion de elementos fundamentales -------------------------------- */


function accionElementos() {
  listarElementos();
  ingresarElemento();
}

function listarElementos() {
  BaseIndicadores.obtnerElementos()
  .then(renderElementos)
  .catch(console.log)
}

function renderElementos(respuesta){
  if(respuesta.ident) {
      if(respuesta.ident){
          const tbody = contenedorVistas.querySelector('tbody');
          const contenedorNumeros = contenedorVistas.querySelector('.contenedor-numeros-paginacion');
          const {elementos} = respuesta;
          paginacionElementosFundamentals(elementos,10,1,tbody,contenedorNumeros,accionRefrescarElementos);
          accionRefrescarElementos()
        }else{
          spinner.remove();
          alerta('alert-danger','Error del servidor',3000);
        }
  }
}


function accionRefrescarElementos() {
  const tbody = contenedorVistas.querySelector('tbody');
  const buttons = tbody.querySelectorAll('button');
  buttons.forEach(button => {
      const modal = document.createElement('div');
      button.addEventListener('click', (e) => {
          const datos  = JSON.parse(button.dataset.datos);
          modal.classList = 'modal fade';
          modal.id = `modalCarrera`;
          modal.setAttribute('tabindex','-1');
          modal.setAttribute('aria-labelledby','exampleModalLabel');
          modal.setAttribute('aria-hidden',true);
          modal.innerHTML = `
      <!-- Formulario -->
          <form>
          <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Editar la información de los elementos fundamentales</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
            <h4>Consideraciones.</h4>
            <ul  class="list-circle">
                <li>Puede editar la información como el identificador y la descripción del elemento fundamental, 
                puede guardar los cambio dando un click en la opcion Guardar Cambios</li>
            </ul>
            </div>
            <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Identificador</label>
            <div class="col-sm-8">
              <input type="hidden" name="id" value="${datos.id_elemento}">
              <input type="text" name="id_editado" class="form-control" id="staticEmail" value="${datos.id_elemento}">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="descripcion" class="col-sm-4 col-form-label">Descripción del elemento fundamental</label>
            <div class="col-sm-8">
              <textarea name="descripcion" class="form-control">${datos.descripcion}</textarea>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="criterio" class="col-sm-4 col-form-label">Nombre del estándar al que pertenece</label>
            <div class="col-sm-8">
              <input type="text" disabled name="criterio" class="form-control" value="${datos.nombre_estandar}">
            </div>
          </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary text-white">Guardar Cambios</button>
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

      form.addEventListener('submit',e =>  editarDatosElementos(e,modalBootstrap));

      });  
  })
}


function editarDatosElementos(e,modalBootstrap) {
  e.preventDefault();
  carga = new Precarga();
  const form = e.target;
  modalBootstrap.hide();
  carga.run();
  BaseIndicadores.editarElementos(new FormData(form))
  .then(renderElementosEdit)
  .catch(console.log)
}

function renderElementosEdit(respuesta){
  carga.end();
  if(respuesta.ident){
      new Notificacion(respuesta.mensaje,'Aceptar',false);
      listarElementos();
  }else {
      new Notificacion(respuesta.mensaje,'Regresar');
  }
}
function ingresarElemento() {

  const button = contenedorVistas.querySelector('#ingreso-elemento');
  const modal = document.createElement('div');
  button.addEventListener('click',() => {
          modal.classList = 'modal fade';
          modal.id = `modalCarrera`;
          modal.setAttribute('tabindex','-1');
          modal.setAttribute('aria-labelledby','exampleModalLabel');
          modal.setAttribute('aria-hidden',true);
          modal.innerHTML = `
      <!-- Formulario -->
          <form>
          <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ingresar la información de un elemento fundamental</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
            <h4>Consideraciones.</h4>
            <ul  class="list-circle">
                <li>Debe ingresar un identificador único para el elemento fundamental el cual debe ser un número,
                seguido debe ingresar la descripción del elemento y seleccionar a qué estándar pertenece.</li>
            </ul>
            </div>
            <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Ingrese el identificador</label>
            <div class="col-sm-8">
              <input type="text" placeholder="Ingrese un numero..." name="id" class="form-control">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="descripcion" class="col-sm-4 col-form-label">Ingrese la descripción del elemento fundamental</label>
            <div class="col-sm-8">
              <textarea name="descripcion" class="form-control" placeholder="Aa"></textarea>
            </div>
          </div>
          <div class="mb-3 row">
              <label for="estandar" class="col-sm-4 col-form-label">Seleccione el estándar al que pertenece</label>
              <div class="col-sm-8">
                <select class="form-select" name="estandar" id="select-estandares">
                <option >Cargando...</option>
                </select>
              </div>
            </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary text-white">Guardar</button>
            </div>
          </div>
        </div>
        </form>
          `;
      document.body.append(modal);
      const modalBootstrap =  new bootstrap.Modal(modal,{});
      const form = modal.querySelector('form');
      modalBootstrap.show();
      modal.addEventListener('hidden.bs.modal',(e) => {
          modal.remove();
      })
      BaseIndicadores.obtnerEstandares()
      .then(respuesta => {
        const select = modal.querySelector('#select-estandares');
        let html= '';
        respuesta.estandares.forEach(cr => {
            html += `<option value="${cr.id_estandar}">${cr.nombre_indicador}</option>`;
        })
  
        select.innerHTML = html;
      })
      .catch(console.log)
      form.addEventListener('submit',e => enviarDatosElemeto(e,modalBootstrap));
  })
}

function enviarDatosElemeto(e,modalBootstrap) {
e.preventDefault();
const form = e.target;

const input = form.querySelector('input');
const textarea = form.querySelector('textarea');
//compramos que todo este ingresado
if(input.value === '' || textarea.value === ''){
  alerta('alert-warning','Por favor, rellene todos los campos para continuar.',3500);
  return;
}
modalBootstrap.hide();
carga = new Precarga();
carga.run();
BaseIndicadores.insertarElementos(new FormData(form))
.then(renderRespuestaElementos)
.catch(console.log)
}

function renderRespuestaElementos(respuesta) {
carga.end();
  if(respuesta.ident){
      new Notificacion(respuesta.mensaje,'Aceptar',false);
      listarElementos();
  }else {
      new Notificacion(respuesta.mensaje,'Regresar');
  }
}


/**------------------------------------TODO: Componentes de los elementos fundamentales------------------------------- */

function accionComponentes() {
  listarComponentes();
  ingresarComponente();
}

function listarComponentes() {
  BaseIndicadores.obtenerComponentes()
  .then(renderComponentes)
  .catch(console.log)
}

function renderComponentes(respuesta) {
  if(respuesta.ident) {
    if(respuesta.ident){
        const tbody = contenedorVistas.querySelector('tbody');
        const contenedorNumeros = contenedorVistas.querySelector('.contenedor-numeros-paginacion');
        const {componentes} = respuesta;
        paginacionComponentes(componentes,10,1,tbody,contenedorNumeros,accionRefrescarComponentes);
        accionRefrescarComponentes()
      }else{
        spinner.remove();
        alerta('alert-danger','Error del servidor',3000);
      }
}
}


function accionRefrescarComponentes() {
  const tbody = contenedorVistas.querySelector('tbody');
  const buttons = tbody.querySelectorAll('button');
  buttons.forEach(button => {
      const modal = document.createElement('div');
      button.addEventListener('click', (e) => {
          const datos  = JSON.parse(button.dataset.datos);
          modal.classList = 'modal fade';
          modal.id = `modalCarrera`;
          modal.setAttribute('tabindex','-1');
          modal.setAttribute('aria-labelledby','exampleModalLabel');
          modal.setAttribute('aria-hidden',true);
          modal.innerHTML = `
      <!-- Formulario -->
          <form>
          <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Editar la información del componente del elemento fundamental</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
            <h4>Consideraciones.</h4>
            <ul  class="list-circle">
                <li>Puede editar la información como el identificador de elemento, el identificador 
                y la descripción del componente.</li>
                <li> Tenga en cuenta que el identificador de elemento es el identificador (número)
                del elemento fundamental al que pertenece y el identificador del componente es él 
                número de componentes que se encuentra dentro del elemento fundamental, por ejemplo: <br>
                Si el elemento fundamental 2 tiene 3 componentes, por ende el identificador de elemento
                será: 2 y para el primer componente, el identificador será: 1. 
                </li>
            </ul>
            </div>
            <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Identificador de elemento</label>
            <div class="col-sm-8">
              <input type="hidden" name="id" value="${datos.id}">
              <input type="text" name="id_elemento_editado" class="form-control" id="staticEmail" value="${datos.id_elemento}">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Identificador del componente</label>
            <div class="col-sm-8">
              <input type="text" name="id_componente_editado" class="form-control" id="staticEmail" value="${datos.id_componente}">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="descripcion" class="col-sm-4 col-form-label">Descripción del componente</label>
            <div class="col-sm-8">
              <textarea name="descripcion" class="form-control">${datos.descripcion}</textarea>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="criterio" class="col-sm-4 col-form-label">Descripción del elemento fundamental al que pertenece</label>
            <div class="col-sm-8">
            <textarea disabled class="form-control">${datos.descripcion_elemento}</textarea>
            </div>
          </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary text-white">Guardar Cambios</button>
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
      form.addEventListener('submit',e =>  editarDatosComponentes(e,modalBootstrap));

      });  
  })
}

function editarDatosComponentes(e,modalBootstrap) {
  e.preventDefault();
  carga = new Precarga();
  const form = e.target;
  modalBootstrap.hide();
  carga.run();
  BaseIndicadores.editarComponentes(new FormData(form))
  .then(renderComponentesEdit)
  .catch(console.log)
}

function ingresarComponente() {
  const button = contenedorVistas.querySelector('#ingreso-componente');
  const modal = document.createElement('div');
  button.addEventListener('click',() => {
          modal.classList = 'modal fade';
          modal.id = `modalCarrera`;
          modal.setAttribute('tabindex','-1');
          modal.setAttribute('aria-labelledby','exampleModalLabel');
          modal.setAttribute('aria-hidden',true);
          modal.innerHTML = `
      <!-- Formulario -->
      <form>
      <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar un nuevo componente de elemento fundamental</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="mb-3">
        <h4>Consideraciones.</h4>
        <ul  class="list-circle">
            <li>El identificador del componente es él 
            número de componentes que se encuentra dentro del elemento fundamental, por ejemplo: <br>
            Si el elemento fundamental 2, tiene 3 componentes el primer componente tendra el identificador: 1. 
            </li>
            <li>Deberá seleccionar un solo elemento fundamental al que pertenezca el componente y lo puede realizar
            selcionando la tarjeta de presentación en la parte inferior en el círculo blanco, además contiene
            una opción de Ver detalle que al darle clic puede visualizar la información completa del elemento 
            fundamental que desea seleccionar.</li>
        </ul>
        </div>
      <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-4 col-form-label">Identificador del componente</label>
        <div class="col-sm-8">
          <input placeholder="Número..." type="text" name="id_componente" class="form-control">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="descripcion" class="col-sm-4 col-form-label">Descripción del componente</label>
        <div class="col-sm-8">
          <textarea placeholder="Aa" name="descripcion" class="form-control"></textarea>
        </div>
      </div>
      <div class="mb-3 row altura-1 desborde-auto">
      <label> Seleccione el elemento al que pertenece.</label>
      <div class="w-100 p-3 d-flex flex-wrap gap-2 justify-content-center" id="elementos-f">
      </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary text-white">Guardar Cambios</button>
        </div>
      </div>
    </div>
    </form>
          `;
      document.body.append(modal);
      const modalBootstrap =  new bootstrap.Modal(modal,{});
      const form = modal.querySelector('form');
      modalBootstrap.show();
      modal.addEventListener('hidden.bs.modal',(e) => {
          modal.remove();
      })
      BaseIndicadores.obtnerElementos()
      .then(respuesta => {
        const select = modal.querySelector('#elementos-f');
        let html= '';
        respuesta.elementos.forEach(cr => {
            html += `<div title="Click para selecionar" class="tarjeta"> 
        <input class="form-check-input" type="radio" value="${cr.id_elemento}" name="elemento">
            ${cr.descripcion.slice(0,30)} <br>
            <span presentacion class="text-primary text-decoration-underline"
            style="cursor:pointer;"
            data-dato="${cr.descripcion}">Ver detalle</span></div>`;
        })
        select.innerHTML = html;

        const spans = select.querySelectorAll('span[presentacion]');
        presentacion(spans);
      })
      .catch(console.log)
      form.addEventListener('submit',e => enviarDatosComponente(e,modalBootstrap));
  })
}

function enviarDatosComponente(e,modalBootstrap) {
  e.preventDefault();
  const form = e.target;
  const radios = form.querySelectorAll('input[type=radio]:checked');
  const input = form.querySelector('input');
  const textarea = form.querySelector('textarea');
  if(input.value.trim() === '') {
    alerta('alert-warning','Por favor, ingrese un numero como identificador de componente.',3500);
    return;
  }

  if(textarea.value.trim() === '') {
    alerta('alert-warning','Por favor, ingrese una descripción para el componente de elemento fundamental',3500);
    return;
  }

  if(radios.length <= 0) {
    alerta('alert-warning','Por favor, seleccione un elemento fundamental en la parte inferior dando un click en el circulo blanco.',3500);
    return;
  }
  modalBootstrap.hide();
  carga = new Precarga();
  carga.run();
  BaseIndicadores.insertarComponentes(new FormData(form))
  .then(renderInsertComponentes)
  .catch(console.log)
}
function renderInsertComponentes(respuesta){
  carga.end();
  if(respuesta.ident){
      new Notificacion(respuesta.mensaje,'Aceptar',false);
      listarComponentes();
  }else {
      new Notificacion(respuesta.mensaje,'Regresar');
  }
}
function renderComponentesEdit(respuesta){
  carga.end();
  if(respuesta.ident){
      new Notificacion(respuesta.mensaje,'Aceptar',false);
      listarComponentes();
  }else {
      new Notificacion(respuesta.mensaje,'Regresar');
  }
}
function presentacion(buttons) {
  buttons.forEach(button => {
  const modal = document.createElement('div');
  button.addEventListener('click',(e) => {
          e.stopPropagation();
          modal.classList = 'modal fade';
          modal.id = `modalToggle2`;
          modal.setAttribute('tabindex','-1');
          modal.setAttribute('aria-labelledby','exampleModalLabel2');
          modal.setAttribute('aria-hidden',true);
          modal.innerHTML = `
      <!-- Formulario -->
          <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Descripción</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <h4>Descripción General</h4>
            <p class="p-2">
            ${button.dataset.dato}
              <p>
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
  })
  }) 
}

/**---------------------------TODO: Opcion de Evidencias--------------------- */

function accionEvidencias() {
  listarEvidencias();
  insertarEvidencias();
}

function listarEvidencias() {
  BaseIndicadores.obtenerEvidencias()
  .then(renderEvidencias)
  .catch(console.log)
}


function renderEvidencias(respuesta) {
  if(respuesta.ident){
    const tbody = contenedorVistas.querySelector('tbody');
    const contenedorNumeros = contenedorVistas.querySelector('.contenedor-numeros-paginacion');
    const busqueda = document.getElementById('busqueda');
    const {evidencias} = respuesta;
    paginacionEvidencias(evidencias,15,1,tbody,contenedorNumeros,accionRefrescarEvidencias);
    busqueda.addEventListener('input',(function(evidencias){
      return () => {
        paginacionEvidencias(evidencias,15,1,tbody,contenedorNumeros,accionRefrescarEvidencias,'nombre_evidencias',busqueda.value.trim(),true);
        accionRefrescarEvidencias();
      };
    })(evidencias))
    accionRefrescarEvidencias();  
  }else{
    spinner.remove();
    alerta('alert-danger','Error del servidor',3000);
  }
}

function accionRefrescarEvidencias() {
  const tbody = contenedorVistas.querySelector('tbody');
  const buttons = tbody.querySelectorAll('button');
  buttons.forEach(button => {
      const modal = document.createElement('div');
      button.addEventListener('click', (e) => {
          const datos  = JSON.parse(button.dataset.datos);
          const nombre_Evidencia = [...new Set(datos.nombre_evidencias?.split('---'))];
          modal.classList = 'modal fade';
          modal.id = `modalCarrera`;
          modal.setAttribute('tabindex','-1');
          modal.setAttribute('aria-labelledby','exampleModalLabel');
          modal.setAttribute('aria-hidden',true);
          modal.innerHTML = `
      <!-- Formulario -->
          <form>
          <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Editar la información de las fuentes de información.</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
            <h4>Consideraciones.</h4>
            <ul  class="list-circle">
                <li>Puede editar la información del identificador y el nombre 
                de la fuente de información.</li>
                <li>
                  Nota: El identificador esta relacionado con el criterio, estándares, elementos fundamentales y
                  componentes de elementos por ejemplo:<br>
                  La fuente de información (Plan estratégico carrera (FODA-PESTEL-PROSPECTIVA))
                  se encuentra en el criterio 1, estándar 1, elemento fundamental 1
                  componente de elemento fundamental 1, y es la fuente de información 1,
                  por tal razón el identificador sera: <strong>
                  1.1.1.1.1
                  </strong> 
                </li>
            </ul>
            </div>
            <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Identificador de la fuente de información</label>
            <div class="col-sm-8">
              <input type="hidden" name="id" value="${datos.id_evidencias}">
              <input type="text" name="id_editado" class="form-control" id="staticEmail" value="${datos.id_evidencias}">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">Nombre de la fuente de información</label>
            <div class="col-sm-8">
              <input type="text" name="nombre" class="form-control" id="staticEmail" 
              value="${nombre_Evidencia.toString()}">
            </div>
          </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary text-white">Guardar Cambios</button>
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
      form.addEventListener('submit',e =>  editarDatosEvidencias(e,modalBootstrap));

      });  
  })
}

function editarDatosEvidencias(e,modalBootstrap) {
  e.preventDefault();
  const form = e.target;
  carga = new Precarga();
  modalBootstrap.hide();
  carga.run();
  BaseIndicadores.editarEvidencias(new FormData(form))
  .then(renderEvidenciasEdit)
  .catch(console.log)
}


function renderEvidenciasEdit(respuesta) {
  carga.end();
  if(respuesta.ident){
      new Notificacion(respuesta.mensaje,'Aceptar',false);
      listarEvidencias();
  }else {
      new Notificacion(respuesta.mensaje,'Regresar');
  }
}

function insertarEvidencias() {
  const button = contenedorVistas.querySelector('#ingreso-evidencias');
  const modal = document.createElement('div');
  button.addEventListener('click',() => {
          modal.classList = 'modal fade';
          modal.id = `modalCarrera`;
          modal.setAttribute('tabindex','-1');
          modal.setAttribute('aria-labelledby','exampleModalLabel');
          modal.setAttribute('aria-hidden',true);
          modal.innerHTML = `
      <!-- Formulario -->
      <form>
      <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar una fuente de información.</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="mb-3">
        <h4>Consideraciones.</h4>
        <ul  class="list-circle">
            <li>El identificador del componente es él 
            número de componentes que se encuentra dentro del elemento fundamental, por ejemplo: <br>
            Si el elemento fundamental 2, tiene 3 componentes el primer componente tendra el identificador: 1. 
            </li>
            <li>Deberá seleccionar un solo elemento fundamental al que pertenezca el componente y lo puede realizar
            selcionando la tarjeta de presentación en la parte inferior en el círculo blanco, además contiene
            una opción de Ver detalle que al darle clic puede visualizar la información completa del elemento 
            fundamental que desea seleccionar.</li>
        </ul>
        </div>
      <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-4 col-form-label">Identificador de la fuente de información</label>
        <div class="col-sm-8">
          <input placeholder="Números separado por puntos..." type="text" name="id" class="form-control">
        </div>
      </div>
      <div class="mb-3 row">
        <label for="descripcion" class="col-sm-4 col-form-label">Ingresar el nombre de la fuente de información</label>
        <div class="col-sm-8">
        <input placeholder="Aa" type="text" name="nombre" class="form-control">
        </div>
      </div>
      <div class="mb-3 row altura-1 desborde-auto">
      <label> Seleccione los componentes elemento fundamentales al que pertenece.</label>
      <div class="w-100 p-3 d-flex flex-wrap gap-2 justify-content-center" id="elementos-f">
      </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary text-white">Guardar Cambios</button>
        </div>
      </div>
    </div>
    </form>
          `;
      document.body.append(modal);
      const modalBootstrap =  new bootstrap.Modal(modal,{});
      const form = modal.querySelector('form');
      modalBootstrap.show();
      modal.addEventListener('hidden.bs.modal',(e) => {
          modal.remove();
      })
      BaseIndicadores.componentesElementosEvidencias()
      .then(respuesta => {
        console.log(respuesta);
        const select = modal.querySelector('#elementos-f');
        

        let html= '';
        respuesta.datos.forEach(cr => {
          let htmlOculto = `
          <div class="mb-3 row">
            <label for="descripcion" class="col-sm-4 col-form-label">Descripción del componente de elemento fundamental</label>
            <div class="col-sm-8">
              <ul class="sombra p-3" style="list-style: inside;">
              ${[...new Set(cr.descripcion_componente?.split('---'))].map(el => {
                return '<li>' + el + '</li>';
              }).join('')}
              </ul>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="descripcion" class="col-sm-4 col-form-label">Descripción del elemento fundamental</label>
            <div class="col-sm-8">
            <ul class="sombra p-3" style="list-style: inside;">
            ${[...new Set(cr.descripcion_elemento?.split('---'))].map(el => {
              return '<li>' + el + '</li>';
            }).join('')}
            </ul>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="descripcion" class="col-sm-4 col-form-label">Descripción del estándar</label>
            <div class="col-sm-8">
            <ul class="sombra p-3" style="list-style: inside;">
            ${[...new Set(cr.descripcion_estandar?.split('---'))].map(el => {
              return '<li>' + el + '</li>';
            }).join('')}
            </ul>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="descripcion" class="col-sm-4 col-form-label">Nombre del criterio</label>
            <div class="col-sm-8">
            <ul class="sombra p-3" style="list-style: inside;">
            ${[...new Set(cr.nombre_criterio?.split('---'))].map(el => {
              return '<li>' + el + '</li>';
            }).join('')}
            </ul>
            </div>
          </div>
        `;
            html += `<div title="Click para selecionar" class="tarjeta"> 
        <input class="form-check-input" type="checkbox" value="${cr.id_componente}" name="componentes[]">
            ${cr.descripcion_componente.slice(0,30)} <br>
            <span presentacion class="text-primary text-decoration-underline 
            tipografia-times-1"
            style="cursor:pointer;"
            data-dato='${htmlOculto}'>Ver detalle</span></div>`;
        })
        select.innerHTML = html;

        const spans = select.querySelectorAll('span[presentacion]');
        presentacion(spans);
      })
      .catch(console.log)
      form.addEventListener('submit',e => enviarDatosEvidencias(e,modalBootstrap));
  })
}

function enviarDatosEvidencias(e,modalBootstrap) {
  e.preventDefault();
  const form = e.target;
  const ckeckeds = form.querySelectorAll('input[type=checkbox]:checked');
  const [input,nombre] = form.querySelectorAll('input');
  if(input.value.trim() === '') {
    alerta('alert-warning','Por favor, ingrese el identificador con numeros separados por puntos como identificador de la fuente de información.',3500);
    return;
  }

  if(nombre.value.trim() === '') {
    alerta('alert-warning','Por favor, ingrese una nombre para la fuente de información.',3500);
    return;
  }

  if(ckeckeds.length <= 0) {
    alerta('alert-warning','Por favor, seleccione uno o varios componentes de elemento fundamentales en la parte inferior dando un click en los cuadros blancos.',3500);
    return;
  }
  modalBootstrap.hide();
  carga = new Precarga();
  carga.run();
  BaseIndicadores.insertarEvidencias(new FormData(form))
  .then(renderEvidenciasInsert)
  .catch(console.log)
}

function renderEvidenciasInsert(respuesta) {
  carga.end()
  if(respuesta.ident) {
    new Notificacion(respuesta.mensaje,'Aceptar',false);
    if(respuesta.errores.length >= 1) {
      let lis = '';
      respuesta.errores.forEach(e => {
        lis +=`<li>${e}</li>`;
      });
      const ul = `<ul style="list-style: inside;">
        ${lis}
      </ul>
      `;
        
      new Notificacion(ul,'Aceptar',false);
    }

    listarEvidencias();
  }else {
    new Notificacion(respuesta.mensaje,'Regresar');
  }
}
