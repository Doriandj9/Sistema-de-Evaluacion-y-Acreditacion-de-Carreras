/**
 * Es clase es un modelo que se conecta con el backend para resivir datos o enviar datos y ser almacenados
 * en la base de datos
 * 
 * @author Dorian Armijos
 * 
 */
export default class Docentes {
/**
 * 
 * @param {string} idCarrera es el id de la carrera donde se va a buscar los docentes de esa carrera
 * @returns {Promise} JSON 
 */
    static async  getDatos(idCarrera){
        try{
            const headersPeticion = new Headers();
            if(localStorage.Tok_){
                headersPeticion.append('token_autorizacion',localStorage.Tok_);
            }
            const consulta = await fetch(
                '/datos/docentes?carrera='+idCarrera,
                {
                    method:'GET',
                    headers:headersPeticion
                }
                );
            const respuesta = await consulta.json();
            return respuesta;            
        }catch(e){
            console.error(e);
        }
    }
/**
 * 
 * @param {FormData} formData es un formulario con los parametros para agregar un coordinador 
 * @returns {Promise} JSON
 */
    static async sendCoordinador(formData,opcion = null){
        try {
            formData.append('tok_',localStorage.Tok_);
            let consulta = '';
            if(opcion && opcion === 'manual') {
                consulta = await fetch('/admin/agregar/coordinador?opcion=manual',{
                    method:'POST',
                    body:formData
                });
            }else {
                consulta = await fetch('/admin/agregar/coordinador',{
                    method:'POST',
                    body:formData
                });
            }
            const respuesta =  await consulta.json();        
            return respuesta
        } catch (error) {
            console.error(error);
        }
    }
    /**
     * Obtiene todos los coordinares registrados en la DB
     * 
     * @returns Promise<JSON>
     */
    static async obtenerCoordinadores() {
        try {
            const consulta = await fetch('/admin/obtener/coordinadores');
            const datos = await consulta.json();
            return datos;
        } catch (error) {
            console.error(error);
        }
    }
    /**
     * Obtiene todos los coordinares registrados en la DB
     * 
     * @returns Promise<JSON>
     */
     static async obtenerDocentesDeCarrera() {
        try {
            const consulta = await fetch('/coordinador/datos/docentes/carrera');
            const datos = await consulta.json();
            return datos;
        } catch (error) {
            console.error(error);
        }
    }
      /**
     * 
     * @param {string} cedula es el numero de cedula del docente
     * @returns {Promise} JSON 
     */
       static async  obtenerDatosDocente(cedula){
        try{
            const headersPeticion = new Headers();
            if(localStorage.Tok_){
                headersPeticion.append('token_autorizacion',localStorage.Tok_);
            }
            const consulta = await fetch(
                '/datos/docente/informacion?cedula='+cedula,
                {
                    method:'GET',
                    headers:headersPeticion
                }
                );
            const respuesta = await consulta.json();
            return respuesta;            
        }catch(e){
            console.error(e);
        }
    }
    /**
 * 
 * @param {FormData} formData es un formulario con los parametros para agregar un coordinador 
 * @returns {Promise} JSON
 */
     static async sendDocenteACarrera(formData){
        try {
            const consulta = await fetch('/coordinador/registrar/docente',{
                    method:'POST',
                    body:formData
                });
            const respuesta =  await consulta.json();       
            return respuesta
        } catch (error) {
            console.error(error);
        }
    }
}