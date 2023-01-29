import Evidencias from "../models/Evidencias.js";
import Notificacion from "../modulos/Notificacion/Notificacion.js";
import alerta from "./alertasBootstrap.js";

/**
 * 
 * @param {*} datos Son los datos como array
 * @param {*} divicionDatos Es el numero de elementos que desean que se presente
 * @param {*} numeroActual Es el numero que se encuentran los datos
 * @param {HTMLElement} tbody Es el contenedor de las filas del cuerpo de la tabla
 * @param {*} contNumeros Es el contenedor de los numeros para la selecion de paginacion
 * @param {CallableFunction} funcionRefrescar Sirve para refrescar los botonos del tbody
 * @param {string} columnaBusqueda Es la columna que va servir para buscar las coindencias dentro de los datos
 * @param {string} valor Es el coincidencia que a buscar en la columna
 * @param {null|boolean} paginar Se usa para la busqueda para que busque en todo el array
 * 
 * 
 * @return {*} void
 */
 export function paginacionEvidenciasVerificacion(datos,divicionDatos,numeroActual,tbody,contNumeros,opcion='ver',funcionRefrescar = null,columnaBusqueda = null,valor=null,paginar=null){
    let total  = datos.length;
    let fracion = divicionDatos;
    let totalNumeros = Math.ceil((total / fracion));
    let comparacion = numeroActual; // Toma el numero que esta selecionado al momento de darle click
    let numerosUI = []; // Son los numeros en botones para darles click y realize la paginacion
    let inicio = (numeroActual - 1) * divicionDatos; 
    let fin = inicio + divicionDatos;
    let datosPaginados = paginar === true ? datos :  datos.slice(inicio,fin);
    let html = '';
    if(columnaBusqueda && valor){
      if(!Object.keys(datos[0]).includes(columnaBusqueda) ||
      !Object.keys(datos[datos.length - 1]).includes(columnaBusqueda)) throw new Error('El objeto no contiene la columna: ' + columnaBusqueda + ' en el objeto');
      datosPaginados = datosPaginados.filter(dato => dato[columnaBusqueda].toLowerCase().includes(valor.toLowerCase()));
        total = datosPaginados.length;
        totalNumeros = Math.ceil((total / fracion));
        datosPaginados = datosPaginados.slice(inicio,fin);
    }
    datosPaginados.forEach((dato,i) => {
        html += `
        <tr>
            <td>
            ${dato.nombre_evidencia}
            <span data-id="${dato.id_evidencias}"
            class="tipografia-times-1 text-decoration-underline text-primary" style="cursor:pointer;"
            info> Detalles </span>
            </td>
            <td>
            <button type="button" class="boton m-auto boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
              data-id-evidencia="${dato.cod_evidencias}">
              <span class="material-icons text-white">&#xe8f4;</span> Ver  
            </button> 
            </td>
            <td class="tipografia-times-1 contenedor-radios">
            <form>
            <div class="d-flex gap-2">
              <div class="text-center">
              <input class="form-check-input sombra" value="0" type="radio" name="valoracion">
                <label class="d-block">
                  No corresponde
                </label>
              </div>
              <div class="text-center">
              <input class="form-check-input sombra" value="50" type="radio" name="valoracion">
                <label class="d-block">
                  Parcialmente
                </label>
              </div>
              <div class="text-center">
              <input class="form-check-input sombra" value="100" type="radio" name="valoracion">
                <label class="d-block">
                  Corresponde
                </label>
              </div>
            </div>
            </form>
            </td>
            <td>
            <button type="button" data-responsable="${dato.responsable}" data-id-evidencia="${dato.cod_evidencias}"
            class="boton m-auto boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
            >
            <span class="material-icons text-white">&#xe161;</span> Guardar 
            </button> 
            </td>
      </tr>
        `;
    })
    
    
    for(let i = 1 ; i <= totalNumeros ; i++){
        const button = document.createElement('button');
        button.textContent = i;
        if(i === comparacion) button.classList.add('active'); // Si el numero actual es igual que el del boton ese
        button.addEventListener('click',() => { // boton esta selecionado 
                 paginacionEvidenciasVerificacion(datos,divicionDatos,i,tbody,contNumeros,opcion,funcionRefrescar,columnaBusqueda,valor,paginar);
                 if(funcionRefrescar) funcionRefrescar();
            }
        );
        numerosUI.push(button);
    }
    tbody.innerHTML = '';
    contNumeros.innerHTML = '';
    tbody.innerHTML = html;
    const trs = Array.from(tbody.querySelectorAll('tr'));
    particionButones(trs);
    if(totalNumeros <= 1 ) return; // Esto retorna sin rendirazar el numero uno de paginacion si solo contiene 1 num
    numerosUI.forEach(numero => {
                contNumeros.append(numero);
            });
    
    
}
/**
 * 
 * @param {HTMLElement} tds 
 */
