<div id="requiere-cambio-clave">
  <input type="hidden" id="cambio-clave" value="<?=$usuario->cambio_clave ?? true;?>">
</div>
<div class="d-flex w-100 h-100 justify-content-between mt-4">
  <div class="w-25  dropend ms-3" id="menu-opciones">
        <div class="container-fluid bg-primary p-2 text-white text-center">
            Menu
        </div>
  
        <button data-content-permision="4" type="button" class="btn btn-color-gris container-fluid color-active rounded-0
        d-flex align-items-center gap-2 text-start " data-bs-toggle="dropdown" aria-expanded="false">
        <span class="material-icons">&#xe5c8;</span> <span class="fw-bold">Coordinador</span>
        </button>
        <ul class="dropdown-menu w-100 d-none">
        </ul>

        <button data-content-permision="1" type="button" class="btn btn-color-gris container-fluid color-active rounded-0 
        d-flex align-items-center gap-2 text-start " data-bs-toggle="dropdown" aria-expanded="false">
        <span class="material-icons">&#xe5c8;</span> <span class="fw-bold">Docente</span>  
        </button>
        <ul class="dropdown-menu w-100 d-none">
        </ul>

        <button data-content-permision="8" type="button" class="btn btn-color-gris container-fluid color-active rounded-0
        d-flex align-items-center gap-2 text-start " data-bs-toggle="dropdown" aria-expanded="false">
        <span class="material-icons">&#xe5c8;</span> <span class="fw-bold">Evaluador</span>  
        </button>
        <ul class="dropdown-menu w-100 d-none">
        </ul>
        <a href="/salir" class="btn btn-color-gris text-danger container-fluid color-active rounded-0
        d-flex align-items-center gap-2 text-start">
        <span class="material-icons">&#xe5c8;</span> <span class="fw-bold">Salir</span>  
        </a>
        <ul class="dropdown-menu w-100 d-none">
        </ul>
  </div>
  <div class="w-65 h-90 bg-secondary me-3 d-flex justify-content-center align-items-end">
      <div class="cuadro-blaco-p mb-2 d-flex flex-column">
      <div class="w-100 h-p-1 bg-color-gris d-flex justify-content-around  align-items-end">
        <div class="position-relative ancho1">  
          <div class="cuadro-redondo">
            <img src="/public/assets/img/undraw_book_lover_re_rwjy.svg" class="position-absolute img-header-options" height="54" width="64"  alt="">
          </div>
        </div>
        <div class="d-flex justify-content-between flex-grow-1">
          <div class="fw-bold">Carreras Acreditadas</div>
          <div class="d-flex w-50 justify-content-evenly fw-bold">
            <div class="d-flex align-items-center gap-2"> <span class="material-icons">&#xe8df;</span><span id="fecha"></span></div>
            <div class="d-flex align-items-center gap-2"> <span class="material-icons">&#xe924;</span><span id="hora"></span></div>
          </div>
        </div>
      </div>
        <div class="flex-grow-1 d-flex justify-content-center align-items-center" id="contenido">
              <div class="w-100 h-100 m-3">
                  <div class="w-100 mt-4">
                    <h3 class="text-center tipografia-sanSerif-4">
                    SISTEMA DE EVALUACIÓN Y ASEGURAMIENTO DE LA CALIDAD
                    </h3>
                    <p class="text-justificado tipografia-sanSerif-1">SEAC, es un sistema web que permite el almacenamiento de información
                       que apoya en la Evaluación y Aseguramiento de la Calidad de las carreras.</p>
                  </div>
                  <div class="w-100 d-flex justify-content-around gap-5 tipografia-sanSerif-1 flex-wrap">
                    <div class="d-flex flex-column justify-content-center align-items-center ancho-tarjetas-1">
                      <img class="img-inicio-options-home" src="/public/assets/img/undraw_my_files_swob.svg" alt="files">
                      <section>
                        <h5 class="tipografia-sanSerif-4 mt-3">
                        ALMACENAMIENTO DE EVIDENCIAS:
                        </h5>
                        <p class="text-justificado">
                        Permitirá a los usuarios poder almacenar la informacion de manera rápida y
                         segura de las carreras de la facultad.
                        </p>
                    </section>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center ancho-tarjetas-1">
                      <img class="img-inicio-options-home" src="/public/assets/img/undraw_split_testing_l1uw.svg" alt="test">
                      <section>
                        <h5 class="tipografia-sanSerif-4 mt-3">
                        EVALUADOR DE EVIDENCIAS:
                        </h5>
                        <p class="text-justificado">
                          Permitirá al evaluador poder evaluar las evidencias de manera rápida y segura para apoyar en el aseguramiento de la calidad de las carreras. 
                        </p>
                      </section>
                    </div>
                  </div>
                  <div class="w-100 d-flex justify-content-center gap-5 tipografia-sanSerif-1 flex-wrap">
                  <div class="d-flex justify-content-center align-items-center ancho-tarjetas-1">
                      <img class="img-inicio-options-home" src="/public/assets/img/undraw_diary_re_4jpc.svg" alt="files">
                      <section>
                        <h5 class="tipografia-sanSerif-4 mt-3">
                        REPORTES:
                        </h5>
                        <p class="text-justificado">
                          Permitirá generar reportes de las evidencias tanto almacendas como evaluadas.
                        </p>
                    </section>
                    </div>
                  </div>
              </div>
              
        </div>
      </div>
  </div>
</div>