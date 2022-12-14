import Precarga from "./../../modulos/PreCarga/Precarga.js";
import MenuOpcionesSuperior from "../../modulos/MenuOpcionesSuperior/MenuOpcionesSuperior.js";
import Carreras from "../../models/Carreras.js";
import alerta from "../../utiles/alertasBootstrap.js";
import { paginacionCarreras, paginacionCarrerasHabilitas } from "../../utiles/funcionPaginacionCarreras.js";
import Facultad from './../../models/Facultad.js';
import Notificacion from "../../modulos/Notificacion/Notificacion.js";
import PeriodoAcademico from "../../models/PeriodoAcademico.js";

(function(){
    MenuOpcionesSuperior.correr();
})();

let precarga = document.createElement('div');
precarga.classList = 'spinner-border text-primary carga-medio';
precarga.setAttribute('role','status');
precarga.innerHTML = `<span class="visually-hidden">Loading...</span>`;
document.body.append(precarga);

const contenedorVistas = document.getElementById('cambio-vistas');
const [op1,op2,op3] = document.querySelectorAll('#contenedor-menu-superior li');
const htmlOp1 = document.getElementById('template-listar-carreras').innerHTML;
const htmlOp2 = document.getElementById('template-insertar-carreras').innerHTML;
const htmlOp3 = document.getElementById('template-habilitar-carreras').innerHTML;

MenuOpcionesSuperior.renderVistasAcciones([
  [op1,htmlOp1,cargarCarreras,'focus'],
  [op2,htmlOp2,actionInsertarCarreras],
  [op3,htmlOp3,actionHabiltarCarreras]
]);

 /**-------------------------------- TODO: Vista Listas de Carreras ---------------------------------- */
function  cargarCarreras(){
  busquedaFiltro();
    contenedorVistas.append(precarga);
    Carreras.getCarreras()
    .then(renderCarreras)
    .catch(e => console.log(e));
}
/**
 * Esta funcion da la funcionalidad de buscar si cambiar de valor el filtro de carreras
 * a facultad o al revez
 */
function busquedaFiltro() {
  const contenedor = document.getElementById('content-busqueda');
  const filtro = document.getElementById('filtro-busqueda');
  const busqueda = document.getElementById('busqueda');
  filtro.addEventListener('change',e => {
    if(filtro.value === 'facultad') {
      selectFacultadesRender(contenedor);
      busquedaFacultades(contenedor,filtro);
    }
    if(filtro.value === 'carrera') {
      contenedor.innerHTML = `<span class="material-icons">&#xe8b6;</span><input type="text" name="valor" id="busqueda" placeholder="Escriba aquí...">
      <span class="material-icons text-danger">&#xe5c9;</span>`;
      busquedaFiltro();
      busquedaGeneral(contenedor,filtro,busqueda);
    }
  })

  busquedaGeneral(contenedor,filtro,busqueda);
}
/**
 * Esta funcion realiza una consulta de todas las facultades para mostrarse
 * en el select para buscar por facultad
 * 
 * @param {*} contenedor
 */
function selectFacultadesRender(contenedor) {
  let html = ` <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="facultad" id="select-facultades-insert">
  <option value="none">Cargando...</option>
  </select>`;
  contenedor.innerHTML = html;
  Facultad.obtenerFacultades()
  .then(renderFacultades)
  .catch(e => console.log(e));
}
/**
 * Son las facultades que contiene la BD
 * 
 * @param {JSON} respuesta 
 */
function renderFacultades(respuesta) {
  const select = document.getElementById('select-facultades-insert');
  if(respuesta.ident) {
    const {facultades} = respuesta;
    let html = '<option selected value="none">Facultades...</option>';
    facultades.forEach(facultad => {
          html += `<option value="${facultad.id}">${facultad.nombre}</option>`
    })
    select.innerHTML = html;
  }
}
/**
 * Esta funcion realiza la busqueda de carreras que pertenezca a cierta facultad
 * 
 * @param {*} cont el contenedor del select de las opciones
 * @param {*} actionSelect es el selet que contiene los valores de carrera y facultad
 */
