export default class Usuarios {
	DOCENTES = 1;
	SECRETARIAS = 2;
	COORDINADORES = 4;
	EVALUADOR = 8;
	ARMINISTRADOR = 16;
	async verificacionCredenciales(formData) {
		try {
			const consulta = await fetch("/", { method: "POST", body: formData });
			if (consulta.headers.get("Content-Type") !== "application/json")
				throw new Error("Erro no esta resiviendo un JSON");
			const resultado = await consulta.json();
			return resultado;
		} catch (error) {
			console.error(error);
		}
	}
}
