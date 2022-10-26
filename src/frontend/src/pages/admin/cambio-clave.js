import "./../../../node_modules/jwt-decode/build/jwt-decode.js"// este script agregar al objeto global la funcion jwt_decode
// que se utiliza luego para decodifcar el token
import Usuarios from "./../../models/Usuarios.js"
import Precarga from "./../../modulos/PreCarga/Precarga.js";
import "./../../utiles/funciones-cookies.js"; // este escript agrega al objeto global las funciones para obtener las cookies o
//agregar nuevas
import Notificacion from "./../../modulos/Notificacion/Notificacion.js";
const form = document.getElementById('form-cambio-clave');
(function () {
    const verificaciones = {claveActual: false, claveRepetida: false};
    import('./../../utiles/cambio-clave.js')
    .then(funciones => {
        const {cambiarClave} = funciones;
        const botonEnvio = document.getElementById('enviarDatos');
        const [claveActual,nuevaClave,claveRepetida] = form.querySelectorAll('input');
        const spinner = document.createElement('div');
        const precarga = new Precarga();
        spinner.className = 'spinner-border text-primary';
        spinner.setAttribute('role','status');
        spinner.innerHTML = `<span class="visually-hidden">Loading...</span>`;
        claveActual.addEventListener('change', (e) => {
            const contenedor = claveActual.parentElement.parentElement;
            contenedor.append(spinner);
            Usuarios.comprobacionClave(e.target.value.trim())
            .then((respuesta) => {
                spinner.remove();
                claveActual.nextElementSibling.style.right = '2rem';
                if(respuesta.ident){
                    if(claveActual.classList.contains('is-invalid')) claveActual.classList.remove('is-invalid');
                    claveActual.classList.add('is-valid');
                    verificaciones.claveActual = true;
                }else {
                    if(claveActual.classList.contains('is-valid')) claveActual.classList.remove('is-valid');
                    claveActual.classList.add('is-invalid');
                    verificaciones.claveActual = false;
                }
            }).catch(e => console.log(e));
        })

        claveRepetida.addEventListener('change', (e) => {
            claveRepetida.nextElementSibling.style.right = '2rem';
            if(nuevaClave.value.trim() === claveRepetida.value.trim()){
                if(claveRepetida.classList.contains('is-invalid')) claveRepetida.classList.remove('is-invalid');
                    claveRepetida.classList.add('is-valid');
                    verificaciones.claveRepetida = true;
            }else {
                if(claveRepetida.classList.contains('is-valid')) claveRepetida.classList.remove('is-valid');
                    claveRepetida.classList.add('is-invalid');
                    verificaciones.claveRepetida = false;
            }
        })

        botonEnvio.addEventListener('click', (e) => {
            e.preventDefault();
            if(Object.values(verificaciones).every(respuestas => respuestas === true)){
                const usuario = jwt_decode(localStorage.Tok_);
                precarga.run();
                cambiarClave(usuario.id_usuario,claveRepetida.value.trim())
                .then((respuesta) => {
                    if(respuesta.ident) {
                        rebootInputs();
                        precarga.end();
                        new Notificacion(
                            'Se actualizo correctamente su nueva contraseña',
                            'Aceptar',
                            false
                        );
                    }else {
                        new Notificacion(
                            'A ocurrido un error por favor intentelo mas tarde',
                            'Regresar'
                        );
                    }
                })
                .catch(renderError); 
            }else {
                const alerta = document.createElement('div');
                alerta.classList = 'contenedor-alert-1';
                alerta.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="info-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </symbol>
                    </svg>
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                        <div>
                            Revise nuevamente los campos, uno o varios son incorrectos
                        </div>
                    </div>
                `;
                form.append(alerta);
                setTimeout(() => {// Este codigo elimina la alerta automaticamene luego de 1 segundo
                    alerta.remove();
                },3000)
            }
        })
    })
    .catch(e  => console.log(e));
})();

function renderError(e){
    new Notificacion(e,'Regresar');
}

function rebootInputs() {
    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => {
        input.value = '';
        if(input.classList.contains('is-valid')) input.classList.remove('is-valid');
        if(input.classList.contains('is-invalid')) input.classList.remove('is-invalid');
});
}