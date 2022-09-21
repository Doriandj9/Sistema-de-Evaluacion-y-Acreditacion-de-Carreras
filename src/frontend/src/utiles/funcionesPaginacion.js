/**
 * 
 * @param {*} datos Son los datos como array
 * @param {*} divicionDatos Es el numero de elementos que desean que se presente
 * @param {*} numeroActual Es el numero que se encuentran los datos
 * @param {*} tbody Es el contenedor de las filas del cuerpo de la tabla
 * @param {*} contNumeros Es el contenedor de los numeros para la selecion de paginacion
 * 
 * @return {*} void
 */
export function paginacionCicloAcademico(datos,divicionDatos,numeroActual,tbody,contNumeros){
    const total  = datos.length;
    const fracion = divicionDatos;
    const totalNumeros = Math.ceil((total / fracion));
    let comparacion = numeroActual; // Toma el numero que esta selecionado al momento de darle click
    let numerosUI = []; // Son los numeros en botones para darles click y realize la paginacion
    let inicio = (numeroActual - 1) * divicionDatos; 
    let fin = inicio + divicionDatos;
    const datosPaginados = datos.slice(inicio,fin);
    let html = '';
    datosPaginados.forEach(dato => {
        html += `<tr>
            <td>
            ${dato.id}
            </td>
            <td>
            ${dato.fecha_inicial}
            </td>
            <td>
                ${dato.fecha_final}
            </td>
            <td>
                <button class="boton boton-enviar is-hover-boton-enviar block centrado-linea boton-iconos">
                <span class="material-icons text-blanco">&#xe3c9;</span>
                Editar 
                </button>
            </td>
        </tr>`;
    })
    
    for(let i = 1 ; i <= totalNumeros ; i++){
        const button = document.createElement('button');
        button.textContent = i;
        if(i === comparacion) button.classList.add('active'); // Si el numero actual es igual que el del boton ese
        button.addEventListener('click',() => { // boton esta selecionado 
                 paginacionCicloAcademico(datos,divicionDatos,i,tbody,contNumeros);
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

