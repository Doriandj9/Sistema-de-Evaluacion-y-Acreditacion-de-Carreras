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
 export function paginacionEvidencias(datos,divicionDatos,numeroActual,tbody,contNumeros,opcion='ver',funcionRefrescar = null,columnaBusqueda = null,valor=null){
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
        if(!Object.keys(datos[0]).includes(columnaBusqueda)) throw new Error('El objeto no contiene la columna: ' + columnaBusqueda + ' en el objeto');
        datosPaginados = datosPaginados.filter(dato => dato[columnaBusqueda].toLowerCase().includes(valor.toLowerCase()));
    }

    datosPaginados.forEach((dato,i) => {
        const criterio = [...new Set(dato.nombre_criterio.split('---'))];
        const descripcionEstandar = [...new Set(dato.descripcion_estandar.split('---'))];
        const tipoEstandar = [...new Set(dato.tipo_estandar.split('---'))];
        const idElemento = [...new Set(dato.id_elemento.split('---'))];
        const descripcionElemento = [...new Set(dato.descripcion_elemento.split('---'))];
        const idcomponente = [...new Set(dato.id_componente.split('---'))];
        const descripcionComponentes = [...new Set(dato.descripcion_componente.split('---'))];
        const nombre_Evidencia = [...new Set(dato.nombre_evidencias.split('---'))];
        const fecha_inicial = [...new Set(dato.fecha_inicial.split('---'))];
        const fecha_final = [...new Set(dato.fecha_final.split('---'))];
        const cod_evidencias = [...new Set(dato.cod_evidencias.split('---'))];
        const htmlbotonVer = `
        <section class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
        >
           <span class="material-icons text-white">&#xf1c5;</span>  Ver
        </section>
        `;
        const htmlbotonRegistro  = `
        <button type="button" class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
        >
        <span class="material-icons text-white">&#xf09b;</span> Subir 
        </button>        
        `;
        html += `
        <tr>
        <td>${criterio.toString().substring(0,25)}
        <input type="hidden" value="${criterio.join('--')}"/>
        <input type="hidden" value="Criterios"/>
       <br> <span class='ver-mas'>Ver más</span>
        </td>
        <td>${descripcionEstandar.toString().substring(0,25)}
            <input type="hidden" value="${descripcionEstandar.join('--')}"/>
            <input type="hidden" value="Estandares o Indicador"/>
           <br> <span class='ver-mas'>Ver más</span>
        </td>
        <td>${idElemento + '<br>' + descripcionElemento.toString().substring(0,25)}
        <input type="hidden" value="${idElemento.join('--') + '??' + descripcionElemento.join('--')}"/>
        <input type="hidden" value="Elemento Fundamental--Descripción"/>
       <br> <span class='ver-mas'>Ver más</span>
        </td>
        <td>${idcomponente + '<br>' + descripcionComponentes.toString().substring(0,25) }
        <input type="hidden" value="${idcomponente.join('--') + '??' + descripcionComponentes.join('--')}"/>
        <input type="hidden" value="Componente--Descripción"/>
       <br> <span class='ver-mas'>Ver más</span>
        </td>
        <td>
        <strong>Codigo: </strong> <span>${dato.id_evidencias}</span> <br>
        <strong>Nombre: </strong>${nombre_Evidencia.toString().substring(0,40)} <br>
        <input type="hidden" value="${dato.id_evidencias + '??' + nombre_Evidencia}"/>
        <input type="hidden" value="Codigo--Nombre"/>
       <br> <span class='ver-mas'>Ver más</span>
        </td>
        <td>${fecha_inicial.toString()}</td>
        <td>${fecha_final.toString()}</td>
        <td>
          ${opcion === 'ver' ? htmlbotonVer : htmlbotonRegistro} 
        <input type="hidden" value="${cod_evidencias.toString()}"/> 
        </td>

      </tr>
        `;
        // <td>${dato.fecha_inicial}</td>
        // <td>${dato.fecha_final}</td>
        // <td>${dato.estado}</td>
    })
    
    
    for(let i = 1 ; i <= totalNumeros ; i++){
        const button = document.createElement('button');
        button.textContent = i;
        if(i === comparacion) button.classList.add('active'); // Si el numero actual es igual que el del boton ese
        button.addEventListener('click',() => { // boton esta selecionado 
                 paginacionEvidencias(datos,divicionDatos,i,tbody,contNumeros,funcionRefrescar);
                 if(funcionRefrescar) funcionRefrescar();
            }
        );
        numerosUI.push(button);
    }
    tbody.innerHTML = '';
    contNumeros.innerHTML = '';
    tbody.innerHTML = html;
    const trs = Array.from(tbody.querySelectorAll('tr'));
    const tds = trs.map(tr => {
            const tdsTr = Array.from(tr.querySelectorAll('td'));
            return tdsTr.slice(0,5);
        });
    presentancionLarga(tds);
    if(totalNumeros <= 1 ) return; // Esto retorna sin rendirazar el numero uno de paginacion si solo contiene 1 num
    numerosUI.forEach(numero => {
                contNumeros.append(numero);
            });
    
    
}
/**
 * 
 * @param {HTMLElement} tds 
 */
function presentancionLarga (tds) {
    Array.from(tds).flat().forEach((td,i) => {
        const modal = document.createElement('div');
        td.addEventListener('click', () => {
            const [valores,titulos] = td.querySelectorAll('input');
            const primerNivelValores = valores.value.split('??');
            const segundoNivelValores = primerNivelValores.map(p => {
                return p.split('--');
            })
            const primerNivelTitulos = titulos.value.split('--');
            modal.classList = 'modal fade';
            modal.id = `modalCarrera${i}`;
            modal.setAttribute('tabindex','-1');
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
        <!-- Formulario -->
            <form>
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Presentación Completa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              ${printDatos(primerNivelTitulos,segundoNivelValores)}
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary text-white">Guardar Cambios</button>
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
        })
    }) 
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