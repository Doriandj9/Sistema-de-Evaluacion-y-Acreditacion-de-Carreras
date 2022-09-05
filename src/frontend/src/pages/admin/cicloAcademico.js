import { PERIODO_ACADEMICO } from "../../modulos/RegularExpresions/ConstExpres.js";
import PeriodoAcademico from "../../models/PeriodoAcademico.js";
import Notificacion from "../../modulos/Notificacion/Notificacion.js";
import Precarga from "../../modulos/PreCarga/precarga.js";

const inputCicloAcademico = document.getElementById('ciclo-academico');
const mensajeError = document.querySelector('.mensaje-error');
const formulario = document.forms[0];
const tablaPresentacion = document.getElementById('tabla-presentacion');
let errores = true;
let precarga = undefined;
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
    if(datos.result){
        precarga.end();
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
            'Error ' + datos.error,
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
    //precarga = new Precarga();
    //precarga.run();
    // console.log(e)
    PeriodoAcademico.getDatos()
    .then(renderPeriodosAcademicos)
    .catch(manejarErrores)
}

cargarPeriodosAcademicos();

function renderPeriodosAcademicos({periodoAcademico} = datos){
    let html = '';
    const tbody = tablaPresentacion.querySelector('tbody');
    periodoAcademico.forEach(periodo => {
        html += `<tr>
        <td>
           ${periodo.id}
        </td>
        <td>
           ${periodo.fecha_inicial}
        </td>
        <td>
            ${periodo.fecha_final}
        </td>
        <td>
            <button class="boton boton-enviar is-hover-boton-enviar block centrado-linea boton-iconos">
            <span class="material-icons text-blanco">&#xe3c9;</span>
            Editar 
            </button>
        </td>
    </tr>`;
    });
    tbody.innerHTML = html;
}

