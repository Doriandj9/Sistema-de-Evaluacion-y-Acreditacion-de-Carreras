import { PERIODO_ACADEMICO } from "../../modulos/RegularExpresions/ConstExpres.js";
import PeriodoAcademico from "../../models/PeriodoAcademico.js";
import Notificacion from "../../modulos/Notificacion/Notificacion.js";
import Precarga from "../../modulos/PreCarga/precarga.js";
import { paginacionCicloAcademico } from "../../utiles/funcionesPaginacion.js";

const inputCicloAcademico = document.getElementById('ciclo-academico');
const mensajeError = document.querySelector('.mensaje-error');
const formulario = document.forms[0];
const tablaPresentacion = document.getElementById('tabla-presentacion');
let errores = true;
let precarga = undefined;
let finalizar = false; // esta variable funciona como bandera para cuando llamen a un renderPeriodosAcedemicos
// cuando ingresan un nuevo periodo se renderize lo recien ingresado por medio de la peticion al servidor pero 
// que el usuario vea que esta cargando los periodos academicos 
function verdatos(e){
    e.preventDefault();
}
formulario.addEventListener('submit',enviarDatos);
inputCicloAcademico.addEventListener('input',verificacionEntrada);
// Le damos un evento de carga js para cuando acabe de cargar el script js presentar los periodos academicos en la tabla
 window.addEventListener('load',verdatos);

function enviarDatos(e){
    e.preventDefault();
    if(errores){
        new Notificacion(
            'Por favor revise que todos los parametros se encuentren correctamente ingresados',
            'Regresar'
        );

    }else{
        precarga = new Precarga();
        precarga.run();
        accionEnviar();
    }
}

function verificacionEntrada(e){
    e.preventDefault();
    if(PERIODO_ACADEMICO.test(e.target.value)){
        mensajeError.classList.add('oculto');
        errores = false;
    }else{
        mensajeError.classList.remove('oculto');
        errores = true;
    }
}


async function accionEnviar(){
        const formData = new FormData(formulario);
        const respuesta = PeriodoAcademico.enviarDatos(formData);
        respuesta.then(render)
        .catch(manejarErrores);
}

function render(datos){
    if(datos.ident){
        finalizar = true; // Aqui cambiamos la variable a true para que tenga acceso la funcion de rendirazdo de los periodos
        // academicos a finalizar la precarga despues de que esta haya rendirazados todos los ciclos academicos
        cargarPeriodosAcademicos();
        new Notificacion(
            'Se guardo con exito el nuevo periodo academico',
            'Aceptar',
            false
            )
        errores = true;
        inputCicloAcademico.value = '';
    }else{
        precarga.end();
        new Notificacion(
            'Error ' + datos.mensaje,
            'Regresar'
        )
    }


}

function manejarErrores(e){
    new Notificacion(
        e,
        'Regresar'
    );
}

async function cargarPeriodosAcademicos(){
    PeriodoAcademico.getDatos()
    .then(renderPeriodosAcademicos)
    .catch(manejarErrores)
}

cargarPeriodosAcademicos();

function renderPeriodosAcademicos(respuesta){
    if(respuesta.ident){
        const {periodoAcademico} = respuesta;

        const tbody = tablaPresentacion.querySelector('tbody');
        const contendedorNumeros = document.querySelector('.contenedor-numeros-paginacion');
        paginacionCicloAcademico(periodoAcademico,3,1,tbody,contendedorNumeros); // rederiza la tabla paginada
        if(finalizar) precarga.end(); // la variable finalizar la primera vez se va encontrar en falso lo cual no ejcutara
        // terminar la precarga ya que si lo hace saltara un erro por que un primer instante la variable es undefined
        // en instancias posteriores se encuentra con la clase de la precarga
        scriptEditarPeriodoAcademico(); // llamamos a esta funcion para se activen a los botones la opcion
    }else{                              // de editar un periodo academico
        throw new Error(
            'No se pudo cargar la lista de periodos académicos, '+ respuesta.mensaje
            );
    }
    
}


/**
 * TODO: Editar un periodo academico
 * siempre y cuando ya se hayan renderizado
 */

function scriptEditarPeriodoAcademico(){
const formsEditar = Array.from(tablaPresentacion.querySelectorAll('form'));

let confirm = false; // Es una bandera para enviar los datos a editar
/**
 * Este codigo realiza un recorrido por los formularios brindandole eventos
 * 1. Evento de cambio del formulario para poder saber que se puede enviar esos datos a la BD
 * cambiando el estado de la bandera confirm a true
 * 2. Evento de submit al formulario para cuando se envie hacerlo con el modelo correspondiente
 * 3. Dentro del bucle forEach se inicializa un modal de bootstrap para luego si confirm es true
 * se oculta el modal para no tener problemas con el nuevo renderizado del DOOM
 */
formsEditar.forEach(form => {
    const modal =  new bootstrap.Modal(form.querySelector('.modal'),{}); // Es un modal de bootstrap para luego cerrarlo autmaicamente en algun punto
    form.addEventListener('change',() => {
        confirm = true;
    });// si escucha algun cambio el furmulario activa la opcion 
    form.addEventListener('submit',(e) => editarPeriodoAcademico(e,form,modal));// para enviar los datos del formulario a editarse en la BD
                                        
})

    function editarPeriodoAcademico(e,form,modal){
        e.preventDefault();
        const formData = new FormData(form);
        if(confirm){ // Si es verdadera se precede a enviar los datos
            modal.hide();
            precarga = new Precarga();
            precarga.run();
            finalizar = true;
            PeriodoAcademico.editarDatos(formData)
            .then(renderPeriodosAcademicosEditados)
            .catch(manejarErrores);
        }else{
            const alerta = document.createElement('div');
            alerta.classList = 'contenedor-alert-1';
            alerta.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="info-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </symbol>
                </svg>
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                    <div>
                        No ha realizado ningun cambio
                    </div>
                </div>
            `;
            form.append(alerta);
            setTimeout(() => {// Este codigo elimina la alerta automaticamene luego de 1 segundo
                alerta.remove();
            },1000)
        }
    }
}


function renderPeriodosAcademicosEditados(respuesta){
    if(respuesta.ident){
        const notificacion = document.createElement('div');
        notificacion.className = 'contenedor-alert-1';
        notificacion.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        </svg>
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
                Se actualizo correctamente el periodo académico
            </div>
        </div>
        `;
        formulario.append(notificacion);
        cargarPeriodosAcademicos();
        setInterval(() => { // Elimina la notificacion automaticamente luego de 2 segundos
            notificacion.remove();
        },2000);
    }else{
        const notificacion = document.createElement('div');
        notificacion.className = 'contenedor-alert-1';
        notificacion.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
        </svg>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
                ${respuesta.mensaje}
            </div>
        </div>
        `;
        formulario.append(notificacion);
        cargarPeriodosAcademicos();
        setInterval(() => { // Elimina la notificacion automaticamente luego de 2 segundos
            notificacion.remove();
        },2000);
    }
}

export{scriptEditarPeriodoAcademico}; // Esta funcion se exporta a las funciones de paginacion para 
// que se actualize los modales para darles sus respectivos eventos