import MenuOpcionesSuperior from "../../modulos/MenuOpcionesSuperior/MenuOpcionesSuperior.js";
import alerta from "../../utiles/alertasBootstrap.js";
import Evidencias from "../../models/Evidencias.js";
import Precarga from "../../modulos/PreCarga/Precarga.js";
import Notificacion from "./../../modulos/Notificacion/Notificacion.js"
import Usuarios from "../../models/Usuarios.js";
import { paginacionEvaluadores, paginacionEvaluadoresInsertar } from "../../utiles/paginacionEvaluadores.js";
import Carreras from "../../models/Carreras.js";


MenuOpcionesSuperior.correr();
const contenedorVistas = document.getElementById('cambio-vistas');
const [op1,op2] = document.querySelectorAll('#contenedor-menu-superior li');
const htmlOp1 = document.getElementById('template-listar-evaluadores').innerHTML;
const htmlOp2 = document.getElementById('template-registar-evaluadores').innerHTML;
let precarga = null;
let spinner = document.createElement('div');
spinner.classList = 'spinner-border text-dark carga-medio';
spinner.setAttribute('role','status');
spinner.innerHTML = `<span class="visually-hidden">Loading...</span>`;


MenuOpcionesSuperior.renderVistasAcciones([
    [op1,htmlOp1,accionListar,'focus'],
    [op2,htmlOp2,accionRegistrar]
]);


/**----------------TODO: Primera opcion listar Evaluadores------------------------------ */

function accionListar(){
    listarEvaluadores();
}

function listarEvaluadores() {
    Usuarios.obtenerEvaluadores()
    .then(renderEvaluadores)
    .catch(console.log)
}
function renderEvaluadores(respuesta) {
    if(respuesta.ident) {
        const tbody = contenedorVistas.querySelector('tbody');
        const contenedorNumeros = contenedorVistas.querySelector('.contenedor-numeros-paginacion');
        const busqueda = document.getElementById('busqueda');
        const {evaluadores} = respuesta;
        paginacionEvaluadores(evaluadores,8,1,tbody,contenedorNumeros);
        busqueda.addEventListener('input',(function(evaluadores){
            return () => {
            paginacionEvaluadores(evaluadores,8,1,tbody,contenedorNumeros,null,'nombre_docente',busqueda.value.trim());
            };
        })(evaluadores))
    }else {
        alerta('alert-danger','Error de carga en el servidor intentelo mas tarde.',3500);
    }
}
/**---------------TODO: Segunda opcion registrar Evaluadores--------------------------- */
function accionRegistrar() {
    listarEvaluadoresInsert();
    registarEvaluador();
}


function listarEvaluadoresInsert() {
    Usuarios.obtenerEvaluadores()
    .then(renderEvaluadoresInsert)
    .catch(console.log)
}

function renderEvaluadoresInsert(respuesta) {
    if(respuesta.ident) {
        const tbody = contenedorVistas.querySelector('tbody');
        const contenedorNumeros = contenedorVistas.querySelector('.contenedor-numeros-paginacion');
        const busqueda = document.getElementById('busqueda');
        const {evaluadores} = respuesta;
        paginacionEvaluadoresInsertar(evaluadores,4,1,tbody,contenedorNumeros,accionRefescarInsert);
        busqueda.addEventListener('input',(function(evaluadores){
            return () => {
            paginacionEvaluadoresInsertar(evaluadores,4,1,tbody,contenedorNumeros,accionRefescarInsert,'nombre_docente',busqueda.value.trim());
            accionRefescarInsert();
            };
        })(evaluadores))
        accionRefescarInsert();
    }else {
        alerta('alert-danger','Error de carga en el servidor intentelo mas tarde.',3500);
    }
}

function accionRefescarInsert() {
    const tbody = contenedorVistas.querySelector('tbody');
    const ckeckboxs = tbody.querySelectorAll('input[type=checkbox]');
    ckeckboxs.forEach(check => {
        check.addEventListener('click',() => {
            check.setAttribute('objetivo','true');
            const checks = Array.from(tbody.querySelectorAll('input[type=checkbox]'))
            .filter(ch => {
                if(!ch.hasAttribute('objetivo')) return true;
                return false;
            });
            checks.forEach(c => {
                c.checked = false;
            })
            check.removeAttribute('objetivo');
        })
    })
}

function registarEvaluador() {
    Carreras.getCarreras()
    .then(renderCarreras)
    .catch(console.log)
    const form = contenedorVistas.querySelector('form');
    form.addEventListener('submit',enviarEvaluador);
}

function renderCarreras(respuesta) {
    if(respuesta.ident) {
        const {carreras} = respuesta;
        const contenedor = contenedorVistas.querySelector('#carreras');
        let html = '';

        carreras.forEach((carrera,i) => {
            html += `
            <div class="d-flex gap-2 align-items-center">
            <label for="${i}">${carrera.nombre_carrera} </label> <input type="checkbox" value="${carrera.id_carrera}" name="carreras[]" id="${i}">
            </div>
            `;
        })

        contenedor.innerHTML = html;
    }else{
        alerta('alert-danger','Error en el servidor intentelo mas tarde.',3500);
    }
}

function enviarEvaluador(e){
    e.preventDefault();
    const form = e.target;
    const tbody = contenedorVistas.querySelector('tbody');
    const [check] = tbody.querySelectorAll('input[type=checkbox]:checked');
    const select = contenedorVistas.querySelector('#periodos');
    const checkeds= form.querySelectorAll('input[type=checkbox]:checked')
    const varf = select.value;
    const optios = select.querySelectorAll('option');
    const [option] = Array.from(optios).filter(op => op.value === varf);
    const [fecha_inicial,fecha_final] = form.querySelectorAll('input[type=date]');
    const fecha_inicial_periodo = option.dataset.fInicial.trim().split('-');
    const f_i = fecha_inicial.value.split('-');
    let date = new Date(`${f_i[1]}-${f_i[2]}-${f_i[0]}`);
    let datePeriodo = new Date(`${fecha_inicial_periodo[1]}-${fecha_inicial_periodo[2]}-${fecha_inicial_periodo[0]}`);
    if(bowser.name.includes('Firefox')){
        date = new Date(f_i.join('/'));
        datePeriodo = new Date(option.dataset.fInicial.trim().replace(/-/g,'/'));
    }
    if(!check) {
        alerta('alert-warning','Por favor selecione un docente para evaluador.',3500);
        return;
    }
    if(checkeds.length <= 0) {
        alerta('alert-warning','Por favor, selecione al menos una carrera para la evaluación',3500);
        return;
    }

    if(!(date.getTime() >= datePeriodo.getTime())){
        alerta('alert-warning','El tiempo que ingreso debe ser mayor a la fecha inicial '+
        'del periodo academico ' + fecha_inicial_periodo.join('-'),5000);
        return;
    }
    if(fecha_final.value === ''){
        alerta('alert-warning', 'Ingrese un fecha limite que indique hasta que fecha se pueden ingresar las evidencia a cargo del docente',5000);
        return;
    }

    precarga = new Precarga();
    precarga.run();
    const formData= new FormData(form);
    formData.append('cedula',check.value.trim());
    Usuarios.registrarEvaluadoresACarreras(formData)
    .then(renderRespuesta)
    .catch(console.log)
}

function renderRespuesta(respuesta) {
    precarga.end();
    if(respuesta.ident) {
        new Notificacion(respuesta.mensaje,'Aceptar',false);
    }else{
        new Notificacion(respuesta.mensaje,'Regresar');
    }

}