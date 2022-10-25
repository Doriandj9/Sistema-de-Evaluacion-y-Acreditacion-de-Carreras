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
 export function paginacionCarreras(datos,divicionDatos,numeroActual,tbody,contNumeros,funcionRefrescar = null){
    const total  = datos.length;
    const fracion = divicionDatos;
    const totalNumeros = Math.ceil((total / fracion));
    let comparacion = numeroActual; // Toma el numero que esta selecionado al momento de darle click
    let numerosUI = []; // Son los numeros en botones para darles click y realize la paginacion
    let inicio = (numeroActual - 1) * divicionDatos; 
    let fin = inicio + divicionDatos;
    const datosPaginados = datos.slice(inicio,fin);
    let html = '';
    datosPaginados.forEach((dato) => {
        html += `
        <tr>
        <td>${dato.id_carrera}</td>
        <td>${dato.nombre_carrera}</td>
        <td>${dato.nombre_facultad}</td>
        <td>${dato.numero_asig}</td>
        <td>${dato.total_horas_proyecto}</td>
        <td>
            <button type="button" class="boton boton-enviar is-hover-boton-enviar p-2 d-flex aling-items-center gap-flex-1"
            >
                <span class="material-icons text-white">&#xe3c9;</span>
                Editar 
            </button>
            <div class="hidden" data-contenido='${JSON.stringify(dato)}'></div>
        </td>
      </tr>
        `;;
    })
    
    for(let i = 1 ; i <= totalNumeros ; i++){
        const button = document.createElement('button');
        button.textContent = i;
        if(i === comparacion) button.classList.add('active'); // Si el numero actual es igual que el del boton ese
        button.addEventListener('click',() => { // boton esta selecionado 
                 paginacionCarreras(datos,divicionDatos,i,tbody,contNumeros,funcionRefrescar);
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
export function paginacionCarrerasHabilitas(datos,divicionDatos,numeroActual,tbody,contNumeros,funcionRefrescar = null){
    const total  = datos.length;
    const fracion = divicionDatos;
    const totalNumeros = Math.ceil((total / fracion));
    let comparacion = numeroActual; // Toma el numero que esta selecionado al momento de darle click
    let numerosUI = []; // Son los numeros en botones para darles click y realize la paginacion
    let inicio = (numeroActual - 1) * divicionDatos; 
    let fin = inicio + divicionDatos;
    const datosPaginados = datos.slice(inicio,fin);
    let html = '';
    datosPaginados.forEach((dato,i) => {
        html += `
        <tr>
        <td class="d-flex align-items-center gap-3">
            <input type="checkbox" ${dato.opcion === 'activo' ? 'disabled checked data-db-content="true"' : ''} id="">
            <label for="">${dato.opcion === 'activo' ? '<span class="text-success">Habilitado</span>' : 'Desabilitado'}</label>
            <input type="hidden" name="id_carrera${i}" value="${dato.id.trim()}">
        </td>
        <td>${dato.id}</td>
        <td>${dato.nombre}</td>
        <td>${dato.periodo}</td>
      </tr>
        `;;
    })
    
    for(let i = 1 ; i <= totalNumeros ; i++){
        const button = document.createElement('button');
        button.textContent = i;
        if(i === comparacion) button.classList.add('active'); // Si el numero actual es igual que el del boton ese
        button.addEventListener('click',() => { // boton esta selecionado 
                 paginacionCarrerasHabilitas(datos,divicionDatos,i,tbody,contNumeros,funcionRefrescar);
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