function particionButones (trs) {
    trs.forEach(tr =>  {
        const [butonVer,butonNot] = tr.querySelectorAll('button');
        const detalles = tr.querySelector('span[info]');
        accionVerDetalles(detalles); 
        accionButonVerificacion(butonVer);
        accionButonNotificacion(butonNot);
    })
}

function accionButonVerificacion(buton) {
const id_evidencias = buton.dataset.idEvidencia;
const modal = document.createElement('div');
modal.id = 'presentacionViews';
buton.addEventListener('click',(e) => {
    modal.classList = 'modal fade';
            modal.setAttribute('tabindex','-1');
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
        <!-- Formulario -->
        <form>
        <input type="hidden" name="id_evidencia" id="id-evidencias" value="${id_evidencias}">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verificar el Docuemento de Información</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                    <h4 for="staticEmail" class="col-form-label">Visualizar el documento.</h4>
                    <div class="col-sm-10">
                        <label class="position-relative" for="pdf">
                        <div class="spinner-border text-dark carga-medio" role="status"><span class="visually-hidden">Loading...</span></div>
                        <img class="selector" height="40" id="pdf"  src="/public/assets/img/icons8-pdf-50.png" alt="imagen pdf" />
                        </label>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
        document.dispatchEvent(new CustomEvent('display.modal.verf',{detail:modal}));
})
}
function accionButonNotificacion(buton) {
  const tr = buton.parentElement.parentElement;
  const form = tr.querySelector('form');
const modal = document.createElement('div');
buton.addEventListener('click',(e) => {
  const formData = new FormData(form);
  const valoracion = [...formData];
  const valoraciones = {'0':'No corresponde','50':'Parcialmente','100':'Corresponde'};
  if(valoracion.length <= 0 ){
    new Notificacion(`Por favor, selecione una valoración como (No correponde,Parcialmente
      Corresponde) presentados anteriormente para continuar con el proceso de verificación.`,'Regresar');
      return;
  }
    modal.classList = 'modal fade';
            modal.setAttribute('tabindex','-1');
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
            <form>
            <input type="hidden" value="${buton.dataset.responsable}" name="receptor">
            <input type="hidden" value="${buton.dataset.idEvidencia}" name="id_evidencia">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cuandro de confirmación de registro de verificación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              <div class="mb-3">
              <h4>Concideraciones</h4>
              <ul class="list-circle ">
              <li>
              Ingrese un comentario que explique la valoración que elegiste,
              la misma que será notificada al docente encargado de subir la fuente de información (evidencia)
              </li>
              <li>
              Antes de proceder con la verificación de la fuente de información(Evidencia), 
              es importante que revises y confirmes las opciones que has elegido. 
              </li>
              <li>
              Una vez que decidas enviar los datos no podrás hacer cambios. 
              Así que asegúrate de que todo esté correcto antes de dar el siguiente paso.
              </li>
              </ul>
              </div>
                  <div class="mb-3">
                  <input type="hidden" name="valoracion" value="${valoracion[0][1]}">
                  <label>La valoración que eligió anteriormente es: <strong>${valoraciones[valoracion[0][1]]}</strong></label>
                  </div>
                  <div class="mb-3">
                  <label>¿Desea que el docente vuelva a subir la fuente de información?</label>
             </div>
              <div class="d-flex gap-2 mb-3 contenedor-radios">
                  <div class="text-center">
                  <input class="form-check-input sombra" value="1" type="radio" name="verificar">
                    <label class="d-block">
                      SI
                    </label>
                  </div>
                  <div class="text-center">
                  <input class="form-check-input sombra" value="0" type="radio" name="verificar">
                    <label class="d-block">
                      NO
                    </label>
                  </div>
                </div>
                  <div class="mb-3">
                  <label>Ingrese el mensaje que desea que le llegue al encargado del documento de información</label>
                    <div>
                      <textarea name="comentario" class="form-control" style="resize:none;" autocapitalize="sentences" cols="48" rows="5"
                      placeholder="Aa" id="comentario-e"></textarea>
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
    document.dispatchEvent(new CustomEvent('display.modal.noti',{detail:[modal,modalBootstrap]}));
})
}

