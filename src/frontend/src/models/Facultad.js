export default class Facultad {
    /**
     * 
     * @returns {Promise} JSON
     */
	static async obtenerFacultades() {
		try {
            const headers = new Headers();
            if(localStorage.Tok_){
                headers.append('token_autorizacion',localStorage.Tok_);
            }
			const consulta = await fetch("/datos/facultades",{method:'GET',headers:headers});
			const resultado = await consulta.json();
			return resultado;
		} catch (error) {
			console.error(error);
		}
	}

	 /**
	 * 
	 * @param {FormData} formData es el fomulario con los campos que se van a enviar id,nombre.
	 * @returns {Promise} JSON
 	*/
	  static async insertarFacultad(formData){
        try{ 
            const consulta = await fetch('/admin/agregar/facultad',{method:'POST',body:formData});
            const respuesta = await consulta.json();
            return respuesta;            
        }catch(e){
            console.error(e);
        }
    }
	/**
	 * @param {FormData} formData es el fomulario con los campos que se van a enviar id,nombre.
	 * @returns {Promise} JSON
 	*/
	 static async editarFacultad(formData){
        try{ 
            const consulta = await fetch('/admin/editar/facultad',{method:'POST',body:formData});
            const respuesta = await consulta.json();
            return respuesta;            
        }catch(e){
            console.error(e);
        }
    }
}
