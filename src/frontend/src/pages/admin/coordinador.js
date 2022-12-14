import MenuOpcionesSuperior from "../../modulos/MenuOpcionesSuperior/MenuOpcionesSuperior.js";
import Notificacion from "../../modulos/Notificacion/Notificacion.js";
import Precarga from "./../../modulos/PreCarga/Precarga.js";
import Docentes from "../../models/Docentes.js";
import alerta from "../../utiles/alertasBootstrap.js";
import { paginacionCoordinadores } from "../../utiles/funcionPaginacionCoordinadores.js";
import { CEDULA_REG_EXPRE, COREO_INST } from "../../modulos/RegularExpresions/ConstExpres.js";

MenuOpcionesSuperior.correr();
const contenedorVistas = document.getElementById('cambio-vistas');
const [op1,op2] = document.querySelectorAll('#contenedor-menu-superior li');
const htmlOp1 = document.getElementById('template-lista-coordinadores').innerHTML;
const htmlOp2 = document.getElementById('template-ingresar-coordinador').innerHTML;

MenuOpcionesSuperior.renderVistasAcciones([
    [op1,htmlOp1,actionListarCoordinadores,'focus'],
    [op2,htmlOp2,actionIngresarCoordinador]
]);

let precarga = undefined;
let spinner = document.createElement('div');
spinner.classList = 'spinner-border text-primary carga-medio';
spinner.setAttribute('role','status');
spinner.innerHTML = `<span class="visually-hidden">Loading...</span>`;
document.body.append(spinner);

function actionListarCoordinadores () {
  Docentes.obtenerCoordinadores()
  .then(renderCoordinadores)
}

function renderCoordinadores(respuesta){
  if(respuesta.ident){
    const tbody = contenedorVistas.querySelector('tbody');
    const contenedorNumeros = contenedorVistas.querySelector('.contenedor-numeros-paginacion');
    const busqueda = document.getElementById('busqueda');
    const {coordinadores} = respuesta;
    paginacionCoordinadores(coordinadores,8,1,tbody,contenedorNumeros);
    spinner.remove();
    busqueda.addEventListener('input',(function(coordinator){
        return () => {
        paginacionCoordinadores(coordinator,8,1,tbody,contenedorNumeros,null,'nombre_carrera',busqueda.value.trim());
        };
    })(coordinadores))
  }else{
    spinner.remove();
    alerta('alert-danger','Error del servidor',3000);
  }
}




/**-------------------------------------Script para la segunda opcion del menu superior inresar coordinador---------------------------------------- */


function actionIngresarCoordinador () {
const formulario = document.forms[0];
const [fecha_inicial,fecha_final] = formulario.querySelectorAll('input[type="date"]');
const carreras = formulario.querySelector('#carreras');
const docentes = formulario.querySelector('#coordinador');
let errores = true;
formulario.addEventListener('submit',verificacionDatos);
carreras.addEventListener('change', getDatosDocentes);
actionIngresoManual();
function verificacionDatos(e){
    e.preventDefault();
    precarga = new Precarga();
    precarga.run();
    datosCorrectos();
    if(errores){
        precarga.end();
        alerta('alert-warning','Error no ingreso todos los datos necesarios intentelo nuevamente',3000);
    }else{
        const formData = new FormData(formulario);
        Docentes.sendCoordinador(formData)
        .then(respuesta => renderRespuesta(respuesta,formulario))
        .catch(renderErrores);
    }
}
function getDatosDocentes(e){
    if (e.target.value !== 'none'){
        precarga = new Precarga();
        precarga.run();
        const idCarrera = e.target.value
        Docentes.getDatos(idCarrera)
        .then(renderDocentes)
        .catch(renderErrores); 
    }
}

function renderDocentes(datos){
    if(datos.ident){
        docentes.innerHTML = '';
        let html = '';
        html += '<option value="none">Docentes ... </option>';
        datos.docentes.forEach(docente => {
            const {id,nombre,apellido} = docente;
            html += `<option value="${id.trim()}">
            <span><strong>Nombre: </strong>${nombre + ' ' + apellido.split(' ')[0]} ➡ </span>
            <span><strong>CI: </strong>${id}</span>
            </option>`;
        });
        precarga.end();
        docentes.innerHTML = html;
    }else{
        throw new Error(datos.mensaje);
    }
    

}

function datosCorrectos(){
    if(fecha_final.value !== '' && 
        fecha_inicial.value !== '' &&
        carreras.value !== 'none' &&
        docentes.value !== 'none'
       ) {
            errores = false;
       }else {
            errores = true;
       }
}

function renderRespuesta(respuesta,form){
   precarga.end();
   if(respuesta.ident){
    new Notificacion(
        respuesta.mensaje + ' para la carrera con el identificador ' + carreras.value,
        'Aceptar',
        false
    )
    new Notificacion(
      Boolean(respuesta.identEmail) === true ? '' +  respuesta.email : 'Ocurrio un error al enviar el correo electronico <br>' 
      + respuesta.email,
      'Aceptar',
      Boolean(respuesta.identEmail) === true ? false : true
    );
    rebootInputs(form);
   }else{
    throw new Error(respuesta.mensaje);
   }
}

}

