<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="/public/css/app.css">
    <link rel="stylesheet" href="/public/css/bootstrap/bootstrap-custom.css">
    <title><?= $titulo; ?></title>
</head>
<body>
    <div class="contenedor-principal">
        <header class="l-enlinea-flex encabezado-principal">
            <img src="/public/assets/img/ueb-logo.png" alt="logo de la carrera de la Universidad">
            <img src="/public/assets/img/seac-logo.png" alt="logo del sistema SEAC">
        </header>
        <div class="rectangulo-azul"></div>
        <main class="cuerpo-principal-2">
                    <div class="contenido-principal">
                        <?= $contenido; ?>
                    </div>
        </main>
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
    <script src="/public/js/app.js" type="module"></script>
</body>
</html>