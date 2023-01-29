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
 export function paginacionEvidenciasEvaluacion(datos,divicionDatos,numeroActual,tbody,contNumeros,funcionRefrescar = null,columnaBusqueda = null,valor=null,paginar=null){
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
    if(datosPaginados.length <= 0 ){
        alerta('alert-danger','No existe con el nombre ' + valor);
    } 
    datosPaginados.forEach((dato,i) => {
        const criterio = [...new Set(dato.nombre_criterio?.split('---'))];
        const descripcionEstandar = [...new Set(dato.descripcion_estandar?.split('---'))];
        const tipoEstandar = [...new Set(dato.tipo_estandar?.split('---'))];
        const idElemento = [...new Set(dato.id_elemento?.split('---'))];
        const descripcionElemento = [...new Set(dato.descripcion_elemento?.split('---'))];
        const idcomponente = [...new Set(dato.id_componente?.split('---'))];
        const descripcionComponentes = [...new Set(dato.descripcion_componente?.split('---'))];
        const nombre_Evidencia = [...new Set(dato.nombre_evidencias?.split('---'))];
        const cod_evidencias = [...new Set(dato.cod_evidencias?.split('---'))];
        const id_evidencias = [...new Set(dato.id_evidencias?.split('---'))];
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
        <strong>Codigo: </strong> <span>${cod_evidencias.toString()}</span> <br>
        <strong>Nombre: </strong>${nombre_Evidencia.toString().substring(0,40)} <br>
        <input type="hidden" value="${cod_evidencias.toString() + '??' + nombre_Evidencia}"/>
        <input type="hidden" value="Codigo--Nombre"/>
       <br> <span class='ver-mas'>Ver más</span>
        </td>
        <td>
        <section data-id-evidencia="${id_evidencias.toString().trim()}" class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1">
           <span class="material-icons text-white">&#xe8f4;</span>  Ver
        </section>
        <input type="hidden" value="${cod_evidencias.toString()}"/> 
        </td>
        <td>
        <button type="button" data-nombre-evidencia="${nombre_Evidencia.toString()}"
        data-info-tipo="${tipoEstandar.toString()}" data-id-evidencia="${id_evidencias.toString()}"
        class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1">
        <span class="material-icons text-white">&#xe85d;</span> Calificar 
        </button> 
        <input type="hidden" value="${cod_evidencias.toString()}"/> 
        </td>
      </tr>
        `;
    })
    
    
    for(let i = 1 ; i <= totalNumeros ; i++){
        const button = document.createElement('button');
        button.textContent = i;
        if(i === comparacion) button.classList.add('active'); // Si el numero actual es igual que el del boton ese
        button.addEventListener('click',() => { // boton esta selecionado 
                 paginacionEvidenciasEvaluacion(datos,divicionDatos,i,tbody,contNumeros,funcionRefrescar,columnaBusqueda,valor,paginar);
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