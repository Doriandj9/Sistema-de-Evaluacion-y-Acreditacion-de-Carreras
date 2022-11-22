import MenuOpcionesSuperior from "../../modulos/MenuOpcionesSuperior/MenuOpcionesSuperior.js";
import Notificacion from "../../modulos/Notificacion/Notificacion.js";
import Precarga from "../../modulos/PreCarga/precarga.js";
import Docentes from "../../models/Docentes.js";
import alerta from "../../utiles/alertasBootstrap.js";
import { paginacionDocentes } from "../../utiles/paginacionDocentesCarrera.js";
import { CEDULA_REG_EXPRE, COREO_INST } from "../../modulos/RegularExpresions/ConstExpres.js";

MenuOpcionesSuperior.correr();
const contenedorVistas = document.getElementById('cambio-vistas');
const [op1,op2] = document.querySelectorAll('#contenedor-menu-superior li');
const htmlOp1 = document.getElementById('template-listar-docentes').innerHTML;
const htmlOp2 = document.getElementById('template-registar-docentes').innerHTML;

let precarga = null;
MenuOpcionesSuperior.renderVistasAcciones([
    [op1,htmlOp1,accionListar,'focus'],
    [op2,htmlOp2,accionRegistrar]
]);
/**----------------------------------- Opciones de la primera opcion --------------------------------------- */
function accionListar() {
    listarDocentes();
}
function listarDocentes() {
    Docentes.obtenerDocentesDeCarrera()
    .then(renderDocentes)
    .catch(console.log)
}

function renderDocentes(respuesta){
    if(respuesta.ident){
        const tbody = contenedorVistas.querySelector('tbody');
        const contenedorNumeros = contenedorVistas.querySelector('.contenedor-numeros-paginacion');
        const busqueda = document.getElementById('busqueda');
        const {docentes} = respuesta;
        paginacionDocentes(docentes,8,1,tbody,contenedorNumeros);
        //spinner.remove();
        busqueda.addEventListener('input',(function(coordinator){
            return () => {
            paginacionDocentes(coordinator,8,1,tbody,contenedorNumeros,null,'nombre',busqueda.value.trim());
            };
        })(docentes))
      }else{
        spinner.remove();
        alerta('alert-danger','Error del servidor',3000);
      }
}
/**----------------------------------- Opciones de la segundo opcion --------------------------------------- */
// variables globales para registrar un docente

function accionRegistrar() {
    const form = document.getElementById('form-insert');
    const cedula = form.querySelector('#cedula');
    cedula.addEventListener('change',consultarDatos);
    form.addEventListener('submit' ,e => registrarDocente(e,form));
}

function consultarDatos(e) {
    const valorCedula = e.target.value.trim();
    Docentes.obtenerDatosDocente(valorCedula)
    .then(renderDatosForm)
    .catch(console.log);
}

function renderDatosForm(respuesta) {
    const form = document.getElementById('form-insert');
    const cedula = form.querySelector('#cedula');
    const nombres = form.querySelector('#nombres');
    const apellidos = form.querySelector('#apellidos');
    const correo = form.querySelector('#correo');
    if(respuesta.ident) {
        const {docente} = respuesta;
        cedula.setAttribute('disabled','');
        nombres.value = docente.nombre;
        apellidos.value = docente.apellido;
        correo.value = docente.correo;
        nombres.setAttribute('disabled','');
        apellidos.setAttribute('disabled','');
        correo.setAttribute('disabled','');
    } else {
        alerta('alert-warning',
        'No existe este doncente registrado en la base datos, si lo registra asegurese de ingresar los datos correctos del docente',
        10000
        )
    }
}

function registrarDocente(e,form) {
    e.preventDefault();
    precarga = new Precarga();
    precarga.run();
    const formData = new FormData();
    const cedula = form.querySelector('#cedula');
    const nombres = form.querySelector('#nombres');
    const apellidos = form.querySelector('#apellidos');
    const correo = form.querySelector('#correo');
    const fecha_inicial = form.querySelector('#f_i');
    const fecha_final = form.querySelector('#f_f');
    formData.append('cedula',cedula.value.trim())
    formData.append('nombres',nombres.value.trim())
    formData.append('apellidos',apellidos.value.trim())
    formData.append('correo',correo.value.trim())
    formData.append('f_i',fecha_inicial.value.trim())
    formData.append('f_f',fecha_final.value.trim())
    console.log([...formData]);
    Docentes.sendDocenteACarrera(formData)
    .then(renderRespuesta)
    .catch(console.log)
}


function renderRespuesta(respuesta) {
    precarga.end();
    if(respuesta.ident) {
        new Notificacion(respuesta.mensaje,'Aceptar',false);
        if(respuesta.identEmail) {
            new Notificacion(
                Boolean(respuesta.identEmail) === true ? '' +  respuesta.email : 'Ocurrio un error al enviar el correo electronico <br>' 
                + respuesta.email,
                'Aceptar',
                Boolean(respuesta.identEmail) === true ? false : true
              );
        }
    }else {
        new Notificacion(respuesta.mensaje,'Regresar');
    }
}