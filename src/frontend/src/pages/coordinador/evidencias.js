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
const htmlOp1 = document.getElementById('template-listar-evidencias').innerHTML;
const htmlOp2 = htmlOp1;

MenuOpcionesSuperior.renderVistasAcciones([
    [op1,htmlOp1,accionListar,'focus'],
    [op2,htmlOp2,accionRegistrar]
]);

function accionListar() {

}

function accionRegistrar() {

}