function accionVerDetalles(buton) {
  const modal = document.createElement('div');
buton.addEventListener('click',(e) => {
    modal.classList = 'modal fade';
            modal.setAttribute('tabindex','-1');
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
       <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Información</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="body-modal-e">

                  <div class="spinner-border text-primary" role="status">
                      <span class="visually-hidden">Loading...</span>
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
    // Llamamos al evento de traida de informacion
    Evidencias.obtenerEvidenciaVerificarDetalle(buton.dataset.id)
    .then(respuesta => {
      const {ident,evidencia} = respuesta;
      if(!ident) {
        alerta('alert-danger','Error en el servidor, intentelo mas tarde.',3500);
        return;
      };
      const criterio = [...new Set(evidencia.nombre_criterio?.split('---'))];
      const nombre = [...new Set(evidencia.nombre_evidencias?.split('---'))];
      const elementos = [...new Set(evidencia.id_elemento?.split('---'))];
      const estandares = [...new Set(evidencia.id_estandar?.split('---'))];


      const bodyModal = modal.querySelector('#body-modal-e');
      bodyModal.innerHTML = `
      <div class="mb-3">
        <p>
            Este cuadro de referencia le presenta la información acerca de la evidencia que va a verificar,
            a continuación se presenta los criterios, estándares, elementos fundamentales y el nombre de la fuente
            de información, recuerde que para evitar la sobrecarga de información en una ventana de presentación 
            solo se mostrará los números de los elementos fundamentales y de los estandares.
        </p>
    </div>
    <div class="mb-3 d-flex" style="border-bottom: 1px solid #ccc;">
        <label for="" class="w-50 d-block" ><strong>Nombre:</strong></label>
        <p class="flex-grow-1">${nombre.toString()}</p>
    </div>
    <div class="mb-3 d-flex" style="border-bottom: 1px solid #ccc;">
        <label for="" class="w-50 d-block"><strong>Criterios:</strong></label>
        <p class="flex-grow-1">${criterio.toString()}</p>
    </div>
    <div class="mb-3 d-flex" style="border-bottom: 1px solid #ccc;">
        <label for="" class="w-50 d-block"><strong>Elementos Fundamentales:</strong></label>
        <p class="flex-grow-1">${elementos.toString()}</p>
    </div>
    <div class="mb-3 d-flex" style="border-bottom: 1px solid #ccc;">
        <label for="" class="w-50 d-block"><strong>Estandares:</strong></label>
        <p class="flex-grow-1">${estandares.toString()}</p>
    </div>
      `;
    })
    .catch(console.log);
})
}