function renderErrores(e){
  new Notificacion(
       e,
       'Regresar'
   )
   precarga.end();
} 
function actionIngresoManual() {
    const boton = document.getElementById('ingreso-manual');
    const modal = document.createElement('div');
    const select = document.getElementById('template-ingresar-coordinador').content.querySelector('#carreras');
        modal.classList = 'modal fade';
        modal.id = `modalIngresoManual`;
        modal.setAttribute('tabindex','-1');
        modal.setAttribute('data-bs-backdrop',true);
        modal.setAttribute('aria-labelledby','exampleModalLabel');
        modal.setAttribute('aria-hidden',true);
        modal.innerHTML = `
        <!-- Formulario -->
            <form>
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Registre un Coordinador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              <div class="mb-3 row">
              <label for="cedula" class="col-sm-5 col-form-label fw-bold">Ingrese el Numero de Cedula del Docente</label>
              <div class="col-sm-7">
                <input type="text" name="cedula" class="form-control opcional-ingreso" id="cedula"">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="nombre" class="col-sm-5 col-form-label fw-bold">Ingrese los Nombres del Docente</label>
              <div class="col-sm-7">
                <input type="text" name="nombre" class="form-control" id="nombre">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="apellido" class="col-sm-5 col-form-label fw-bold">Ingrese los Apellidos del Docente</label>
              <div class="col-sm-7">
                <input type="text"  name="apellido"  class="form-control" id="apellido">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="correo" class="col-sm-5 col-form-label fw-bold">Ingrese el Correo Institucional del Docente</label>
              <div class="col-sm-7">
                <input type="email"  name="correo"  class="form-control opcional-ingreso" id="correo">
                <div id="correoHelp" class="form-text">Ingrese el correo institucional con ueb. o mailes.</div>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="telefono" class="col-sm-5 col-form-label fw-bold">Ingrese el Numero de Celular del Docente</label>
              <div class="col-sm-7">
                <input type="text" placeholder="Opcional..." name="telefono"  class="form-control opcional-ingreso" id="telefono">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="f_inicial" class="col-sm-5 col-form-label fw-bold">Ingrese la Fecha Inicial del Cargo</label>
              <div class="col-sm-7">
                <input type="date" name="f_inicial" class="form-control" id="f_inicial">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="f_final" class="col-sm-5 col-form-label fw-bold">Ingrese la Fecha Final del Cargo</label>
              <div class="col-sm-7">
                <input type="date" name="f_final" value="dato.total_f_final" class="form-control" id="f_final">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="f_final" class="col-sm-5 col-form-label fw-bold">Selecione la Carrera a la que Pertenece</label>
              <div class="col-sm-7">
              <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="carrera_manual">
                ${select.innerHTML}
              </select>
              </div>
            </div>
            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary text-white">Registrar</button>
              </div>
            </div>
          </div>
          </form>
            `;
        const modalBootstrap =  new bootstrap.Modal(modal,{});
        boton.parentElement.append(modal);
        const form = modal.querySelector('form');
        boton.onclick = (e) => {
            e.preventDefault();
            verficacionesUnicas(form);
            modalBootstrap.show();
        }
    form.addEventListener('submit',e => insertCoordinador(e,modalBootstrap,form));
}
function insertCoordinador(e,modalB,form) {
    e.preventDefault();
    if(verficaciones(form)){
        modalB.hide();
        precarga = new Precarga();
        precarga.run();
        Docentes.sendCoordinador(new FormData(form),'manual')
        .then(respuesta => renderRespuesta(respuesta,form))
        .catch(renderErrores)
        
    }else {
      alerta('alert-warning','Por favor corriga los campos del formulario',2000);
    }
}


