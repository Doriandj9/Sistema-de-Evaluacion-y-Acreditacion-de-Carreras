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
 * 
 * @return {*} void
 */
 export function paginacionEvidenciasVerificacion(datos,divicionDatos,numeroActual,tbody,contNumeros,opcion='ver',funcionRefrescar = null,columnaBusqueda = null,valor=null){
    const total  = datos.length;
    const fracion = divicionDatos;
    const totalNumeros = Math.ceil((total / fracion));
    let comparacion = numeroActual; // Toma el numero que esta selecionado al momento de darle click
    let numerosUI = []; // Son los numeros en botones para darles click y realize la paginacion
    let inicio = (numeroActual - 1) * divicionDatos; 
    let fin = inicio + divicionDatos;
    let datosPaginados = datos.slice(inicio,fin);
    let html = '';
    if(columnaBusqueda && valor){
        if(!Object.keys(datos[0]).includes(columnaBusqueda) ||
        !Object.keys(datos[datos.length - 1]).includes(columnaBusqueda)) throw new Error('El objeto no contiene la columna: ' + columnaBusqueda + ' en el objeto');
        datosPaginados = datosPaginados.filter(dato => dato[columnaBusqueda].toLowerCase().includes(valor.toLowerCase()));
    }
    datosPaginados.forEach((dato,i) => {
        html += `
        <tr>
            <td>
            ${dato.nombre_evidencia}
            </td>
            <td>
            <button type="button" class="boton m-auto boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
            >
            <span class="material-icons text-white">&#xe88e;</span> Info
            </button> 
            </td>
            <td>
            <button type="button" class="boton m-auto boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
              data-id-evidencia="${dato.cod_evidencias}">
              <span class="material-icons text-white">&#xe9aa;</span> Verificar  
            </button> 
            </td>
            <td>
            <button type="button" class="boton m-auto boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
        >
        <span class="material-icons text-white">&#xe85a;</span> Notificar 
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
                 paginacionEvidenciasVerificacion(datos,divicionDatos,i,tbody,contNumeros,opcion,funcionRefrescar);
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
        const [butonInfo,butonVer,butonNot] = tr.querySelectorAll('button'); 
        accionButonInfo(butonInfo);
        accionButonVerificacion(butonVer);
        accionButonNotificacion(butonNot);
    })

    // Array.from(tds).flat().forEach((td,i) => {
    //     const modal = document.createElement('div');
    //     td.addEventListener('click', () => {
    //         const [valores,titulos] = td.querySelectorAll('input');
    //         const primerNivelValores = valores.value.split('??');
    //         const segundoNivelValores = primerNivelValores.map(p => {
    //             return p.split('--');
    //         })
    //         const primerNivelTitulos = titulos.value.split('--');
    //         modal.classList = 'modal fade';
    //         modal.id = `modalCarrera${i}`;
    //         modal.setAttribute('tabindex','-1');
    //         modal.setAttribute('aria-labelledby','exampleModalLabel');
    //         modal.setAttribute('aria-hidden',true);
    //         modal.innerHTML = `
    //     <!-- Formulario -->
    //         <form>
    //         <div class="modal-dialog modal-lg modal-dialog-scrollable">
    //         <div class="modal-content">
    //           <div class="modal-header">
    //             <h5 class="modal-title" id="exampleModalLabel">Presentación Completa</h5>
    //             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    //           </div>
    //           <div class="modal-body">
    //           ${printDatos(primerNivelTitulos,segundoNivelValores)}
    //           </div>
    //           <div class="modal-footer">
    //             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
    //             <button type="submit" class="btn btn-primary text-white">Guardar Cambios</button>
    //           </div>
            
    //         </div>
    //       </div>
    //       </form>
    //         `;
    //     document.body.append(modal);
    //     const modalBootstrap =  new bootstrap.Modal(modal,{});
    //     modalBootstrap.show();
    //     modal.addEventListener('hidden.bs.modal',(e) => {
    //         modal.remove();
    //     })
    //     })
    // }) 
}

function printDatos(titulos,valores){
   let html = '';
   if(titulos.length !== valores.length) throw new Error('No coiciden los titulos y los valores');
   valores.forEach((v,i) => {
    v.forEach(r => {
        html += `
        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-4 col-form-label">
                ${titulos[i]}
            </label>
            <div class="col-sm-8">
                ${r}
            </div>
        </div>
        `;
    })
        
   })

   return html;
}


function accionButonInfo(buton) {
const modal = document.createElement('div');
buton.addEventListener('click',(e) => {
    modal.classList = 'modal fade';
            modal.setAttribute('tabindex','-1');
            modal.id = `modalInformacion}`;
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
        <!-- Formulario -->
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Información</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary text-white">Guardar Cambios</button>
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
    document.dispatchEvent(new CustomEvent('display.modal.info',{detail:modal}));
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
                <div class="mb-3">
                <label> Informe si esta de acuerdo con verificar el documento de información en caso de ser el correcto. </label>
                      <div class="form-check">
                      <input class="form-check-input" name="verificar" type="checkbox" value="1" id="verificacion">
                      <label class="form-check-label tipografia-verdana-3" for="verificacion">
                        Verificar
                      </label>
                    </div>
                    <div id="emailHelp" class="form-text">Nota: Si no corresponde el documento de información envie una notificacion
                    , en la opcion notificar.
                    </div>
                </div>
                <div class="mb-3">
                <label for="staticEmail" class="col-sm-6 col-form-label">Selecione la valoración que aporta a la carrera</label>
                <div class="col-sm-6">
                  <div class="d-flex gap-2 align-items-center">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="valoracion" value="25" id="">
                        <label class="form-check-label me-3" for="valoracion">
                          Bajo
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" value="50" type="radio" name="valoracion" id="">
                        <label class="form-check-label me-3" for="valoracion">
                         Medio
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" value="100" type="radio" name="valoracion" id="">
                        <label class="form-check-label me-3" for="valoracion">
                          Alto
                        </label>
                      </div>
                  </div>
                </div>
              </div>
              <div class="mb-3">
              <label>Ingrese un comentario que justifique la nota (opcional)</label>
                <div>
                  <textarea name="comentario" class="form-control" style="resize:none;" autocapitalize="sentences" cols="48" rows="5"
                  placeholder="Aa"></textarea>
                </div>
              </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary text-white">Guardar Información</button>
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
const modal = document.createElement('div');
buton.addEventListener('click',(e) => {
    modal.classList = 'modal fade';
            modal.setAttribute('tabindex','-1');
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Escribir la notificación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="mb-3">
                  <label>Ingrese el mensaje que desea que le llegue al encargado del documento de información</label>
                    <div>
                      <textarea class="form-control" style="resize:none;" autocapitalize="sentences" cols="48" rows="5"
                      placeholder="Aa"></textarea>
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary text-white">Enviar</button>
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
    document.dispatchEvent(new CustomEvent('display.modal.noti',{detail:modal}));
    
})
}