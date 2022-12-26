import Notificaciones from "../../models/Notificaciones.js";
import Precarga from "../../modulos/PreCarga/Precarga.js";
import alerta from "../../utiles/alertasBootstrap.js";
import { paginacionNotificaciones } from "../../utiles/paginacionNotificaciones.js";
import Notificacion from "./../../modulos/Notificacion/Notificacion.js"

const table = document.querySelector('table');
const tbody = table.querySelector('tbody');
const contenedorNumeros = document.querySelector('.contenedor-numeros-paginacion');
let precarga = null;
let datosExtraidos = null;
listarNotificaciones();
function listarNotificaciones () {
    Notificaciones.obtenerNotificaciones('coordinador')
    .then(renderNotificaciones)
    .catch(console.log)
}

function renderNotificaciones(respuesta) {
    if(respuesta.ident) {
        const {notificaciones} = respuesta;
        paginacionNotificaciones(notificaciones,5,1,tbody,contenedorNumeros,acciones);
        acciones();
        datosExtraidos = notificaciones;
    }else{
        new Notificacion('Error, en el servidor','Regresar');
    }
}


function acciones () {
    habilitarLeer();
    habilitarResponder();
    habilitarNoMostrar();
}


function habilitarLeer() {
    const opcionesLeer = tbody.querySelectorAll('a');
    opcionesLeer.forEach(l => {
        const modal = document.createElement('div');
        l.addEventListener('click', () => {
            if(l.dataset.leido != 'true'){
                enviarLeido(l.dataset.id);
            }
            modal.classList = 'modal fade';
            modal.id = `presentacionViews`;
            modal.setAttribute('tabindex','-1');
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mensaje completo de la notificación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                    ${l.dataset.mensaje}
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
            `;
            document.body.append(modal);
            const modalBootstrap =  new bootstrap.Modal(modal,{});
            modalBootstrap.show();
            modal.addEventListener('hidden.bs.modal',(e) => {
                modal.remove();
            })
        })
    })
    
}

function enviarLeido(id_notificacion) {
    Notificaciones.leidoNotificaciones(id_notificacion, 'coordinador')
    .then(console.log)
    .catch(console.log)
}

function habilitarResponder() {
    const buttons = tbody.querySelectorAll('button[response]');
    buttons.forEach(l => {
        const modal = document.createElement('div');
        l.addEventListener('click', () => {
            modal.classList = 'modal fade';
            modal.id = `presentacionViews`;
            modal.setAttribute('tabindex','-1');
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
            <form>
            <input type="hidden" name="receptor" value="${l.dataset.remitente}">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Responder Notificación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              <div class="mb-3">
              Esta sección le permite responder al remitente de la notificación,
              para ello, simplemente agregue un mensaje y presione la opción enviar.
              </div>
                <div class="mb-3">
                <label>Ingrese un mensaje de respuesta</label>
                <div>
                  <textarea name="mensaje" class="form-control" style="resize:none;" autocapitalize="sentences" cols="48" rows="5"
                  placeholder="Aa" id="mensaje-e"></textarea>
                </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary text-white">Enviar</button>
              </div>
            </div>
          </div>
          </form>
            `;
            document.body.append(modal);
            const modalBootstrap =  new bootstrap.Modal(modal,{});
            modalBootstrap.show();
            modal.addEventListener('hidden.bs.modal',(e) => {
                modal.remove();
            })
            const form = modal.querySelector('form');
            form.addEventListener('submit',e => {
              e.preventDefault();
              modalBootstrap.hide();
              precarga = new Precarga();
              precarga.run();
              Notificaciones.enviarNotificacion(new FormData(form),'coordinador')
              .then(renderRespuesta)
              .catch(console.log)
            })
        })
    })
}

function renderRespuesta(respuesta) {
  precarga.end();
  if(respuesta.ident) {
    new Notificacion(respuesta.mensaje,'Aceptar',false);
  }else {
    new Notificacion(respuesta.mensaje,'Regresar');
  }
}

function borrarRow(respuesta,l){
  if(respuesta.ident){
    const datos = datosExtraidos.filter(d => d.id != l.dataset.id);
    renderNotificaciones({ident:1,notificaciones:datos});
  }else{
    new Notificacion(respuesta.mensaje,'Regresar');
  }
}

function habilitarNoMostrar() {
    const buttons = tbody.querySelectorAll('button[notting]');
    buttons.forEach(l => {
        const modal = document.createElement('div');
        l.addEventListener('click', () => {
            modal.classList = 'modal fade';
            modal.id = `presentacionViews`;
            modal.setAttribute('tabindex','-1');
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
            <form>
            <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                <span class="material-icons text-danger">&#xe8b2;</span> Advertencia!!
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              <div class="mb-3">
              Se le informa que la acción que va a realizar, implica que no se vuelva a mostrar esta notificación
              por ende no podra volver a saber el contenido de la misma, recuerde que todo es bajo su responsabilidad. 
              </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary text-white">De Acuerdo</button>
              </div>
            </div>
          </div>
          </form>
            `;
            document.body.append(modal);
            const modalBootstrap =  new bootstrap.Modal(modal,{});
            modalBootstrap.show();
            modal.addEventListener('hidden.bs.modal',(e) => {
                modal.remove();
            });
            const form = modal.querySelector('form');
            form.addEventListener('submit',e => {
              e.preventDefault();
              modalBootstrap.hide();
              Notificaciones.borrarNotificacion(l.dataset.id)
              .then(r => borrarRow(r,l))
              .catch(console.log)
            })
        })
    })
}