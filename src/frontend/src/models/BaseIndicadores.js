export default class BaseIndicadores {
     /**
     * Esta funcion obtiene los criterios de DB
     * 
     * @returns {Promise<JSON>} `Promise<JSON>`
     */
     static async  obtenerCriterios(){
        try {
            const peticion = await fetch('/director-planeamiento/obtener/criterios');
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }

    static async  editarCriterios(formData){
        try {
            const peticion = await fetch('/director-planeamiento/editar/criterios'
            ,{method:'POST',body:formData});
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
    static async insertarCriterios(formData){
        try {
            const peticion = await fetch('/director-planeamiento/insertar/criterios'
            ,{method:'POST',body:formData});
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }

    static async  obtnerEstandares(){
        try {
            const peticion = await fetch('/director-planeamiento/obtener/estandares');
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
    static async  editarEstandares(formData){
        try {
            const peticion = await fetch('/director-planeamiento/editar/estandares'
            ,{method:'POST',body:formData});
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
    static async insertarEstandares(formData){
        try {
            const peticion = await fetch('/director-planeamiento/insertar/estandares'
            ,{method:'POST',body:formData});
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }

    static async  obtnerElementos(){
        try {
            const peticion = await fetch('/director-planeamiento/obtener/elementos-fundamentales');
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
    static async  editarElementos(formData){
        try {
            const peticion = await fetch('/director-planeamiento/editar/elementos-fundamentales'
            ,{method:'POST',body:formData});
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
    static async insertarElementos(formData){
        try {
            const peticion = await fetch('/director-planeamiento/insertar/elementos-fundamentales'
            ,{method:'POST',body:formData});
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }

    static async  obtenerComponentes(){
        try {
            const peticion = await fetch('/director-planeamiento/obtener/componentes-elementos-fundamentales');
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
    static async  editarComponentes(formData){
        try {
            const peticion = await fetch('/director-planeamiento/editar/componentes-elementos-fundamentales'
            ,{method:'POST',body:formData});
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
    static async insertarComponentes(formData){
        try {
            const peticion = await fetch('/director-planeamiento/insertar/componentes-elementos-fundamentales'
            ,{method:'POST',body:formData});
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }

    static async  obtenerEvidencias(){
        try {
            const peticion = await fetch('/director-planeamiento/obtener/evidencias');
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
    static async  editarEvidencias(formData){
        try {
            const peticion = await fetch('/director-planeamiento/editar/evidencias'
            ,{method:'POST',body:formData});
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }

    static async componentesElementosEvidencias(){
        try {
            const peticion = await fetch('/director-planeamiento/obtener/componentes-elementos-fundamentales-evidencias');
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
    static async insertarEvidencias(formData){
        try {
            const peticion = await fetch('/director-planeamiento/insertar/evidencias'
            ,{method:'POST',body:formData});
            const respuesta = await peticion.json();
            return respuesta;
        } catch (error) {
            console.error(error);
        }
    }
}