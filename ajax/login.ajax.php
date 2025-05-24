<?php
// Habilitar reporte de errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Headers para evitar caché y especificar JSON
header("Cache-Control: no-cache, must-revalidate");
header("Content-Type: application/json; charset=UTF-8");

// Verificar si la petición es AJAX
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

if (!$isAjax) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Acceso no permitido']);
    exit;
}

try {
    // Verificar que los archivos requeridos existan
    if (!file_exists("../controladores/usuarios.controlador.php") || 
        !file_exists("../modelos/usuarios.modelo.php")) {
        throw new Exception("Error en la configuración del sistema");
    }

    require_once "../controladores/usuarios.controlador.php";
    require_once "../modelos/usuarios.modelo.php";

    // Verificar método POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        exit;
    }

    // Verificar datos recibidos
    if (!isset($_POST["ingUsuario"]) || !isset($_POST["ingPassword"])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        exit;
    }

    // Procesar el login llamando al controlador
    ControladorUsuarios::ctrIngresoUsuario();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error en el servidor: ' . $e->getMessage(),
        'trace' => $e->getTrace() // Solo para desarrollo, quitar en producción
    ]);
}

?>