function renderRespuesta(respuesta,form) {

  if(respuesta.ident) {
    precarga.end();
     new Notificacion(
         respuesta.mensaje,
         'Aceptar',
         false
     )
     new Notificacion(
      Boolean(respuesta.identEmail) === true ? '' +  respuesta.email : 'Ocurrio un error al enviar el correo electronico <br>' 
      + respuesta.email,
      'Aceptar',
      Boolean(respuesta.identEmail) === true ? false : true
    );
     rebootInputs(form);
    }else{
     throw new Error(respuesta.mensaje);
    }
}

const verificacionDatosInsert = {inputsBlanco: false, cedulaC: false,correoInst: false,select: false};
/**
 * Verifica que no haya ningun error al momento de enviar los datos
 * a guardarse en la DB
 * 
 * @param {*} formulario 
 * @returns {boolean}
 */
 function verficaciones(formulario) {
    const inputs = formulario.querySelectorAll('input:not(.opcional-ingreso)');
    const select = formulario.querySelector('select');
    let arrayInputs = Array.from(inputs);
    verificacionDatosInsert.inputsBlanco = arrayInputs.map(input =>  {  
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
    verificacionDatosInsert.select = select.value !== 'none' ? true : false;

    return Object.values(verificacionDatosInsert).every(v => v === true);
  }

  function verficacionesUnicas(formulario){
    const cedulaInput = formulario.querySelector('#cedula');
    const correo = formulario.querySelector('#correo');
    cedulaInput.oninput = cedulaInput.onchange = () => {
      if(CEDULA_REG_EXPRE.test(cedulaInput.value)){
        verificacionDatosInsert.cedulaC = true;
        if(cedulaInput.classList.contains('is-invalid')){
            cedulaInput.classList.remove('is-invalid')
            cedulaInput.classList.add('is-valid');
          }else{
            cedulaInput.classList.add('is-valid');
          }
      }else {
          cedulaInput.classList.add('is-invalid');
      }
    }

    correo.oninput = correo.onchange = () => {
        if(COREO_INST.test(correo.value)){
            verificacionDatosInsert.correoInst = true;
            if(correo.classList.contains('is-invalid')){
                correo.classList.remove('is-invalid')
                correo.classList.add('is-valid');
              }else{
                correo.classList.add('is-valid');
              }
        }else{
            correo.classList.add('is-invalid');
        }
    }
  }


/**
 * Reicia todos los inputs de un formulario
 * 
 * @param {HTMLFormElement} form 
 */
function rebootInputs(form){
  const inputs = form.querySelectorAll('input');
  const selects = form.querySelectorAll('select');

  inputs.forEach(input => {
    input.value = '';
    if(input.classList.contains('is-valid')) input.classList.remove('is-valid');
  });
  selects.forEach(select => {
    select.value = 'none';
    if(select.classList.contains('is-valid')) select.classList.remove('is-valid');
  })
}