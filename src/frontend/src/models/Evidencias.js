export default class Evidencias {

    /**
     * 
     * @param {string} periodo 
     * @returns {Promise}JSON
     */
    static async obtenerEvidencias(periodo) {
        try {
			const consulta = await fetch(`/coordinador/datos/evidencias?periodo=${periodo}`);
			const resultado = await consulta.json();
			return resultado;
		} catch (error) {
			console.error(error);
		}
    }
    /**
     * 
     * @param {FormData} formData 
     * @returns {Promise}JSON
     */
     static async subirEvidencias(formData) {
        try {
			const consulta = await fetch(`/coordinador/subir/evidencias`,{
                method: 'POST',
                body: formData
            });
			const resultado = await consulta.text();
            console.log(resultado);
			return resultado;
		} catch (error) {
			console.error(error);
		}
    }
    static encode(str) {
       const encodedString = btoa(str);
        return encodedString;
    }
     
    // Función para decodificar una string desde formato base64
    static decode(str) {
       const decodedString = atob(str);
        console.log(decodedString);
    }
}
