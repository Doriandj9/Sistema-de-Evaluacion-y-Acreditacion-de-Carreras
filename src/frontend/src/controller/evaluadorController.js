(function(){
    const url = new URL(location.href);
    let path = url.pathname;
    let arrayPath = path.split('/')
    if(arrayPath[arrayPath.length-1] === '') 
        path = path.substring(0,path.length-1);
    const controllerMain = {
        "/evaluador/evaluacion/documentos": function(){
            importacionDinamica('evaluacion.js');
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
        import('./../pages/evaluadores/' + url)
            .then()
    }
})();