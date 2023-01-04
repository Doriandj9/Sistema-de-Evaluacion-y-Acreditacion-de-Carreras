/**
 * 
 * @param {*} datos Son los datos como array
 * @param {*} divicionDatos Es el numero de elementos que desean que se presente
 * @param {*} numeroActual Es el numero que se encuentran los datos
 * @param {*} tbody Es el contenedor de las filas del cuerpo de la tabla
 * @param {*} contNumeros Es el contenedor de los numeros para la selecion de paginacion
 * @param {CallableFunction} funcionRefrescar Sirve para refrescar los botonos del tbody
 * 
 * @return {*} void
 */
export function paginacionCriterios(datos,divicionDatos,numeroActual,tbody,contNumeros,funcionRefrescar = null){
    const total  = datos.length;
    const fracion = divicionDatos;
    const totalNumeros = Math.ceil((total / fracion));
    let comparacion = numeroActual; // Toma el numero que esta selecionado al momento de darle click
    let numerosUI = []; // Son los numeros en botones para darles click y realize la paginacion
    let inicio = (numeroActual - 1) * divicionDatos; 
    let fin = inicio + divicionDatos;
    let datosPaginados = datos.slice(inicio,fin);
    let html = '';
    datosPaginados.forEach((dato,i) => {
        html += `
        <tr>
        <td>
        ${dato.id}
        </td>
        <td>
        ${dato.nombre}
        </td>
        <td>
            <button notting type="button"  data-datos='${JSON.stringify(dato)}'
            class="boton m-auto boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
            >
            <span class="material-icons text-white">&#xe3c9;</span> Editar
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
                 paginacionCriterios(datos,divicionDatos,i,tbody,contNumeros,funcionRefrescar);
                 if(funcionRefrescar) funcionRefrescar();
            }
        );
        numerosUI.push(button);
    }
    tbody.innerHTML = '';
    contNumeros.innerHTML = '';
    tbody.innerHTML = html;
    if(totalNumeros <= 1 ) return; // Esto retorna sin rendirazar el numero uno de paginacion si solo contiene 1 num
    numerosUI.forEach(numero => {
                contNumeros.append(numero);
            });
}



/**
 * 
 * @param {*} datos Son los datos como array
 * @param {*} divicionDatos Es el numero de elementos que desean que se presente
 * @param {*} numeroActual Es el numero que se encuentran los datos
 * @param {*} tbody Es el contenedor de las filas del cuerpo de la tabla
 * @param {*} contNumeros Es el contenedor de los numeros para la selecion de paginacion
 * @param {CallableFunction} funcionRefrescar Sirve para refrescar los botonos del tbody
 * 
 * @return {*} void
 */
export function paginacionEstandares(datos,divicionDatos,numeroActual,tbody,contNumeros,funcionRefrescar = null){
    const total  = datos.length;
    const fracion = divicionDatos;
    const totalNumeros = Math.ceil((total / fracion));
    let comparacion = numeroActual; // Toma el numero que esta selecionado al momento de darle click
    let numerosUI = []; // Son los numeros en botones para darles click y realize la paginacion
    let inicio = (numeroActual - 1) * divicionDatos; 
    let fin = inicio + divicionDatos;
    let datosPaginados = datos.slice(inicio,fin);
    let html = '';
    datosPaginados.forEach((dato,i) => {
        html += `
        <tr>
        <td>
        ${dato.id_estandar}
        </td>
        <td>
        ${dato.nombre_indicador}
        </td>
        <td>
        ${dato.descripcion.slice(0,30)} 
        <span presentacion class="text-primary text-decoration-underline selector"
        data-dato="${dato.descripcion}">
        Ver más
        </span>
        </td>
        <td>
        ${dato.tipo}
        </td>
        <td>
        ${dato.nombre_criterio}
        </td>
        <td>
            <button notting type="button"  data-datos='${JSON.stringify(dato)}'
            class="boton m-auto boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
            >
            <span class="material-icons text-white">&#xe3c9;</span> Editar
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
                 paginacionEstandares(datos,divicionDatos,i,tbody,contNumeros,funcionRefrescar);
                 if(funcionRefrescar) funcionRefrescar();
            }
        );
        numerosUI.push(button);
    }
    tbody.innerHTML = '';
    contNumeros.innerHTML = '';
    tbody.innerHTML = html;

    const spans = tbody.querySelectorAll('span[presentacion]');
    presentacion(spans);
    if(totalNumeros <= 1 ) return; // Esto retorna sin rendirazar el numero uno de paginacion si solo contiene 1 num
    numerosUI.forEach(numero => {
                contNumeros.append(numero);
            });
}