function busquedaFacultades(cont,actionSelect) {
  const selectValue = cont.querySelector('select');
  selectValue.addEventListener('change', (e) => {
    if(selectValue.value !== 'none') {
    contenedorVistas.append(precarga);
      Carreras.getCarreras(actionSelect.value,selectValue.value)
      .then(renderCarreras)
      .catch(e => console.error(e));
      selectValue.value = 'none';
    }
  })

}
/**
 * Esta funcion renderiza las carreras que llegan a partir de una consulta
 * 
 * @param {JSON} respuesta 
 */
function renderCarreras(respuesta) {
    if(respuesta.ident) {
        const tbody = contenedorVistas.querySelector('tbody');
        const contenedorNumeros = document.querySelector('.contenedor-numeros-paginacion');
        const {carreras} = respuesta;
        paginacionCarreras(carreras,5,1,tbody,contenedorNumeros,funcionRefescar);
        funcionRefescar();
        precarga.remove();
    }
}
/**
 * Esta funcion hidrata cada vez que se renderizan las carreras
 * para con ello hacer que los botones habran un modal con los 
 * datos que se pueden editar
 */
function funcionRefescar() {
    const tbody = contenedorVistas.querySelector('tbody');
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
                <h5 class="modal-title" id="exampleModalLabel">Datos de la Carrera ${dato.nombre_carrera}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
        
              <div class="mb-3 row">
              <label for="staticEmail" class="col-sm-2 col-form-label">Identificador</label>
              <div class="col-sm-10">
                <input type="hidden" name="id" value="${dato.id_carrera}">
                <input type="text" name="id_editado" class="form-control" id="staticEmail" value="${dato.id_carrera}">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="nombre" class="col-sm-2 col-form-label">Nombre de la Carrera</label>
              <div class="col-sm-10">
                <input type="text" name="nombre" class="form-control" value="${dato.nombre_carrera}" id="nombre">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="facultad" class="col-sm-2 col-form-label">Facultad Perteneciente</label>
              <div class="col-sm-10">
                <input type="text" disabled name="facultad" value="${dato.nombre_facultad}" class="form-control" id="facultad">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="numero_asig" class="col-sm-2 col-form-label">Numero de Asignaturas</label>
              <div class="col-sm-10">
                <input type="number" name="numero_asig" value="${dato.numero_asig}" class="form-control" id="numero_asig">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="horas_proyecto" class="col-sm-2 col-form-label">Horas de Proyecto de Carrera</label>
              <div class="col-sm-10">
                <input type="number" name="horas_proyecto" value="${dato.total_horas_proyecto}" class="form-control" id="horas_proyecto">
              </div>
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
        modalBootstrap.show();
        modal.addEventListener('hidden.bs.modal',(e) => {
            modal.remove();
        })
        form.addEventListener('change',(e) => {
          document.dispatchEvent(new CustomEvent('enviodatos',{detail:true}));
        })
        form.addEventListener('submit',(e) => editarDatos(e,modal,modalBootstrap,form));
        });
    })
    busquedaFiltro();
}

/**
 * Esta funcion activa los span para dar una accion como
 * el icono de la lupa para que se realize la busqueda
 * y el icono de la x para borar el contenido del input
 * 
 * @param {*} cont 
 * @param {*} filtro 
 * @param {*} inputBusqueda 
 * @returns 
 */
function busquedaGeneral(cont,filtro,inputBusqueda) {
    const [spanB,spanC] = cont.querySelectorAll('span');
    if(!spanB || !spanC || !cont || !filtro || !inputBusqueda) return;
    spanC.classList.add('hidden');
    inputBusqueda.addEventListener('input',e => {
      if(inputBusqueda.value !== ''){
        spanC.classList.remove('hidden');
      }else {
        spanC.classList.add('hidden');
      }
    });

    spanC.addEventListener('click',e => {
      inputBusqueda.value = '';
      spanC.classList.add('hidden');
    })

    inputBusqueda.addEventListener('change',e => busqueda(e.target,filtro));
    spanB.addEventListener('click',e => busqueda(inputBusqueda,filtro));
}
/**
 * Esta funcion realiza la consulta por carrera que es id de la misma
 * que realiza la peticion en el backend a la DB
 * 
 * @param {*} input 
 * @param {*} filtro 
 */
