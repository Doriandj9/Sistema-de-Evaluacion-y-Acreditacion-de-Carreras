import Facultad from "../../models/Facultad.js";
import Precarga from "./../../modulos/PreCarga/Precarga.js"
import { paginacionFacultades } from "../../utiles/funcionesPaginacionFacultades.js";
import Notificacion from "../../modulos/Notificacion/Notificacion.js";
const tablaPresentacion = document.getElementById('tabla-presentacion');
let errores = true;
let precarga = undefined;
let finalizar = false; // esta variable funciona como bandera para cuando llamen a un renderPeriodosAcedemicos
// cuando ingresan un nuevo periodo se renderize lo recien ingresado por medio de la peticion al servidor pero 
// que el usuario vea que esta cargando los periodos academicos
cargarFacultades();
function cargarFacultades() {
    Facultad.obtenerFacultades()
    .then(renderFacultades)
    .catch(renderErrores);
}

function renderFacultades(respuesta) {
    if(respuesta.ident){
        const {facultades} = respuesta;
        const tbody = tablaPresentacion.querySelector('tbody');
        const contendedorNumeros = document.querySelector('.contenedor-numeros-paginacion');
        paginacionFacultades(facultades,3,1,tbody,contendedorNumeros); // rederiza la tabla paginada
        if(finalizar) precarga.end(); // la variable finalizar la primera vez se va encontrar en falso lo cual no ejcutara
        // terminar la precarga ya que si lo hace saltara un erro por que un primer instante la variable es undefined
        // en instancias posteriores se encuentra con la clase de la precarga
        scriptEditarFacultad(); // llamamos a esta funcion para se activen a los botones la opcion
    }else{                              // de editar un periodo academico
        throw new Error(
            'No se pudo cargar la lista de facultades, '+ respuesta.mensaje
            );
    }
}

/**
 * TODO: Editar un periodo academico
 * siempre y cuando ya se hayan renderizado
 */

 export function scriptEditarFacultad(){
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
        const modal =  new bootstrap.Modal(form.querySelector('.modal'),{backdrop:'static'}); // Es un modal de bootstrap para luego cerrarlo autmaicamente en algun punto
        form.addEventListener('change',() => {
            confirm = true;
        });// si escucha algun cambio el furmulario activa la opcion 
        form.addEventListener('submit',(e) => editarFacultad(e,form,modal));// para enviar los datos del formulario a editarse en la BD
                                            
    })
    
        function editarFacultad(e,form,modal){
            e.preventDefault();
            const formData = new FormData(form);
            if(confirm){ // Si es verdadera se precede a enviar los datos
               modal.hide();
               document.body.querySelectorAll('.modal-backdrop.fade.show') // bug de modales resueltos con esta linea
               .forEach(mod => mod.remove());// y esta
                precarga = new Precarga();
                precarga.run();
                finalizar = true;
                Facultad.editarFacultad(formData)
                .then(renderFacultadesEditas)
                .catch(renderErrores);
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


function renderErrores(e) {
    console.log(e);
}

function renderFacultadesEditas(respuesta) {
    if(respuesta.ident) {
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
        document.body.append(notificacion);
        cargarFacultades();
        setInterval(() => { // Elimina la notificacion automaticamente luego de 2 segundos
            notificacion.remove();
        },2000);
    }else {
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
        precarga.end();
        document.body.append(notificacion);
        setInterval(() => { // Elimina la notificacion automaticamente luego de 2 segundos
            notificacion.remove();
        },2000);
    }
}


/**-----------------------------------Insertar una nueva facultad------------------------------------ */

const formulario = document.getElementById('form-facultades-insertar');
const [input_id_facultad,input_nombre_facultad] = formulario.querySelectorAll('input');
let verificaciones = {input_blanco: false};

formulario.addEventListener('submit',enviarDatos);

function enviarDatos(e) {
    e.preventDefault();
    if(verificacion()) {
        precarga = new Precarga;
        precarga.run();
        finalizar = true;
        Facultad.insertarFacultad(new FormData(formulario))
        .then(renderFacultadesInsertada)
        .catch(renderErrores);
    }else {
        console.log(verificaciones);
    }
}
function renderFacultadesInsertada(respuesta) {
    if(respuesta.ident) {
        new Notificacion(respuesta.mensaje,'Aceptar',false);
        cargarFacultades();
    }else {
        new Notificacion(respuesta.mensaje,'Regresar');
        precarga.end();
    }
}


function verificacion() {
   let res = [input_id_facultad,input_nombre_facultad].every(input => input.value !== '');
   verificaciones.input_blanco = res;
    return Object.values(verificaciones).every(valor => valor === true);
}