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
 export function paginacionDirectorPlaneacion(datos,divicionDatos,numeroActual,tbody,contNumeros,funcionRefrescar = null){
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
        <td>${dato.id_docentes}</td>
        <td>${dato.nombre.split(' ')[0] + ' ' + dato.apellido.split(' ')[0]}</td>
        <td>${dato.correo}</td>
        <td>${dato.fecha_inicial}</td>
        <td>${dato.fecha_final}</td>
        <td>${dato.estado}</td>
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
                 paginacionDirectorPlaneacion(datos,divicionDatos,i,tbody,contNumeros,funcionRefrescar);
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