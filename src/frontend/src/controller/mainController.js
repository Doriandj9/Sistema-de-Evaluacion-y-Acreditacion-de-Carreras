
(function(){
    const url = new URL(location.href);
    let path = url.pathname
    let pathArray = path.split('/');
    path = pathArray[1];
    const controllerMain = {
        "": function(){ 
            import('./../pages/login.js')
            .then()
            .catch(e => console.error('[JS002] ' + e));
         },
        "docente": function(){
                         
        },
        "admin": function(){
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