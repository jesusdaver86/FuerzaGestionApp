<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TTOcc Gestion TP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="icon" href="vistas/img/plantilla/icono-negro.ico">

  <!-- PLUGINS DE CSS -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/Buttons/css/buttons.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/plugins/iCheck/all.css">
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="vistas/bower_components/morris.js/morris.css">
  <link rel="stylesheet" href="vistas/Jcrop/dist/jcrop.css">
  <link rel="stylesheet" href="assets/lightbox2/dist/css/lightbox.min.css">


  <!-- PLUGINS DE JAVASCRIPT -->
  <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
  <script src="vistas/dist/js/adminlte.min.js"></script>
  <script src="vistas/bower_components/datatables.net/js/jquery.dataTables.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/datatables.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/Buttons/js/buttons.bootstrap.min.js"></script>
  <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
  <script src="vistas/plugins/iCheck/icheck.min.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <script src="vistas/plugins/jqueryNumber/jquerynumber.min.js"></script>
  <script src="vistas/bower_components/moment/min/moment.min.js"></script>
  <script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="vistas/bower_components/raphael/raphael.min.js"></script>
  <script src="vistas/bower_components/morris.js/morris.min.js"></script>
  <script src="vistas/bower_components/Chart.js/Chart.js"></script>
  <script src="vistas/Jcrop/dist/jcrop.js"></script>
  <script src="assets/lightbox2/dist/js/lightbox.min.js"></script>
  <script src="assets/js/d3.v7.js"></script>

</head>
 
<body class="hold-transition skin-red sidebar-collapse sidebar-mini login-page">

<?php
// Añadir al inicio del archivo
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");

// Iniciar sesión para CSRF
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
    echo '<div class="wrapper">';
    include "modulos/cabezote.php";
    include "modulos/menu.php";

    if (isset($_GET["ruta"])) {
        $rutas = array(
            "inicio",
            "usuarios",
            "trabajadores",
            "elFinder",
            "operadores",
            "origenes",
            "destinos",
            "marcas",
            "unidades",
            "pasajeros",
            "reportes",
            "reportesp",
            "salir"
        );

        if (in_array($_GET["ruta"], $rutas)) {
            include "modulos/" . $_GET["ruta"] . ".php";
        } else {
            include "modulos/404.php";
        }
    } else {
        include "modulos/inicio.php";
    }

    echo '</div>';
    include "modulos/footer.php";
} else {
    include "modulos/login.php";
}
?>

  <script type="text/javascript">
    function fadeOutAfterDelay(element) {
      setTimeout(function() {
        element.style.opacity = 0;
      }, 2000);
    }
  </script>

  <script src="vistas/js/plantilla.js"></script>
  <script src="vistas/js/usuarios.js"></script>
  <script src="vistas/js/trabajadores.js"></script>
  <script src="vistas/js/operadores.js"></script>
  <script src="vistas/js/origenes.js"></script>
  <script src="vistas/js/destinos.js"></script>
  <script src="vistas/js/marcas.js"></script>
  <script src="vistas/js/unidades.js"></script>
  <script src="vistas/js/pasajeros.js"></script>
  <script src="vistas/js/reportes.js"></script>
  <script src="vistas/developer-message.js"></script>
  <script src="vistas/main.js"></script>
</body>
</html>