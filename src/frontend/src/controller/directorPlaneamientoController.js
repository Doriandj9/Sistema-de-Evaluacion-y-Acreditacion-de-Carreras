(function(){
    const url = new URL(location.href);
    let path = url.pathname;
    let arrayPath = path.split('/')
    if(arrayPath[arrayPath.length-1] === '') 
        path = path.substring(0,path.length-1);
    const controllerMain = {
        "/director-planeamiento/base-indicadores": function(){
            importacionDinamica('base-indicadores.js');
        },
        "/director-planeamiento/emparejamiento-evaluadores": function(){
            importacionDinamica('emparejamiento-evaluadores.js');
        },
        "/director-planeamiento": function(){
            importacionDinamica('inicio.js');
        }
    };
    try{
        controllerMain[path]();
    }catch(error){
        console.error('Error: [JS001]' + error);
    }
    function importacionDinamica(url){
        import('./../pages/director_planeamiento/' + url)
            .then()
    }
})();