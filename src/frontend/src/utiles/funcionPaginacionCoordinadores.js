
/**
 * 
 * @param {*} datos Son los datos como array
 * @param {*} divicionDatos Es el numero de elementos que desean que se presente
 * @param {*} numeroActual Es el numero que se encuentran los datos
 * @param {*} tbody Es el contenedor de las filas del cuerpo de la tabla
 * @param {*} contNumeros Es el contenedor de los numeros para la selecion de paginacion
 * @param {CallableFunction} funcionRefrescar Sirve para refrescar los botonos del tbody
 * @param {string} columnaBusqueda Es la columna que va servir para buscar las coindencias dentro de los datos
 * @param {string} valor Es el coincidencia que a buscar en la columna
 * 
 * @return {*} void
 */
 export function paginacionCoordinadores(datos,divicionDatos,numeroActual,tbody,contNumeros,funcionRefrescar = null,columnaBusqueda = null,valor=null){
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
        html += `
        <tr>
        <td>${dato.id_docentes}</td>
        <td>${dato.nombre_docente.split(' ')[0] + ' ' + dato.apellido.split(' ')[0]}</td>
        <td>${dato.correo}</td>
        <td>${dato.fecha_inicial}</td>
        <td>${dato.fecha_final}</td>
        <td>${dato.nombre_carrera}</td>
        <td>${dato.estado}</td>
      </tr>
        `;;
    })
    
    for(let i = 1 ; i <= totalNumeros ; i++){
        const button = document.createElement('button');
        button.textContent = i;
        if(i === comparacion) button.classList.add('active'); // Si el numero actual es igual que el del boton ese
        button.addEventListener('click',() => { // boton esta selecionado 
                 paginacionCoordinadores(datos,divicionDatos,i,tbody,contNumeros,funcionRefrescar);
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