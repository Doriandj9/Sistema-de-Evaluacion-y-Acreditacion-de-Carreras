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
const token = localStorage.Tok_;
const tokenDecode = jwt_decode(token);
const menuOpciones = document.getElementById('menu-opciones');
const butonesMenu = menuOpciones.querySelectorAll('button');
const contenido = document.getElementById('contenido');
let usuarioRedirecion = null;
const usuario = new Usuarios();
let redirecionamientos = {};
redirecionamientos[usuario.COORDINADORES] = function(){ location.href = '/coordinador'};
redirecionamientos[usuario.DOCENTES] = function() {location.href = '/docentes'};
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
                <button data-content-id="${carrera.id_carrera.trim()}" title="Ingresar al Sistema SEAC" class="boton boton-enviar is-hover-boton-enviar d-flex align-items-center gap-2">
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