function busqueda(input,filtro) {
  contenedorVistas.append(precarga);
    Carreras.getCarreras(filtro.value,input.value.trim().toUpperCase())
    .then((respuesta) => {
      if(respuesta.ident){
        renderCarreras(respuesta);
      }else {
        alerta('alert-danger',respuesta.mensaje,3000);
        precarga.remove();
      }
    })
}
let enviarDatosEditar = false;
/**
 * Esta funcion realiza la edicion de una carrera mediante el modal
 * que se presenta
 * 
 * @param {*} e evento de submit
 * @param {*} modalHtml el modal en htmlElement
 * @param {*} modalBootstrap una instancia del modal de bootstrap
 * @param {*} formulario es el formulario con los datos para editar
 */
function editarDatos(e,modalHtml,modalBootstrap,formulario) {
    e.preventDefault();
    if(enviarDatosEditar){
      let precargaInterna = new Precarga;
      modalBootstrap.hide();
      modalHtml.remove();
      precargaInterna.run();
      Carreras.editarCarrera(new FormData(formulario))
      .then((respuesta) => {
        if(respuesta.ident){
          alerta('alert-success',respuesta.mensaje,3000);
          cargarCarreras();
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
document.addEventListener('enviodatos',(e) => {
  enviarDatosEditar = e.detail;
})
/**------------------------------------------ funcionalidad de la segunda opcion insertar carreras------------------------------------------------ */

/**
 * Es la accion de la opcion de insertar carreras
 * 
 */
function actionInsertarCarreras() {
  const form = document.getElementById('form-insert-carreras');
  form.addEventListener('submit',insertarCarrera);
    Facultad.obtenerFacultades()
    .then(renderFacultades)
    .catch(e => console.log(e));
}
/**
 * Inserta las carreras en la DB por medio de peticion que realiza
 * el modelo Carreras
 * 
 * @param {Event} e envento submit del formulario 
 */
function insertarCarrera(e) {
  e.preventDefault();
  if(verficaciones(e.target)){
    let precargaInterna = new Precarga();
    precargaInterna.run();
      Carreras.insertarCarrera(new FormData(e.target))
      .then(respuesta => {
        if(respuesta.ident){
          precargaInterna.end();
          new Notificacion(respuesta.mensaje,'Aceptar',false);
          reiniciarInputs(e.target);
        }else {
          precargaInterna.end();
          new Notificacion(respuesta.mensaje,'Regresar');
        }
      })
      .catch(e => console.error(e))
  }else {
    console.log('fallo');
  }
}

let verficacionesInputs={inputsContenido: false,selecionFacultad: false};// sirve para verificar cada input del formulario
/**
 * Verifica que no haya ningun error al momento de enviar los datos
 * a guardarse en la DB
 * 
 * @param {*} formulario 
 * @returns {boolean}
 */
function verficaciones(formulario) {
  const inputs = formulario.querySelectorAll('input');
  const select = formulario.querySelector('select');

  verficacionesInputs.inputsContenido = Array.from(inputs).map(input =>  {  
     if(input.value !== '') {
      if(input.classList.contains('is-invalid')){
        input.classList.remove('is-invalid')
        input.classList.add('is-valid');
      }else{
        input.classList.add('is-valid');
      }   
     }else{
      input.classList.add('is-invalid');  
     }
     return input;
  }).every(input => input.value !== '');
  if(select.value !== 'none'){
    if(select.classList.contains('is-invalid')) select.classList.remove('is-invalid');
    select.classList.add('is-valid');
  }else {
    select.classList.add('is-invalid');
  }
  verficacionesInputs.selecionFacultad = select.value !== 'none' ? true : false;

  return Object.values(verficacionesInputs).every(v => v === true);
}
/**
 * Restablece los inputs del formulario
 * 
 * @param {*} formulario 
 */
function reiniciarInputs(formulario) {
  const inputs = formulario.querySelectorAll('input');
  const select = formulario.querySelector('select');
  inputs.forEach(input => {
      input.classList.remove('is-valid');
      input.value = '';
  });
  select.classList.remove('is-valid');
  select.value = 'none';
}


/**--------------------------------------------------- Funcionalidad de la tercera opcion de Habiltar carrera----------------------------- **/


function actionHabiltarCarreras() {
  PeriodoAcademico.getDatos()
  .then(renderPeriodosAcademicos)
}

function renderPeriodosAcademicos (respuesta) {
  const periodosAcademicosSelect = document.getElementById('periodos-academicos');
  if(respuesta.ident) {
    const {periodoAcademico} = respuesta;
    let html = '';
    periodoAcademico.forEach(periodo => {
      html  += `
      <option value="${periodo.id}">${periodo.id}</option>
      `; 
    })
    periodosAcademicosSelect.innerHTML = html;
  }else{
    console.log(respuesta.mensaje);
  }
  consultaCarrerasHabilitadas();
}

function consultaCarrerasHabilitadas(){
  contenedorVistas.append(precarga);
  const periodosAcademicosSelect = document.getElementById('periodos-academicos');
  Carreras.obtenerCarrerasHabilitadasPorPeriodo(periodosAcademicosSelect.value.trim())
  .then(renderCarrerasHabilitadas)
  .catch(e => console.error(e));
  periodosAcademicosSelect.addEventListener('change',() =>{
    contenedorVistas.append(precarga);
    Carreras.obtenerCarrerasHabilitadasPorPeriodo(periodosAcademicosSelect.value.trim())
    .then(renderCarrerasHabilitadas)
    .catch(e => console.log(e));
  })

}

function renderCarrerasHabilitadas(respuesta) {
  if(respuesta.ident) {
    const tbody = contenedorVistas.querySelector('tbody');
    const contenedorNumeros = document.querySelector('.contenedor-numeros-paginacion');
    const {carreras} = respuesta;
   paginacionCarrerasHabilitas(carreras,5,1,tbody,contenedorNumeros);
   precarga.remove();
   guardarCarrerasHabilitadas();
}
}
function guardarCarrerasHabilitadas() {
  const tbody = contenedorVistas.querySelector('tbody');
  const boton = document.getElementById('boton-g-habilitacion');
  const periodosAcademicosSelect = document.getElementById('periodos-academicos');
  const inputCheckContainer = document.getElementById('checkHabilitarContenedor');
  boton.onclick = e => {
    e.stopImmediatePropagation();
    e.stopPropagation();
    e.preventDefault();
    if(inputCheckContainer.querySelector('input[type=checkbox]:checked')){
      const inputCheckboxs = tbody.querySelectorAll('input[type=checkbox]:checked');
    const formData = new FormData(); 
    formData.append('periodo',periodosAcademicosSelect.value.trim());
    inputCheckboxs.forEach((input,i) => {
      const parent = input.parentElement
      const id_carrera = parent.querySelector('input[type=hidden]');
      if(!input.hasAttribute('data-db-content')){
        formData.append(`ids_carreras[${i}]`,id_carrera.value);
      }
    });
    if([...formData].length <= 1) { // por que el periodo si esta ingresado
      alerta('alert-primary','No ha selecionado ninguna carrera',3000);
        return;
    }
    PeriodoAcademico.habilitarCarreras(formData)
    .then(respuesta => {
      if(respuesta.ident){
        alerta('alert-success','Se habilito correctamente las carreras selecionadas',3000);
        contenedorVistas.append(precarga);
        Carreras.obtenerCarrerasHabilitadasPorPeriodo(periodosAcademicosSelect.value.trim())
        .then(renderCarrerasHabilitadas);
      }else {
        new Notificacion(respuesta.mensaje,'Regresar');
      }
    })

  }else {
    alerta('alert-primary','Selecione la casilla de <strong>Habilitar Auto Evaluación</strong>');
  }
  }
}