import './../../node_modules/jwt-decode/build/jwt-decode.js'; // este script agregar al objeto global la funcion jwt_decode
// que se utiliza luego para decodifcar el token
import Usuarios from '../models/Usuarios.js';
import Precarga from './../modulos/PreCarga/Precarga.js';
import './../utiles/funciones-cookies.js'; // este escript agrega al objeto global las funciones para obtener las cookies o
//agregar nuevas
import Notificacion from './../modulos/Notificacion/Notificacion.js';
/**
 * Esta funcion de llamado inmediato coloca la hora y la fecha en la vista
 * 
 */
(function(){
    const fecha = document.getElementById('fecha');
    const  hora = document.getElementById('hora');
    let date = new Date();
        let hour = date.getHours().toString().length < 2 ? '0' + date.getHours().toString() : date.getHours().toString() 
        + ' : ' + (date.getMinutes().toString().length < 2 ? '0' + date.getMinutes().toString() : date.getMinutes());
        let formatDate = Intl.DateTimeFormat('es',{dateStyle:'full'}).format;
        fecha.innerText = formatDate(date)[0].toUpperCase() + formatDate(date).substring(1);
        hora.innerText = hour;
    setInterval(() => {
        date = new Date();
        hour = date.getHours().toString().length < 2 ? '0' + date.getHours().toString() : date.getHours().toString() 
        + ' : ' + (date.getMinutes().toString().length < 2 ? '0' + date.getMinutes().toString() : date.getMinutes());
        fecha.innerText = formatDate(date)[0].toUpperCase() + formatDate(date).substring(1);
        hora.innerText = hour;
    },1000 );

})();
/**
 * Esta funcion de llamado inmediato verifica si el usuario tiene requerir obligadamente el cambio de clave
 * 
 */
