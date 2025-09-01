<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Meta Tags Básicos -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Fuerza Gestion APP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <!-- Meta Tags de Seguridad y PWA -->
  <meta name="theme-color" content="#343a40">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' https:; style-src 'self' 'unsafe-inline' https:; img-src 'self' data: https:; font-src 'self' https:;">

  <!-- Favicon y Manifest -->
  <link rel="manifest" href="./manifest.json" crossorigin="use-credentials">
  <link rel="shortcut icon" href="assets/icons/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" href="assets/icons/icon-192x192.png">

  <!-- Preload de Recursos Críticos -->
  <link rel="preload" href="node_modules/jquery/dist/jquery.min.js" as="script">
  <link rel="preload" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css" as="style">
  <link rel="preload" href="vistas/dist/css/AdminLTE.min.css" as="style">
  <link rel="preload" href="vistas/bower_components/font-awesome/css/font-awesome.min.css" as="style">

  <!-- Hojas de Estilo Principales -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">

  <!-- CSS Secundario (Diferido) -->
  <link rel="preload" href="node_modules/sweetalert2/dist/sweetalert2.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css"></noscript>

  <!-- Configuración Global Temprana -->
  <script>
    window.appConfig = {
      baseUrl: '<?= isset($_SERVER['HTTPS']) ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'] ?>',
      csrfToken: '<?= $_SESSION['csrf_token'] ?? '' ?>',
      debugMode: <?= (isset($_SERVER['APP_DEBUG']) && $_SERVER['APP_DEBUG']) ? 'true' : 'false' ?>
    };
  </script>

  <!-- Scripts Críticos con defer -->
  <script src="node_modules/jquery/dist/jquery.min.js"></script>

  <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js" defer></script>
  <script src="vistas/dist/js/adminlte.min.js" defer></script>
</head>

<body class="hold-transition skin-black-light sidebar-collapse sidebar-mini <?= isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok" ? '' : 'login-page' ?>">

<?php
// Obtener la ruta actual
$rutaActual = $_GET["ruta"] ?? 'inicio';

// Manejo especial para logout - evitar verificación de sesión
if ($rutaActual === 'salir') {
    // Incluir directamente el módulo de salir sin verificar sesión
    include "modulos/salir.php";
    exit();
}

// Redirigir si el usuario logueado intenta acceder al login
if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] === "ok" && $rutaActual === 'login') {
    header('Location: inicio');
    exit();
}

// Verificar sesión para todas las demás rutas
if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
?>
  <div class="wrapper">
    <?php
    include "modulos/cabezote.php";
    include "modulos/menu.php";

    // Sistema de enrutamiento mejorado
    $ruta = $_GET["ruta"] ?? 'inicio';
    $rutasPermitidas = [
      "inicio", "usuarios", "trabajadores", "elFinder", "operadores",
      "origenes", "destinos", "marcas", "unidades", "pasajeros",
      "reportes", "reportesp", "salir"
    ];

    $archivo = in_array($ruta, $rutasPermitidas) ? "modulos/$ruta.php" : "modulos/404.php";

    // Verificar si el archivo existe antes de incluirlo
    if (file_exists($archivo)) {
        include $archivo;
    } else {
        include "modulos/404.php";
    }

    include "modulos/footer.php";
    ?>
  </div>
<?php } else { ?>
  <?php
  // Si la ruta es login, mostrar login, sino redirigir
  if ($rutaActual === 'login') {
      include "modulos/login.php";
  } else {
      // Redirigir al login si no hay sesión y no está en login
      echo '<script>window.location.href = "?ruta=login";</script>';
  }
  ?>
<?php } ?>

<!-- Scripts no críticos (carga diferida) -->
<script defer src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
<script defer src="vistas/bower_components/datatables.net/js/jquery.dataTables.js"></script>
<script defer src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


<script src="vistas/bower_components/moment/min/moment.min.js"></script>
<script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="vistas/bower_components/raphael/raphael.min.js"></script>
<script src="vistas/bower_components/morris.js/morris.min.js"></script>
<script src="vistas/Jcrop/dist/jcrop.js"></script>
<script src="assets/lightbox2/dist/js/lightbox.min.js"></script>
<script src="assets/js/d3.v7.js"></script>

<!-- Carga modular de scripts según la página -->
<script type="module">
  import { cargarScripts } from './vistas/js/module-loader.js';

  const paginaActual = '<?= $ruta ?? 'inicio' ?>';
  const scriptsNecesarios = {
    'usuarios': ['vistas/usuarios.js'],
    'trabajadores': ['vistas/js/trabajadores.js'],
    'operadores': ['vistas/js/operadores.js'],
    'origenes': ['vistas/js/origenes.js'],
    'destinos': ['vistas/js/destinos.js'],
    'marcas': ['vistas/js/marcas.js'],
    'unidades': ['vistas/js/unidades.js'],
    'pasajeros': ['vistas/js/pasajeros.js'],
    'reportes': ['vistas/js/reportes.js'],
    'default': ['vistas/js/plantilla.js']
  };

  const scriptsNecesarios2 = {
    'usuarios': ['modulos/usuarios.php'],
    'trabajadores': ['modulos/trabajadores.php'],
    'operadores': ['modulos/operadores.php'],
    'origenes': ['modulos/origenes.php'],
    'destinos': ['modulos/destinos.php'],
    'marcas': ['modulos/marcas.php'],
    'unidades': ['modulos/unidades.php'],
    'pasajeros': ['modulos/pasajeros.php'],
    'reportes': ['modulos/reportes.php'],
    'default': ['vistas/js/plantilla.js']
  };

  cargarScripts(paginaActual, scriptsNecesarios, scriptsNecesarios2);
</script>

<!-- Service Worker con manejo de errores -->
<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('/fuente/service-worker.js', {
        scope: '/fuente/'
      }).then(registration => {
        console.log('SW registrado:', registration.scope);
      }).catch(error => {
        console.error('Error SW:', error);
      });
    });
  }
</script>

</body>
</html>
