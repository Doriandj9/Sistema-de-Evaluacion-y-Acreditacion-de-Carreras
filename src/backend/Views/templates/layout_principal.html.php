<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel="stylesheet" href="/public/css/app.css">
    <title><?= $titulo; ?></title>
</head>
<body>
    <div class="contenedor-principal">
        <header class="l-enlinea-flex encabezado-principal">
            <img src="/public/assets/img/software-logo.png" alt="logo de la carrera de software">
            <img src="/public/assets/img/seac-logo.png" alt="logo del sistema SEAC">
        </header>
        <div class="rectangulo-azul"></div>
        <main class="cuerpo-principal centrado-absoluto">
                    <div class="contenido-principal centrado-absoluto">
                        <?= $contenido; ?>
                    </div>
        </main>
        <footer class="footer-principal">
        </footer>
    </div>
    <script src="/public/js/app.js" type="module"></script>
</body>
</html>