(function () {
    const verifcacionCambio = document.getElementById('cambio-clave');
    if(!verifcacionCambio || verifcacionCambio.value == false) return;
    const verificaciones = {claveActual: false, claveRepetida: false};
    import('./../utiles/cambio-clave.js')
    .then(funciones => {
        const {mostrarUICambioClave,cambiarClave} = funciones;
        mostrarUICambioClave();
        const botonEnvio = document.getElementById('enviarDatos');
        const form = document.getElementById('form-cambio-clave');
        const [claveActual,nuevaClave,claveRepetida] = form.querySelectorAll('input');
        const spinner = document.createElement('div');
        spinner.className = 'spinner-border text-primary';
        spinner.setAttribute('role','status');
        spinner.innerHTML = `<span class="visually-hidden">Loading...</span>`;
        claveActual.addEventListener('change', (e) => {
            const contenedor = claveActual.parentElement.parentElement;
            contenedor.append(spinner);
            Usuarios.comprobacionClave(e.target.value.trim())
            .then((respuesta) => {
                spinner.remove();
                claveActual.nextElementSibling.style.right = '2rem';
                if(respuesta.ident){
                    if(claveActual.classList.contains('is-invalid')) claveActual.classList.remove('is-invalid');
                    claveActual.classList.add('is-valid');
                    verificaciones.claveActual = true;
                }else {
                    if(claveActual.classList.contains('is-valid')) claveActual.classList.remove('is-valid');
                    claveActual.classList.add('is-invalid');
                    verificaciones.claveActual = false;
                }
            }).catch(e => console.log(e));
        })

        claveRepetida.addEventListener('change', (e) => {
            claveRepetida.nextElementSibling.style.right = '2rem';
            if(nuevaClave.value.trim() === claveRepetida.value.trim()){
                if(claveRepetida.classList.contains('is-invalid')) claveRepetida.classList.remove('is-invalid');
                    claveRepetida.classList.add('is-valid');
                    verificaciones.claveRepetida = true;
            }else {
                if(claveRepetida.classList.contains('is-valid')) claveRepetida.classList.remove('is-valid');
                    claveRepetida.classList.add('is-invalid');
                    verificaciones.claveRepetida = false;
            }
        })

        botonEnvio.addEventListener('click', (e) => {
            e.preventDefault();
            if(Object.values(verificaciones).every(respuestas => respuestas === true)){
                const usuario = jwt_decode(localStorage.Tok_);
                cambiarClave(usuario.id_usuario,claveRepetida.value.trim())
                .then((respuesta) => {
                    if(respuesta.ident) {
                        new Notificacion(
                            'Se actualizo correctamente su nueva contraseña',
                            'Aceptar',
                            false
                        );
                    }else {
                        new Notificacion(
                            'A ocurrido un error por favor intentelo mas tarde',
                            'Regresar'
                        );
                    }
                })
                .catch(renderError); 
            }else {
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
                            Revise nuevamente los campos, uno o varios son incorrectos
                        </div>
                    </div>
                `;
                form.append(alerta);
                setTimeout(() => {// Este codigo elimina la alerta automaticamene luego de 1 segundo
                    alerta.remove();
                },3000)
            }
        })
    })
    .catch(e  => console.log(e));

})();
const token = localStorage.Tok_;
const tokenDecode = jwt_decode(token);
const menuOpciones = document.getElementById('menu-opciones');
const butonesMenu = menuOpciones.querySelectorAll('button');
const contenido = document.getElementById('contenido');
let usuarioRedirecion = null;
const usuario = new Usuarios();
let redirecionamientos = {};
redirecionamientos[usuario.COORDINADORES] = function(){ location.href = '/coordinador'};
redirecionamientos[usuario.DOCENTES] = function() {location.href = '/docente'};
redirecionamientos[usuario.EVALUADOR] = function() {location.href = '/evaluador'};
redirecionamientos[usuario.SECRETARIAS] = function() {location.href = '/secretaria'}; 
let preCarga = null;
butonesMenu.forEach(boton => {
    boton.addEventListener('click',(e) => verificacionPermisos(e,boton));
})

function verificacionPermisos(e,boton) {
    e.preventDefault();
    const {permisos} = tokenDecode;
    const {id_usuario} = tokenDecode;
    const permisoComparacion  = boton.dataset.contentPermision;
    if(permisos.includes(Number(permisoComparacion))){
        usuarioRedirecion = Number(permisoComparacion);
        preCarga = new Precarga();
        preCarga.run();
        Usuarios.getCarrerasPorUsuario(Number(permisoComparacion),id_usuario)
        .then(renderCarreras);
    }else {
       renderUsuarioNoAutorizado();
    }
}


function renderUsuarioNoAutorizado(){
    const html = `<div class="w-50">
    <div class="bg-primary text-white d-flex justify-content-center align-items-center pt-3 pb-3 gap-2">
    <span class="material-icons text-warning">&#xe002;</span> <span>Advertencia!!</span> 
    </div>
    <div class="contenedor-mensaje-no-autorizado">
        <img src="/public/assets/img/undraw_warning_re_eoyh.svg" alt="Advertencia">
        <p class="text-center">El usuario o contraseña ingresados son incorrectos. Contáctese con el Administrador del Sistema...</p>
    </div>
    </div>`;
    contenido.innerHTML = html;
}


function renderCarreras(resultado){
    if(resultado.ident){
        const {carreras} = resultado;
        let trs = '';
        carreras.forEach(carrera => {
                trs += `<tr>
                <td class="text-center">${carrera.nombre}</td>
                <td class="text-center  d-flex justify-content-center">
                <button ${carrera.estado !== 'activo' ? 'disabled title="Consulte con el administrador o coorinador de carrera"' :
                 'title="Ingresar al Sistema SEAC"'} 
                 data-content-id="${carrera.estado !== 'activo' ? '' : carrera.id_carrera.trim()}"  
                 class="boton boton-enviar is-hover-boton-enviar d-flex align-items-center gap-2 ${carrera.estado !== 'activo' ? 'desactivado' : ''} ">
                <span class="material-icons text-white">&#xeb38;</span>
                <span class="">Ingresar</span>
                </button>
                </td>
                </tr>`;
        });
        let html = `
        <div class="w-50 h-75">
            <table class="tabla tabla-contenido-2" id="tabla-carreras">
                <thead>
                    <tr>
                    <th colspan="2">Seleccione una Carrera para Ingresar al Sistema</th>
                    </tr>
                </thead>
                <tbody>
                    ${trs}
                </tbody>
            </table>
        </div>
        `;
        contenido.innerHTML = html;
        preCarga.end();

        redirecionamientoUsuario();
    }
}

/**--------------------- Script para redirigir segun la carrera y el usuario coordinador,docente,evaluador,secretaria----------------- */

function redirecionamientoUsuario(){
    const botones = document.querySelectorAll('#tabla-carreras button');
    botones.forEach(boton => {
            boton.addEventListener('click',(e) => redirecion(e,boton));
    })
}


function redirecion(e,boton) {
    e.preventDefault();
    if(!boton.hasAttribute('data-content-id') || boton.getAttribute('data-content-id') === '') return;
    const id_carrera = boton.dataset.contentId;
    Usuarios.sendOpciones(usuarioRedirecion,id_carrera)
    .then(renderRespuesta)
    .catch(renderError);
}

function renderRespuesta (respuesta) {
    if(respuesta.ident) {
     redirecionamientos[usuarioRedirecion]();
    }else {
        new Notificacion(
            respuesta.mensaje,
            'Regresar'
        )
    }
}

function renderError(e) {
    new Notificacion(
        e,
        'Regresar'
    )
}
