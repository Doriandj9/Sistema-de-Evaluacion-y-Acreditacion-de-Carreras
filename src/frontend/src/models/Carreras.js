export default class Carreras {
/**
 * 
 * @param {*} action es la opcion que si manda el id de la carrera obtiene la carrera | id facultad 
 * obtiene las carreras de la facultad [los valores son: facultad y carrera]
 * @param {*} value es el id de cada una de las acciones como el id de la carrera y el id de la facultad
 * @returns 
 */
    static async getCarreras(action = null, value = null) {
        try {
            const headers = new Headers();
            if(localStorage.Tok_){
                headers.append('token_autorizacion',localStorage.Tok_);
            }
            if(action && value) {
                const consulta = await fetch(`/datos/carreras?parametro=${action.trim()}&valor=${value}`,{method:'GET',headers:headers});
                const resultado = await consulta.json();
                return resultado;
            }
			const consulta = await fetch("/datos/carreras",{method:'GET',headers:headers});
			const resultado = await consulta.json();
			return resultado;
		} catch (error) {
			console.error(error);
		}
    }

    static async insertarCarrera(formData) {
        try {
			const consulta = await fetch("/admin/insertar/carreras",{method:'POST',body:formData});
			const resultado = await consulta.json();
			return resultado;
		} catch (error) {
			console.error(error);
		}
    }
    static async editarCarrera(formData) {
        try {
			const consulta = await fetch("/admin/editar/carreras",{method:'POST',body:formData});
			const resultado = await consulta.json();
			return resultado;
		} catch (error) {
			console.error(error);
		}
    }
    static async obtenerCarrerasHabilitadasPorPeriodo(periodo) {
        try {
			const consulta = await fetch(`/admin/carreras/periodo-academico/habilitadas?periodo=${periodo}`);
			const resultado = await consulta.json();
			return resultado;
		} catch (error) {
			console.error(error);
		}
    }
}