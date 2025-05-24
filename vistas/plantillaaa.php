<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TTOcc Gestion TP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="icon" href="vistas/img/plantilla/icono-negro.ico">

  <!-- CSS -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/Buttons/css/buttons.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/plugins/iCheck/all.css">
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="vistas/bower_components/morris.js/morris.css">
  <link rel="stylesheet" href="vistas/Jcrop/dist/jcrop.css">
  <link rel="stylesheet" href="assets/lightbox2/dist/css/lightbox.min.css">
</head>

<body class="hold-transition skin-red sidebar-collapse sidebar-mini login-page">



<!-- JavaScript -->
<!--script src="vistas/bower_components/jquery/dist/jquery.min.js"></script-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
<script src="vistas/dist/js/adminlte.min.js"></script>
<script src="vistas/bower_components/datatables.net/js/jquery.dataTables.js"></script>
<script src="vistas/bower_components/datatables.net-bs/datatables.js"></script>
<script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>
<script src="vistas/plugins/iCheck/icheck.min.js"></script>
<script src="vistas/plugins/input-mask/jquery.inputmask.js"></script>
<script src="vistas/bower_components/moment/min/moment.min.js"></script>
<script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="vistas/bower_components/raphael/raphael.min.js"></script>
<script src="vistas/bower_components/morris.js/morris.min.js"></script>
<script src="vistas/Jcrop/dist/jcrop.js"></script>
<script src="assets/lightbox2/dist/js/lightbox.min.js"></script>
<script src="assets/js/d3.v7.js"></script>

<?php
if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
  echo '<div class="wrapper">';
  include "modulos/cabezote.php";
  include "modulos/menu.php";

  if(isset($_GET["ruta"])) {
    $rutas = [
      "inicio", "usuarios", "trabajadores", "elFinder", "operadores",
      "origenes", "destinos", "marcas", "unidades", "pasajeros",
      "reportes", "reportesp", "salir"
    ];
    
    include in_array($_GET["ruta"], $rutas) 
      ? "modulos/".$_GET["ruta"].".php" 
      : "modulos/404.php";
  } else {
    include "modulos/inicio.php";
  }
  
  echo '</div>';
  include "modulos/footer.php";
} else {
  include "modulos/login.php";
}
?>

<!-- Custom Scripts -->
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
<script src="vistas/main.js"></script>

</body>
</html>