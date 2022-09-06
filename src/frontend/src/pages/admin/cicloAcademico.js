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
    if(datos.result){
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
    PeriodoAcademico.getDatos()
    .then(renderPeriodosAcademicos)
    .catch(manejarErrores)
}

cargarPeriodosAcademicos();

function renderPeriodosAcademicos(respuesta){
    if(respuesta.ident){
        const {periodoAcademico} = respuesta;
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
        if(finalizar) precarga.end(); // la variable finalizar la primera vez se va encontrar en falso lo cual no ejcutara
        // terminar la precarga ya que si lo hace saltara un erro por que un primer instante la variable es undefined
        // en instancias posteriores se encuentra con la clase de la precarga 
    }else{
        throw new Error(
            'No se pudo cargar la lista de periodos académicos, '+ respuesta.mensaje
            );
    }
    
}

