(function(){
    const url = new URL(location.href);
    let path = url.pathname;
    let arrayPath = path.split('/')
    if(arrayPath[arrayPath.length-1] === '') 
        path = path.substring(0,path.length-1);
    const controllerMain = {
        "/coordinador/docentes": function(){
            importacionDinamica('docentes.js');
        },
        "/coordinador/evidencias": function(){
            importacionDinamica('evidencias.js');
        },
        "/coordinador/responsables": function(){
            importacionDinamica('responsables.js');
        },
        "/coordinador/verificacion/evidencias": function(){
            importacionDinamica('verificacion-evidencias.js');
        },
        "/coordinador": function(){

        }
    };
    try{
        controllerMain[path]();
    }catch(error){
        console.error('Error: [JS001]' + error);
    }
    function importacionDinamica(url){
        import('./../pages/coordinador/' + url)
            .then()
    }
})();