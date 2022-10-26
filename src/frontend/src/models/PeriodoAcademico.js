/**
 * Es un clase modelo para realizar petiones al backend
 */
export default class PeriodoAcademico {
    /**
     * Esta funcion obtiene los datos de un periodo academico por medio de una solitud fecth
     * 
     * @returns {Promise<JSON>} `Promise<JSON>`
     */
    static async  getDatos(){
        try {
            const headers = new Headers();
            if(localStorage.Tok_){
                headers.append('token_autorizacion',localStorage.Tok_);
            }
            const consulta = await fetch(
                '/datos/periodos-academicos',
                {
                    method: 'GET',
                    headers: headers
                }
            );
            const respuesta = await consulta.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
    /**
     * Esta funcion envia los datos de un periodo academico por medio de una solitud fecth
     * 
     * @param {FormData} formData Es el formulario que se va a enviar
     * 
     * @returns {Promise} Promise
     */
    static async enviarDatos(formData){
        try {
            const peticion = await fetch('/admin/agregar/ciclo/academico',{method:'POST',body:formData})
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
    /**
     * Esta funcion actualiza los datos de un periodo academico por medio de una solitud fecth
     * 
     * @param {FormData} formData Es el formulario que se va a enviar
     * 
     * @returns {Promise} Promise
     */
    static async editarDatos(formData){
        try {
            const peticion = await fetch('/admin/editar/ciclo/academico',{method:'POST',body:formData})
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
    /**
     * Esta funcion actualiza los datos de un periodo academico por medio de una solitud fecth
     * 
     * @param {FormData} formData Es el formulario que se va a enviar
     * 
     * @returns {Promise} Promise
     */
     static async habilitarCarreras(formData){
        try {
            const peticion = await fetch('/admin/carreras/periodo-academico/habilitadas',{method:'POST',body:formData})
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
}