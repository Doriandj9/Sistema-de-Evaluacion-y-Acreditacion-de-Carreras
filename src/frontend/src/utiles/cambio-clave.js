import Usuarios from '../models/Usuarios.js';
import Notificacion from './../modulos/Notificacion/Notificacion.js';
import Precarga from './../modulos/PreCarga/Precarga.js'
let precarga = null;
const contentInfo = document.getElementById('requiere-cambio-clave');
const htmlModal = document.createElement('div');
htmlModal.className = 'modal fade';
htmlModal.id = 'staticBackdrop';
htmlModal.dataset.bsBackdrop = 'static';
htmlModal.dataset.bsKeyboard = 'false';
htmlModal.tabIndex='-1';
htmlModal.setAttribute('aria-labelledby','staticBackdropLabel');
htmlModal.setAttribute('aria-hidden',true);
//<div   data-bs-backdrop="" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"> </div>
let modal = `<!-- Modal -->
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Cambio de Contraseña</h1>
      </div>
      <div class="modal-body">
            <p> <span class="material-icons text-warning">&#xe002;</span>
             Es la primera vez que ingresa al sistema, debe cambiar la contraseña de manera obligatoria para brindarle una mayor 
            seguridad, esperamos su comprención.</p>
            <form id="form-cambio-clave">
                <div class="mb-3 position-relative">
                    <label for="inputPassword1" class="form-label">Ingrese su Contraseña Actual</label>
                    <div class="p-relativo">
                    <input type="password" class="form-control" id="inputPassword1">
                    <span class="material-icons visible posicionado-derecha-ojo" id="eye">&#xe8f4;</span>
                    </div>
                    <div id="emailHelp" class="form-text">Por favor ingrese su contraseña actual</div>
                </div>
                <div class="mb-3  p-relativo">
                    <label for="inputPassword2" class="form-label">Ingrese su nueva Contraseña</label>
                    <div class=" p-relativo">
                    <input type="password" class="form-control" id="inputPassword2">
                    <span class="material-icons visible posicionado-derecha-ojo" id="eye">&#xe8f4;</span>
                    </div>
                </div>
                <div class="mb-3  p-relativo">
                    <label for="inputPassword3" class="form-label">Repita la nueva Contraseña</label>
                    <div class=" p-relativo">
                    <input type="password" class="form-control" id="inputPassword3">
                    <span class="material-icons visible posicionado-derecha-ojo" id="eye">&#xe8f4;</span>
                    </div>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="enviarDatos" class="btn btn-primary text-white">Cambiar</button>
      </div>
    </div>
</div>`;
htmlModal.innerHTML = modal;
const modalBootstrap = new bootstrap.Modal(htmlModal);
/**
 * Esta funcion muestra el modal con los campos para cambiar la clave
 */
export function mostrarUICambioClave() {
    if(!contentInfo) throw Error('No se encontro el contenedor para el cambio de clave');
    contentInfo.append(htmlModal);
    modalBootstrap.show();
    mostarClaves();
}

/**
 * 
 * @param {string} id_docente El numero de cedula del docente 
 * @param {string} claveNueva La nueva clave requirida que ingrese el docente
 * 
 * @returns {Promise} JSON
 */
export async function cambiarClave(id_docente,claveNueva) {
        modalBootstrap.hide();
        try {
            const respuesta = await Usuarios.sendCambioClave(id_docente,claveNueva);
            const json = await respuesta;
            return json;
        } catch (error) {
           console.log(error);
        }
   
}

function mostarClaves(){
    const ojo = document.querySelectorAll('#eye');
    if(!ojo && ojo.length === 0) return;
    ojo.forEach( e => {
        e.addEventListener('click',convert);
    })

    function convert(e){
        e.preventDefault();
        let input = e.target.previousElementSibling;
        if(input.hasAttribute('text')){
            input.removeAttribute('text');
            input.type = 'password';
            e.target.classList.remove('text-primary');
        }else{
            input.setAttribute('text','');
            input.type = 'text';
            e.target.classList.add('text-primary');
        }
        
    }
}