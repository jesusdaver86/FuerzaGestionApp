<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*require_once "../controladores/pasajeros.controlador.php";
require_once "../modelos/pasajeros.modelo.php";*/
use Controladores\ControladorPasajeros;
use Modelos\ModeloPasajeros;

class AjaxPasajeros {

    /*=============================================
    EDITAR PASAJERO
    =============================================*/

    public $idPasajero;

    public function ajaxEditarPasajero() {
    $item = "id";
    $valor = $this->idPasajero;

    $respuesta = ControladorPasajeros::ctrMostrarPasajeros($item, $valor);

    // Asegúrate de que la respuesta sea un array
    if (is_array($respuesta) && count($respuesta) > 0) {
        echo json_encode($respuesta);
    } else {
        echo json_encode([]);
    }
}


    /*=============================================
    ACTIVAR PASAJERO
    =============================================*/

    public $activarPasajero;
    public $activarId;

    public function ajaxActivarPasajero() {
        $tabla = "pasajeros";

        $item1 = "estado";
        $valor1 = $this->activarPasajero;

        $item2 = "id";
        $valor2 = $this->activarId;

        $respuesta = ModeloPasajeros::mdlActualizarPasajero($tabla, $item1, $valor1, $item2, $valor2);

        echo json_encode($respuesta); // Return a JSON response
    }

    /*=============================================
    CREAR PASAJERO (AJAX)
    =============================================*/
public function ajaxCrearPasajero() {
    if (isset($_POST["nuevoDocumentoId"])) { // Check if the required fields are set
        $datos = array(
            "nombre" => $_POST["nuevoPasajero"],
            "documento" => $_POST["nuevoDocumentoId"],
            "gerencia" => $_POST["nuevaGerencia"],
            "nroUnidad" => $_POST["nuevoNroUnidad"],
            "fecha_c" => $_POST["nuevaFechaC"]
        );
        $tabla = "pasajeros"; // Cambiar a la tabla correcta
        $respuesta = ModeloPasajeros::mdlIngresarPasajero($tabla, $datos);
        if ($respuesta == "ok") {
            $response = array("success" => true, "message" => "Pasajero agregado correctamente");
        } else {
            $response = array("success" => false, "message" => "Error al agregar el pasajero: " . $respuesta);
        }
    } else {
        $response = array("success" => false, "message" => "Faltan datos");
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}


/*=============================================
EJECUTAR ACCIONES AJAX
=============================================*/

// EDITAR PASAJERO
if (isset($_POST["idPasajero"])) {
    $pasajero = new AjaxPasajeros();
    $pasajero->idPasajero = $_POST["idPasajero"];
    $pasajero->ajaxEditarPasajero();
}

// ACTIVAR PASAJERO
if (isset($_POST["activarPasajero"])) {
    $activarPasajero = new AjaxPasajeros();
    $activarPasajero->activarPasajero = $_POST["activarPasajero"];
    $activarPasajero->activarId = $_POST["activarId"];
    $activarPasajero->ajaxActivarPasajero();
}

// CREAR PASAJERO
if (isset($_POST["accion"]) && $_POST["accion"] == "crearPasajero") {
    $ajax = new AjaxPasajeros();
    $ajax->ajaxCrearPasajero();
}
