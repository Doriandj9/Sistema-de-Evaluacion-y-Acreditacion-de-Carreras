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
		restriciones[usuarios.COORDINADORES] = function () {
			location.href = '/coordinador';
		}
		
        
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
			restriciones[resultado.permisos]();
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
