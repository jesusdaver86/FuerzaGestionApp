<?php
// modulos/salir.php
require_once "../controladores/usuarios.controlador.php";

// Cerrar sesión usando el controlador
ControladorUsuarios::ctrCerrarSesion();

// Redirigir al login después de cerrar sesión
echo '<script>window.location.href = "?ruta=login";</script>';
exit();
?>