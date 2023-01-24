export default class Notificaciones {
    /**
     * 
     * @param {string} periodo 
     * @returns {Promise}JSON
     */
    static async obtenerNotificaciones(ruta='coordinador') {
        try {
			const consulta = await fetch(`/${ruta}/obtener/notificaciones`);
			const resultado = await consulta.json();
			return resultado;
		} catch (error) {
			console.error(error);
		}
    }
    static async leidoNotificaciones(id,ruta='coordinador') {
		const formData = new FormData();
		formData.append('id',id);
        try {
			const consulta = await fetch(`/${ruta}/leido/notificaciones`,{method:'POST',body:formData});
			const resultado = await consulta.json();
			return resultado;
		} catch (error) {
			console.error(error);
		}
    }
	static async borrarNotificacion(id,ruta='coordinador') {
		const formData = new FormData();
		formData.append('id',id);
        try {
			const consulta = await fetch(`/${ruta}/borrar/notificaciones`,{method:'POST',body:formData});
			const resultado = await consulta.json();
			return resultado;
		} catch (error) {
			console.error(error);
		}
    }
	static async enviarNotificacion(formData,ruta='coordinador') {
        try {
			const consulta = await fetch(`/${ruta}/enviar/notificaciones`,{method:'POST',body:formData});
			const resultado = await consulta.json();
			return resultado;
		} catch (error) {
			console.error(error);
		}
    }
}