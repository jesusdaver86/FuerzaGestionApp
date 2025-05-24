<?php
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxUsuarios{

    /*=============================================
    EDITAR USUARIO
    =============================================*/ 
    public $idUsuario;

    public function ajaxEditarUsuario(){
        // Validar que $idUsuario sea un número entero positivo
        $id = filter_var($this->idUsuario, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
        if($id === false){
            echo json_encode(['error' => 'ID de usuario inválido. Debe ser un entero positivo.']);
            return;
        }

        $item = "id";
        $valor = $id; // Use the validated and potentially filtered ID

        $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

        echo json_encode($respuesta);
    }

    /*=============================================
    ACTIVAR USUARIO
    =============================================*/ 
    public $activarUsuario;
    public $activarId;

    public function ajaxActivarUsuario(){
        // Validar que activarUsuario sea 0 o 1 (boolean context)
        $estadoActivacion = ($this->activarUsuario == '1') ? 1 : 0; // Correctly ensures 0 or 1

        // Validar que activarId sea un número entero positivo
        $id = filter_var($this->activarId, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
        if($id === false){
            echo json_encode(['error' => 'ID inválido para activar usuario. Debe ser un entero positivo.']);
            return;
        }

        $tabla = "usuarios"; // Should be "usuarios" as per standard table name

        $item1 = "estado";
        $valor1 = $estadoActivacion;

        $item2 = "id";
        $valor2 = $id; // Use the validated and potentially filtered ID

        // Assuming ModeloUsuarios::mdlActualizarUsuario handles database interaction
        $respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

        // The client-side JS for activation doesn't explicitly check the content of 'respuesta' from this AJAX call
        // other than it being a success. Returning 'ok' or an error status from the model is typical.
        // We'll echo what the model returns, assuming it's 'ok' on success.
        if($respuesta == "ok"){
            echo json_encode(['success' => 'Estado de usuario actualizado correctamente.']);
        } else {
            echo json_encode(['error' => 'No se pudo actualizar el estado del usuario.']);
        }
    }

    /*=============================================
    VALIDAR NO REPETIR USUARIO
    =============================================*/ 
    public $validarUsuario;

    public function ajaxValidarUsuario(){
        // Sanitize input consistent with controlador
        $usuario = htmlspecialchars(strip_tags(trim($this->validarUsuario)), ENT_QUOTES, 'UTF-8');

        // Validate format and length consistent with controlador
        if(!preg_match('/^[a-zA-Z0-9]{5,20}$/', $usuario)){
            // Error message in Spanish if format/length is incorrect
            echo json_encode(['error' => 'El nombre de usuario debe tener entre 5 y 20 caracteres y solo letras o números.']);
            return;
        }

        $item = "usuario";
        $valor = $usuario; // Use the sanitized and validated username

        $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

        // $respuesta will be the user array if found, or false if not found.
        // The client-side JS (vistas/js/usuarios.js in function validarUsuario)
        // expects a "truthy" value (user object) if user exists, "falsy" (false) otherwise.
        // So, directly echoing json_encode($respuesta) is the correct behavior for the client.
        // If an error was echoed above due to format, this part won't be reached.
        echo json_encode($respuesta);
    }
}

/*=============================================
INSTANCIAS Y LLAMADAS A MÉTODOS AJAX
=============================================*/
// It's good practice to ensure $_POST variables are set before using them.

if(isset($_POST["idUsuario"])){
    $editar = new AjaxUsuarios();
    // Assigning directly from $_POST. Sanitization/validation happens within the method.
    $editar->idUsuario = $_POST["idUsuario"]; 
    $editar->ajaxEditarUsuario();
}

if(isset($_POST["activarUsuario"]) && isset($_POST["activarId"])){
    $activar = new AjaxUsuarios(); // Renamed variable for clarity
    $activar->activarUsuario = $_POST["activarUsuario"];
    $activar->activarId = $_POST["activarId"];
    $activar->ajaxActivarUsuario();
}

if(isset($_POST["validarUsuario"])){
    $valUsuario = new AjaxUsuarios();
    $valUsuario->validarUsuario = $_POST["validarUsuario"];
    $valUsuario->ajaxValidarUsuario();
}
?>
