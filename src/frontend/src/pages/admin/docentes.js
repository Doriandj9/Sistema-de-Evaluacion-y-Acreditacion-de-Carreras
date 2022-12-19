import alerta from "./../../utiles/alertasBootstrap.js";
import Usuarios from "./../../models/Usuarios.js"
import Notificacion from "./../../modulos/Notificacion/Notificacion.js"
import Precarga from "./../../modulos/PreCarga/Precarga.js";

const form = document.querySelector('form');
const file = form.querySelector('input[type=file]');
let precarga  = null;
file.addEventListener('change',mostrarNombre);
form.addEventListener('submit',enviarDatos);

function mostrarNombre(e){
    const file = e.target.files[0];
    const name = file.name;
    const nombreArchivo  = form.querySelector('#nombre-archivo');
    nombreArchivo.textContent = name;
}


function enviarDatos(e){
    e.preventDefault();
    if(file.files.length <= 0){
        alerta('alert-warning','Debe selecionar primero un archivo csv para continuar',4000);
    }
    precarga = new Precarga();
    precarga.run();
    Usuarios.actualizarDocentes(new FormData(form))
    .then(renderRespuesta)
    .catch(console.log)
}

function renderRespuesta(respuesta) {
    precarga.end();
    const {errores,mensaje} = respuesta;
    const erroresTbody = document.getElementById('errores');
    if(errores.length <= 0) {
        new Notificacion(mensaje,'Aceptar',false);
        return;
    }
    let html = '';
    errores.forEach(e => {
        html += `
        <tr>
            <td class="bg-color-gris">${e}</td>
        </tr>
        `;
    })
    erroresTbody.innerHTML = html;
}