export default class MenuOpcionesSuperior {
    static correr() {
        const contenedorMenu = document.getElementById('contenedor-menu-superior');
        const listasLI = contenedorMenu.querySelectorAll('li');
        listasLI.forEach(li => {
            li.addEventListener('click',activo);
        })

        function activo(e) {
            e.preventDefault();
            listasLI.forEach(li => {
                if(li.classList.contains('is-activo-op-menu')) li.classList.remove('is-activo-op-menu');
            });
            e.target.classList.add('is-activo-op-menu');
        }
    }
    /**
     * Esta funcion recive un arrar que contiene mas array con tres posiciones 
     * 1. la opcion del menu donde se le dara un evento de click para cuando se active
     * renderize la vista al igual que la accion que estes asociada a esta
     * 2. la vista es el html que se renderizara cuando se de click ala opcion
     * 3. la accion el lo que se realizara dentro de la vista como cargar elementos,
     * cargar asincronicamente datos y agregar luego en un tabla etc.
     * 4. El focus es el opcional y se debe enviar solo en el caso de que esa vista sea
     * la primera que se renderizara al cargar la pagina
     * 5. un ejemplo de como enviar el actionViews EJM. [[option,view,action,focus]]
     * @param {Array} actionViews son un arrary con mas array de 4 posiociones
     * 
     * @returns {void}
     */
    static renderVistasAcciones(actionViews) {
        const contenedorMenu = document.getElementById('cambio-vistas');
        actionViews.forEach(actionView => {
            const [option,view,action,focus] = actionView;
            if(focus && focus === 'focus') renderVistas(view,action);
            option.addEventListener('click',() => renderVistas(view,action));
        })

        function renderVistas(view,action = null){
            contenedorMenu.innerHTML = view;
            if(action){
                action();
            }
        }
    }
}
