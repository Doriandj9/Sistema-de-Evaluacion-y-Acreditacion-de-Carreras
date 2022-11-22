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
			const resultado = await consulta.json();
			return resultado;
		} catch (error) {
			console.error(error);
		}
    }
     /**
     * 
     * @param {String} periodo 
     * @param {String} idEvidencia
     * 
     * @returns {Promise} Blob
     */
      static async obtenerEvidenciaIndvidual(periodo,idEvidencia) {
        const archivos = ['pdf','word','excel'];
        let files = [];
      try {
      for(let file of archivos){
        const consulta = await fetch(`/coordinador/listar/${file}/evidencias?periodo=${periodo}&evidencia=${idEvidencia}`);
        const resultado = await consulta.blob();
        files.push(resultado);
      }
			return files;
		} catch (error) {
			console.error(error);
		}
    }
  /**
     * 
     * @param {String} id_evidencias 
     * @returns {Promise}JSON
     */
   static async obtenerEvidenciaDetalle(id_evidencias) {
    try {
  const consulta = await fetch(`/coordinador/detalle/evidencias?id=${id_evidencias}`);
  const resultado = await consulta.json();
  return resultado;
} catch (error) {
  console.error(error);
}
}
}
