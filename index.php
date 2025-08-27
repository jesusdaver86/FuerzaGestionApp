<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- Manejo de sesión seguro y centralizado ---
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    
    // Generar token CSRF solo si no existe o la sesión es nueva
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    // Inicializar variable de sesión si no existe
    $_SESSION['iniciarSesion'] = $_SESSION['iniciarSesion'] ?? '';
}

// --- Manejo de logout ---
if (isset($_GET['ruta']) && $_GET['ruta'] === 'salir') {
    require_once "controladores/usuarios.controlador.php";
    
    // Usar el método del controlador para cerrar sesión
    ControladorUsuarios::ctrCerrarSesion();
    
    // Redirigir al login
    header("Location: ?ruta=login");
    exit();
}

// --- Carga de controladores y modelos ---
require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/trabajadores.controlador.php";
require_once "controladores/operadores.controlador.php";
require_once "controladores/origenes.controlador.php";
require_once "controladores/destinos.controlador.php";
require_once "controladores/marcas.controlador.php";
require_once "controladores/unidades.controlador.php";
require_once "controladores/pasajeros.controlador.php";

require_once "modelos/usuarios.modelo.php";
require_once "modelos/trabajadores.modelo.php";
require_once "modelos/operadores.modelo.php";
require_once "modelos/origenes.modelo.php";
require_once "modelos/destinos.modelo.php";
require_once "modelos/marcas.modelo.php";
require_once "modelos/unidades.modelo.php";
require_once "modelos/pasajeros.modelo.php";

require_once "extensiones/vendor/autoload.php";

// --- Inicializar aplicación ---
$plantilla = new ControladorPlantilla();
$plantilla->ctrPlantilla();