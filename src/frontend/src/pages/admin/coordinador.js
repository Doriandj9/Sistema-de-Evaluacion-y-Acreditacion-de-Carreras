import Notificacion from "../../modulos/Notificacion/Notificacion.js";
import Precarga from "../../modulos/PreCarga/precarga.js";
import Docentes from "../../models/Docentes.js";

const formulario = document.forms[0];
const [fecha_inicial,fecha_final] = formulario.querySelectorAll('input[type="date"]');
const carreras = formulario.querySelector('#carreras');
const docentes = formulario.querySelector('#coordinador');
let precarga = undefined;
let errores = true;
formulario.addEventListener('submit',verificacionDatos);
carreras.addEventListener('change', getDatosDocentes);
function verificacionDatos(e){
    e.preventDefault();
    precarga = new Precarga();
    precarga.run();
    datosCorrectos();
    if(errores){
        precarga.end();
        new Notificacion(
            'Error no ingreso todos los datos necesarios intentelo nuevamente',
            'Regresar'
        )
    }else{
        const formData = new FormData(formulario);
        Docentes.sendCoordinador(formData)
        .then(renderRespuesta)
        .catch(e => console.log(e));
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
            const {id,nombre} = docente;
            html += `<option value="${id.trim()}">${nombre}</option>`;
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

function renderRespuesta(respuesta){
   precarga.end();
   if(respuesta.ident){
    new Notificacion(
        respuesta.result + ' para la carrera con el identificador ' + carreras.value,
        'Aceptar',
        false
    )
   }
}

function renderErrores(e){
   new Notificacion(
        e,
        'Regresar'
    )
    precarga.end();
} 