export default class Docentes {

    static async  getDatos(idCarrera){
        try{
            const consulta = await fetch('/datos/docentes?tok_='+localStorage.Tok_+'&carrera='+idCarrera);
            const respuesta = await consulta.json();
            return respuesta;            
        }catch(e){
            console.error(e);
        }
    }

    static async sendCoordinador(formData){
        try {
            formData.append('tok_',localStorage.Tok_);
            const consulta = await fetch('/admin/agregar/coordinador',{
                method:'POST',
                body:formData
            });
            const respuesta =  await consulta.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
}