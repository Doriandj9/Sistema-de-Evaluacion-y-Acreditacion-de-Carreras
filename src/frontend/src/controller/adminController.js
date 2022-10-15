(function(){
    const url = new URL(location.href);
    let path = url.pathname;
    let arrayPath = path.split('/')
    if(arrayPath[arrayPath.length-1] === '') 
        path = path.substring(0,path.length-1);
    const controllerMain = {
        "/admin/agregar/ciclo/academico": function(){
            importacionDinamica('cicloAcademico.js');
        },
        "/admin/agregar/facultad": function(){
            importacionDinamica('facultades.js');
        },
        "/admin/agregar/coordinador": function(){
            importacionDinamica('coordinador.js');
        },
        "/admin": function(){

        }
    };
    try{
        controllerMain[path]();
    }catch(error){
        console.error('Error: [JS001]' + error);
    }
    function importacionDinamica(url){
        import('./../pages/admin/' + url)
            .then()
    }
})();