<?php
// ESTO PRIMERO
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["iniciarSesion"]) || $_SESSION["iniciarSesion"] != "ok") {
    header("Location: login");
    exit();
}

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxUsuarios{

    /*=============================================
    EDITAR USUARIO
    =============================================*/ 
    public $idUsuario;

    public function ajaxEditarUsuario(){
        // Validar que $idUsuario sea un número entero positivo
        $id = filter_var($this->idUsuario, FILTER_VALIDATE_INT);
        if($id === false){
            echo json_encode(['error' => 'ID de usuario inválido']);
            return;
        }

        $item = "id";
        $valor = $id;

        $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

        echo json_encode($respuesta);
    }

    /*=============================================
    ACTIVAR USUARIO
    =============================================*/ 
    public $activarUsuario;
    public $activarId;

    public function ajaxActivarUsuario(){
        // Validar que activarUsuario sea 0 o 1
        $activar = ($this->activarUsuario == '1') ? 1 : 0;
        $id = filter_var($this->activarId, FILTER_VALIDATE_INT);
        if($id === false){
            echo json_encode(['error' => 'ID inválido para activar usuario']);
            return;
        }

        $tabla = "usuarios";

        $item1 = "estado";
        $valor1 = $activar;

        $item2 = "id";
        $valor2 = $id;

        $respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

        echo json_encode(['respuesta' => $respuesta]);
    }

    /*=============================================
    VALIDAR NO REPETIR USUARIO
    =============================================*/ 
    public $validarUsuario;

    public function ajaxValidarUsuario(){
        $usuario = filter_var($this->validarUsuario, FILTER_SANITIZE_STRING);
        if(empty($usuario) || !preg_match('/^[a-zA-Z0-9]+$/', $usuario)){
            echo json_encode(['error' => 'Nombre de usuario inválido']);
            return;
        }

        $item = "usuario";
        $valor = $usuario;

        $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

        echo json_encode($respuesta);
    }
}

// Instancias y llamadas seguras  
if(isset($_POST["idUsuario"])){
    $editar = new AjaxUsuarios();
    $editar->idUsuario = $_POST["idUsuario"];
    $editar->ajaxEditarUsuario();
}

if(isset($_POST["activarUsuario"]) && isset($_POST["activarId"])){
    $activarUsuario = new AjaxUsuarios();
    $activarUsuario->activarUsuario = $_POST["activarUsuario"];
    $activarUsuario->activarId = $_POST["activarId"];
    $activarUsuario->ajaxActivarUsuario();
}

if(isset($_POST["validarUsuario"])){
    $valUsuario = new AjaxUsuarios();
    $valUsuario->validarUsuario = $_POST["validarUsuario"];
    $valUsuario->ajaxValidarUsuario();
}
