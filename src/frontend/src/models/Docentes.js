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
    static async sendCoordinador(formData){
        try {
            formData.append('tok_',localStorage.Tok_);
            const consulta = await fetch('/admin/agregar/coordinador',{
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