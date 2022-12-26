(function(){
    const url = new URL(location.href);
    let path = url.pathname;
    let arrayPath = path.split('/')
    if(arrayPath[arrayPath.length-1] === '') 
        path = path.substring(0,path.length-1);
    const controllerMain = {
        "/docente/reportes": function(){
            importacionDinamica('reportes.js');
        },
        "/docente/evidencias": function(){
            importacionDinamica('evidencias.js');
        },
        "/docente/responsables": function(){
            importacionDinamica('responsables.js');
        },
        "/docente/notificaciones": function(){
            importacionDinamica('notificaciones.js');
        },
        "/docente": function(){

        }
    };
    try{
        controllerMain[path]();
    }catch(error){
        console.error('Error: [JS001]' + error);
    }
    function importacionDinamica(url){
        import('./../pages/docentes/' + url)
            .then()
    }
})();