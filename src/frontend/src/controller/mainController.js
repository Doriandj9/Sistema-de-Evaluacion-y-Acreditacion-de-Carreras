
(function(){
    const url = new URL(location.href);
    let path = url.pathname
    let pathArray = path.split('/');
    path = pathArray[1];
    const controllerMain = {
        '': function(){ 
            import('./../pages/login.js')
            .then()
            .catch(e => console.error('[JS002] ' + e));
         },
         'opciones': function(){ 
            import('./../pages/opciones.js')
            .then()
            .catch(e => console.error('[JS002] ' + e));
         },
        'docente': function(){
            import('./docenteController.js')
            .then()
            .catch(e => console.error('[JS002] ' + e));        
        },
        'coordinador': function(){
            import('./coordinadorController.js')
            .then()
            .catch(e => console.error('[JS002] ' + e));           
        },
        'evaluador': function(){
            import('./evaluadorController.js')
            .then()
            .catch(e => console.error('[JS002] ' + e));           
        },
        'director-planeamiento': function(){
                      
        },
        'admin': function(){
            import('./adminController.js')
            .then()
            .catch(e => console.error('[JS002] ' + e));
        }
    };
    try{

        controllerMain[path]();
    }catch(error){
        console.error('Error: [JS001]' + error);
    }
})();