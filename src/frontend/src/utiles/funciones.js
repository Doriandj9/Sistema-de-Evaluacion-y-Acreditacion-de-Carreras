/**
 * Esta funcion de llamado inmediato se usa para marcar como activa una opcion del menu
 * principal de las direntes vistas
 */

(function(){
    const menuPrincipal = document.getElementById('menu-principal');
    if(!menuPrincipal) return; // verificamos que este en una vista que contenga el menu para luego aplicar el proceso
    // de activar una opcion del menu segun el usuario
    const content = new URL(location.href);
    const items = menuPrincipal.querySelectorAll('a');
    items.forEach( i => {
        const refItem = new URL(i.href).pathname.trim(); // Contiene el url del path de cada <a> del menu principal
        const dirItem = content.pathname.trim();// Contiene el path del navegador web como '/admin' 

        if(refItem === dirItem){ // Si los dos path son iguales se le agrega la clase de que esa opcion esta activa actualmente
            i.classList.add('is-activo-item-menu'); // por ejemplo en el navegador esta el path /admin/agregar/coordinador
            // y en el <a href="/admin/agregar/coordinador"> es igual a /admin/agregar/coordinador se marca con la clase activa
        }
    })

})();

/**
 * Esta funcion perimite mostrar las contrasenias 
 */
 (function(){
    const ojo = document.querySelectorAll('#eye'); 
    if(!ojo && ojo.length === 0) return;
    ojo.forEach( e => {
        e.addEventListener('click',convert);
    })

    function convert(e){
        e.preventDefault();
        let input = e.target.previousElementSibling;
        if(input.hasAttribute('text')){
            input.removeAttribute('text');
            input.type = 'password';
            e.target.parentNode.classList.add('raya');
        }else{
            input.setAttribute('text','');
            input.type = 'text';
            e.target.parentNode.classList.remove('raya');
        }
        
    }
})();