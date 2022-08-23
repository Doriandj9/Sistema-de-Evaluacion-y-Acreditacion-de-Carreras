import { PERIODO_ACADEMICO } from "../../modulos/RegularExpresions/ConstExpres.js";
import Notificacion from "../../modulos/Notificacion/Notificacion.js";
import Precarga from "../../modulos/PreCarga/precarga.js";

const inputCicloAcademico = document.getElementById('ciclo-academico');
const mensajeError = document.querySelector('.mensaje-error');
const formulario = document.forms[0];
let errores = true;
let precarga = undefined;
formulario.addEventListener('submit',enviarDatos);
inputCicloAcademico.addEventListener('input',verificacionEntrada);
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
    }
}


async function accionEnviar(){

    try {
        const formData = new FormData(formulario);
        const peticion = await fetch('/admin/agregar/ciclo/academico',{method:'POST',body:formData})
        const respuesta = await peticion.json();
        render(respuesta);
    } catch (error) {
        console.error(error);
    }
}

function render(datos){

    if(datos.result){
        precarga.end();
        new Notificacion(
            'Se guardo con exito el nuevo periodo academico sdasdadassssssss ssssssssssssssssssad ddddddddddddddddddddaaaaaaadddddddddddas',
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
