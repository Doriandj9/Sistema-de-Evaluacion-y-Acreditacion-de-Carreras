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
        const ref = i.href.trim();
        const contentInterno = content.href.trim();
        if(ref === contentInterno){
            i.classList.add('is-activo-item-menu');
        }
    })

})();