function presentacion(buttons) {
    buttons.forEach(button => {
    const modal = document.createElement('div');
    button.addEventListener('click',(e) => {
            e.stopPropagation();
            modal.classList = 'modal fade';
            modal.id = `modalCarrera`;
            modal.setAttribute('tabindex','-1');
            modal.setAttribute('aria-labelledby','exampleModalLabel');
            modal.setAttribute('aria-hidden',true);
            modal.innerHTML = `
        <!-- Formulario -->
            <form>
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Descripción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <h4>Descripción del estandar</h4>
              <p class="p-2">
              ${button.dataset.dato}
                <p>
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
        const form = modal.querySelector('form');
        modalBootstrap.show();
        modal.addEventListener('hidden.bs.modal',(e) => {
            modal.remove();
        })

        form.addEventListener('submit',e => enviarDatos(e,modalBootstrap));
    })
    }) 
}



/**
 * 
 * @param {*} datos Son los datos como array
 * @param {*} divicionDatos Es el numero de elementos que desean que se presente
 * @param {*} numeroActual Es el numero que se encuentran los datos
 * @param {*} tbody Es el contenedor de las filas del cuerpo de la tabla
 * @param {*} contNumeros Es el contenedor de los numeros para la selecion de paginacion
 * @param {CallableFunction} funcionRefrescar Sirve para refrescar los botonos del tbody
 * 
 * @return {*} void
 */
export function paginacionElementosFundamentals(datos,divicionDatos,numeroActual,tbody,contNumeros,funcionRefrescar = null){
  const total  = datos.length;
  const fracion = divicionDatos;
  const totalNumeros = Math.ceil((total / fracion));
  let comparacion = numeroActual; // Toma el numero que esta selecionado al momento de darle click
  let numerosUI = []; // Son los numeros en botones para darles click y realize la paginacion
  let inicio = (numeroActual - 1) * divicionDatos; 
  let fin = inicio + divicionDatos;
  let datosPaginados = datos.slice(inicio,fin);
  let html = '';
  datosPaginados.forEach((dato,i) => {
      html += `
      <tr>
      <td>
      ${dato.id_elemento}
      </td>
      <td>
      ${dato.descripcion.slice(0,30)} 
      <span presentacion class="text-primary text-decoration-underline selector"
      data-dato="${dato.descripcion}">
      Ver más
      </span>
      </td>
      <td>
      ${dato.nombre_estandar}
      </td>
      <td>
          <button notting type="button"  data-datos='${JSON.stringify(dato)}'
          class="boton m-auto boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
          >
          <span class="material-icons text-white">&#xe3c9;</span> Editar
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
               paginacionElementosFundamentals(datos,divicionDatos,i,tbody,contNumeros,funcionRefrescar);
               if(funcionRefrescar) funcionRefrescar();
          }
      );
      numerosUI.push(button);
  }
  tbody.innerHTML = '';
  contNumeros.innerHTML = '';
  tbody.innerHTML = html;

  const spans = tbody.querySelectorAll('span[presentacion]');
  presentacion(spans);
  if(totalNumeros <= 1 ) return; // Esto retorna sin rendirazar el numero uno de paginacion si solo contiene 1 num
  numerosUI.forEach(numero => {
              contNumeros.append(numero);
          });
}

export function paginacionComponentes(datos,divicionDatos,numeroActual,tbody,contNumeros,funcionRefrescar = null){
  const total  = datos.length;
  const fracion = divicionDatos;
  const totalNumeros = Math.ceil((total / fracion));
  let comparacion = numeroActual; // Toma el numero que esta selecionado al momento de darle click
  let numerosUI = []; // Son los numeros en botones para darles click y realize la paginacion
  let inicio = (numeroActual - 1) * divicionDatos; 
  let fin = inicio + divicionDatos;
  let datosPaginados = datos.slice(inicio,fin);
  let html = '';
  datosPaginados.forEach((dato,i) => {
      html += `
      <tr>
      <td>
      ${dato.id_componente}
      </td>
      <td>
      ${dato.descripcion_elemento.slice(0,30)} 
      <span presentacion class="text-primary text-decoration-underline selector"
      data-dato="${dato.descripcion_elemento}">
      Ver más
      </span
      </td>
      <td>
      ${dato.descripcion.slice(0,30)} 
      <span presentacion class="text-primary text-decoration-underline selector"
      data-dato="${dato.descripcion}">
      Ver más
      </span>
      </td>
      <td>
          <button notting type="button"  data-datos='${JSON.stringify(dato)}'
          class="boton m-auto boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
          >
          <span class="material-icons text-white">&#xe3c9;</span> Editar
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
               paginacionComponentes(datos,divicionDatos,i,tbody,contNumeros,funcionRefrescar);
               if(funcionRefrescar) funcionRefrescar();
          }
      );
      numerosUI.push(button);
  }
  tbody.innerHTML = '';
  contNumeros.innerHTML = '';
  tbody.innerHTML = html;

  const spans = tbody.querySelectorAll('span[presentacion]');
  presentacion(spans);
  if(totalNumeros <= 1 ) return; // Esto retorna sin rendirazar el numero uno de paginacion si solo contiene 1 num
  numerosUI.forEach(numero => {
              contNumeros.append(numero);
          });
}



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
 * @return {*} void
 */
export function paginacionEvidencias(datos,divicionDatos,numeroActual,tbody,contNumeros,funcionRefrescar = null,columnaBusqueda = null,valor=null,paginar=null){
  const total  = datos.length;
  const fracion = divicionDatos;
  const totalNumeros = Math.ceil((total / fracion));
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
  }
  datosPaginados.forEach((dato,i) => {
      const criterio = [...new Set(dato.nombre_criterio?.split('---'))];
      const descripcionEstandar = [...new Set(dato.descripcion_estandar?.split('---'))];
      const idElemento = [...new Set(dato.id_elemento?.split('---'))];
      const descripcionElemento = [...new Set(dato.descripcion_elemento?.split('---'))];
      const idcomponente = [...new Set(dato.id_componente?.split('---'))];
      const descripcionComponentes = [...new Set(dato.descripcion_componente?.split('---'))];
      const nombre_Evidencia = [...new Set(dato.nombre_evidencias?.split('---'))];
      const id_evidencias = [...new Set(dato.id_evidencias?.split('---'))];
      const htmlbotonEditar  = `
      <button type="button" data-datos='${JSON.stringify(dato)}'
       class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
      >
      <span class="material-icons text-white">&#xe3c9;</span> Editar 
      </button>        
      `;
      html += `
      <tr data-nombre-evidencia="${nombre_Evidencia.toString()}"
      >
      <td>${criterio.toString().substring(0,25)}
      <input type="hidden" value="${criterio.join('--')}"/>
      <input type="hidden" value="Criterios"/>
     <span class='ver-mas'>Ver más</span>
      </td>
      <td>${descripcionEstandar.toString().substring(0,25)}
          <input type="hidden" value="${descripcionEstandar.join('--')}"/>
          <input type="hidden" value="Estandares o Indicador"/>
         <span class='ver-mas'>Ver más</span>
      </td>
      <td>${idElemento + '<br>' + descripcionElemento.toString().substring(0,25)}
      <input type="hidden" value="${idElemento.join('--') + '??' + descripcionElemento.join('--')}"/>
      <input type="hidden" value="Elemento Fundamental--Descripción"/>
     <span class='ver-mas'>Ver más</span>
      </td>
      <td>${idcomponente + '<br>' + descripcionComponentes.toString().substring(0,25) }
      <input type="hidden" value="${idcomponente.join('--') + '??' + descripcionComponentes.join('--')}"/>
      <input type="hidden" value="Componente--Descripción"/>
     <span class='ver-mas'>Ver más</span>
      </td>
      <td>${nombre_Evidencia.toString().substring(0,40)}
      <input type="hidden" value="${nombre_Evidencia}"/>
        <input type="hidden" value="Nombre"/>
       <span class='ver-mas'>Ver más</span></td>
      <td>${id_evidencias.toString()}</td>
      <td>
        ${htmlbotonEditar}
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
               paginacionEvidencias(datos,divicionDatos,i,tbody,contNumeros,funcionRefrescar,columnaBusqueda,valor);
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