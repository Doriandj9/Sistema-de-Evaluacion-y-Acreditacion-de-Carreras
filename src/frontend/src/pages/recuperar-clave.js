import Precarga from './../modulos/PreCarga/Precarga.js';
import Usuarios from '../models/Usuarios.js';
import Notificacion from '../modulos/Notificacion/Notificacion.js';
import alerta from "./../utiles/alertasBootstrap.js";

const form = document.querySelector('form');
let precarga = null;
form.addEventListener('submit',enviarDatos);

function enviarDatos(e){
    e.preventDefault();
    const form = e.target;
    const input = form.querySelector('input');
    if(input.value.length !== 10){
        alerta(
            'alert-warning',
            'Por favor, ingrese únicamente los 10 dígitos de la cédula',
            5000
        );
        return;
    }
    precarga = new Precarga();
    precarga.run();
    Usuarios.recuperarClave(new FormData(form))
    .then(renderRespuesta)
    .catch(console.log);
}

function renderRespuesta(respuesta) {
    precarga.end();
    if(respuesta.ident) {
        const div = document.createElement('div');
        div.innerHTML = `
            <p class="text-justificado tipografia-times-1 ps-4 pe-4 pt-2">
            ${respuesta.mensaje} <br>
            <a class="text-primary text-decoration-underline d-block text-center" href="/">Regresar</a>
            <p>
        `;
        form.replaceWith(div);
    }else{
        new Notificacion(respuesta.mensaje,'Regresar');
    }
}