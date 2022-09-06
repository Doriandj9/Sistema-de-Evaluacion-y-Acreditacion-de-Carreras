
export default class PeriodoAcademico {

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

    static async enviarDatos(formData){
        try {
            const peticion = await fetch('/admin/agregar/ciclo/academico',{method:'POST',body:formData})
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
}