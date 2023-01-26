<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" -->

    <!-- favicon -->

    <link rel="apple-touch-icon" sizes="57x57" href="/public/assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/public/assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/public/assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/public/assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/public/assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/public/assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/public/assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/public/assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/public/assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/public/assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/public/assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/public/assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="/public/css/app.css">
    <link rel="stylesheet" href="/public/css/bootstrap/bootstrap-custom.css">
    <title><?= $titulo; ?></title>
</head>
<body>
    <div class="contenedor-principal">
        <header class="l-enlinea-flex encabezado-principal">
            <img src="/public/assets/img/ueb-logo.png" style="width: 10rem;" alt="logo de la carrera de la UEB">
            <img src="/public/assets/img/seac-logo.png" alt="logo del sistema SEAC">
        </header>
        <main class="cuerpo-principal">
            <div class="menu-lateral barra-personalizada desborde-auto">
                <div class="contenedor-informacion">
                    <h4>Información</h4>
                    <ul class="flex-columna gap-flex-1 list-unstyled">
                            <li class="flex-linea l-enlinea-flex flex-items-center gap-flex-1">
                                <span class="material-icons">&#xe7fd;</span>
                                <span class="text-blanco text-w-medio"><?= preg_split('/ /',$usuario->nombre)[0]  ?> <?= preg_split('/ /',$usuario->apellido)[0]; ?></span>
                            </li>
                            <li class="flex-linea l-enlinea-flex flex-items-center gap-flex-1">
                                <span class="material-icons">&#xe80c;</span>
                                <span class="text-blanco text-w-medio">Administrador</span>
                            </li>
                    </ul>
                </div>
                <div class="contenedor-navegacion">
                    <h6 class="text-blanco borde-top text-center">Menú Principal</h6>
                    <nav class="flex-columna margin-top-menos-1" id="menu-principal">
                        <a href="/admin/agregar/ciclo/academico" class="flex-linea text-decoration-none l-enlinea-flex flex-items-center hover-op-menu gap-flex-0-5">
                        <span class="material-icons text-negro">&#xe02f;</span>
                        <span class="text-blanco bordes-op-menu">Periodo Académico</span>
                        </a>
                        </a>
                        <a href="/admin/agregar/facultad" class="flex-linea text-decoration-none l-enlinea-flex flex-items-center hover-op-menu gap-flex-0-5">
                        <span class="material-icons text-negro">&#xea3e;</span>
                        <span class="text-blanco bordes-op-menu">Facultades</span>
                        </a>
                        <a href="/admin/administrar/carreras" class="flex-linea text-decoration-none l-enlinea-flex flex-items-center hover-op-menu gap-flex-0-5">
                        <span class="material-icons text-negro">&#xe0e0;</span>
                        <span class="text-blanco bordes-op-menu ">Carreras / Habilitación</span>
                        </a>
                        <a href="/admin/agregar/coordinador" class="flex-linea text-decoration-none l-enlinea-flex flex-items-center hover-op-menu gap-flex-0-5">
                        <span class="material-icons text-negro">&#xe7fe;</span>
                        <span class="text-blanco bordes-op-menu ">Coordinador de Carrera</span>
                        </a>
                        <a href="/admin/administrar/director-planeacion" class="flex-linea text-decoration-none l-enlinea-flex flex-items-center hover-op-menu gap-flex-0-5">
                        <span class="material-icons text-negro">&#xe9b1;</span>
                        <span class="text-blanco bordes-op-menu ">Director de Planeamiento</span>
                        </a>
                        <a href="/admin/actualizar/docentes" class="flex-linea text-decoration-none l-enlinea-flex flex-items-center hover-op-menu gap-flex-0-5">
                        <span class="material-icons text-negro">&#xf233;</span>
                        <span class="text-blanco bordes-op-menu ">Datos Docentes</span>
                        </a>
                        <a href="/admin/respaldo/db" class="flex-linea text-decoration-none l-enlinea-flex flex-items-center hover-op-menu gap-flex-0-5">
                        <span class="material-icons text-negro">&#xe1db;</span>
                        <span class="text-blanco bordes-op-menu ">Respaldos</span>
                        </a>
                        <a href="/admin/cambio/clave" class="flex-linea text-decoration-none l-enlinea-flex flex-items-center hover-op-menu gap-flex-0-5">
                        <span class="material-icons text-negro">&#xeade;</span>
                        <span class="text-blanco bordes-op-menu ">Cambiar Contraseña</span>
                        </a>
                        <a href="/salir" class="flex-linea text-decoration-none l-enlinea-flex flex-items-center hover-op-menu gap-flex-0-5 salir">
                        <span class="material-icons text-negro">&#xe9ba;</span>
                        <span class="text-blanco bordes-op-menu ">Cerrar Sesión</span>
                        </a>
                        
                        
                    </nav>
                </div>
            </div>
            <div class="contenedor-contenido-principal">
                    <div class="contenido-principal position-relative">
                        <div class="contenedor-contenido-vistas">
                            <?= $contenido ?>
                        </div>
                    </div>
                    <footer class="footer-principal">
                    <div class="text-center margin-arriba-1">
                <img src="/public/assets/img/creative-commons.png" width="100" height="15" alt="creative commons">
            </div>
            <p class="text-center text-blanco margin-arriba-1">
            Esta obra está bajo una Licencia Creative Commons Atribución
             - No Comercial - Sin Obras Derivadas 3.0 Ecuador This site is powered by Carrera de Software
            </p>
                    </footer>
            </div>
        </main>
    </div>
    <script src="/src/frontend/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/public/js/app.js" type="module"></script>
</body>
</html>