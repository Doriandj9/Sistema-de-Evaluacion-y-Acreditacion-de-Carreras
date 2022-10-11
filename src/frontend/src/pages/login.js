import Usuarios from "../models/Usuarios.js";
import Notificacion from "../modulos/Notificacion/Notificacion.js";
import Precarga from "../modulos/PreCarga/precarga.js";
const form = document.forms[0];
const usuarios = new Usuarios();
let precarga = undefined;


form.addEventListener("submit", verificarCredenciales);
const restriciones = {};
		restriciones[usuarios.ARMINISTRADOR] = function () {
			location.href = '/admin';
		};
		restriciones['opciones'] = function () {
			location.href = '/opciones';
		};
		restriciones[usuarios.DIRECTOR_PLANEAMIENTO] = function () {
			location.href = '/director-planeamiento';
		};
		
        
function verificarCredenciales(e) {
	e.preventDefault();
    precarga  = new Precarga();
    precarga.run();
	const formData = new FormData(form);
	usuarios
		.verificacionCredenciales(formData)
		.then(verificarUsuario)
		.catch(manejarHerror);
}

function verificarUsuario(resultado) {
	if (resultado.ident) {
		try {
            precarga.end();
            localStorage.Tok_ = resultado.token;
			let refPermisos = [usuarios.ARMINISTRADOR,usuarios.DIRECTOR_PLANEAMIENTO]; // guardamos las dos referencias alos usuarios 
			//que no deben acceder a la vista de opciones
			restriciones[refPermisos.includes(resultado.permisos) ? //a qui condicionamos si el usuario que ingreso es admin o director
				refPermisos[refPermisos.indexOf(resultado.permisos)] : 'opciones']();// si lo es busca el permiso en en refPermisos
				//por otro lado si no es admin o director se redirige hacia la vista de opciones
		} catch (e) {
			console.log(e);
		}
	} else {
		throw new Error(resultado.error)  
	}
}

function manejarHerror(e) {
	precarga.end();
	new Notificacion(
		e,
		'Aceptar'
	)
}
