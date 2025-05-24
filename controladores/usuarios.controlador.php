<?php
// session_start(); // Removed global session_start

class ControladorUsuarios{

    private static $TABLE_NAME = "usuarios";
    private static $SESSION_KEY_LOGIN = "iniciarSesion";
    private static $SESSION_KEY_ID = "id";
    private static $SESSION_KEY_NOMBRE = "nombre";
    private static $SESSION_KEY_USUARIO = "usuario";
    private static $SESSION_KEY_FOTO = "foto";
    private static $SESSION_KEY_PERFIL = "perfil";

    /*=============================================
    MÉTODO PARA SANITIZAR ENTRADAS
    =============================================*/
    private static function sanitizarEntrada($data){
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }

    /*=============================================
    MÉTODO PARA INICIAR SESIÓN SEGURA
    =============================================*/
    private static function iniciarSesionSegura(){
        if(session_status() !== PHP_SESSION_ACTIVE){ // Check if session is not already active
            session_start();
        }
        session_regenerate_id(true); // Regenerate ID to prevent session fixation
    }

    /*=============================================
    MÉTODOS DE VALIDACIÓN PRIVADOS
    =============================================*/
    private static function _validarNombreUsuario($nombre){
        return preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nombre);
    }

    private static function _validarCredencialUsuario($credencial){
        return preg_match('/^[a-zA-Z0-9]+$/', $credencial);
    }

    /*=============================================
    MÉTODO PRIVADO PARA PROCESAR IMAGEN DE USUARIO
    =============================================*/
    private static function _procesarImagenUsuario($fileData, $usuarioNombre, $rutaFotoActual = ""){
        if (isset($fileData["tmp_name"]) && $fileData["tmp_name"] != "") {
            if ($fileData["size"] > 2 * 1024 * 1024) {
                throw new Exception("La imagen no debe pesar más de 2MB");
            }
            list($ancho, $alto) = getimagesize($fileData["tmp_name"]);
            $nuevoAncho = 500;
            $nuevoAlto = 500;
            $directorio = "vistas/img/usuarios/" . $usuarioNombre;
            if (!is_dir($directorio)) {
                if(!mkdir($directorio, 0755, true)){
                    throw new Exception("Error al crear el directorio para la imagen.");
                }
            }
            if (!empty($rutaFotoActual) && file_exists($rutaFotoActual)) {
                unlink($rutaFotoActual);
            }
            $mimeType = mime_content_type($fileData["tmp_name"]);
            if (!in_array($mimeType, ["image/jpeg", "image/png"])) {
                throw new Exception("Formato de imagen no permitido. Solo JPEG y PNG.");
            }
            $aleatorio = mt_rand(100, 999);
            $nuevaRuta = $directorio . "/" . $aleatorio . ($mimeType == "image/jpeg" ? ".jpg" : ".png");
            if ($mimeType == "image/jpeg") {
                $origen = imagecreatefromjpeg($fileData["tmp_name"]);
            } else {
                $origen = imagecreatefrompng($fileData["tmp_name"]);
            }
            if(!$origen){ throw new Exception("Error al crear la imagen desde el archivo subido."); }
            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
            if(!$destino){ throw new Exception("Error al crear el lienzo para la nueva imagen."); }
            imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
            if ($mimeType == "image/jpeg") {
                if(!imagejpeg($destino, $nuevaRuta)){ throw new Exception("Error al guardar la imagen JPEG."); }
            } else {
                if(!imagepng($destino, $nuevaRuta)){ throw new Exception("Error al guardar la imagen PNG."); }
            }
            imagedestroy($origen);
            imagedestroy($destino);
            return $nuevaRuta;
        }
        return $rutaFotoActual;
    }

    /*=============================================
    MÉTODO HELPER PARA RESPUESTAS JSON
    =============================================*/
    private static function _jsonResponse($success, $message, $data = [], $redirect = ""){
        if (headers_sent()) { 
            error_log("ControladorUsuarios::_jsonResponse - Headers already sent. Cannot set Content-Type.");
        } else {
            header('Content-Type: application/json');
        }
        
        $response = [
            'success' => (bool)$success,
            'message' => $message
        ];
        if(!empty($data)){ 
            $response['data'] = $data;
        }
        if(!empty($redirect)){ 
            $response['redirect'] = $redirect;
        }
        echo json_encode($response);
        exit();
    }

    public static function ctrIngresoUsuario(){
        if(!isset($_POST[self::SESSION_KEY_USUARIO]) || !isset($_POST["ingPassword"])){
            self::_jsonResponse(false, "Usuario y contraseña son requeridos.");
        }

        try {
            $usuario = self::sanitizarEntrada($_POST[self::SESSION_KEY_USUARIO]);
            $password = $_POST["ingPassword"]; 

            if(!self::_validarCredencialUsuario($usuario)){
                throw new Exception("Formato de usuario inválido");
            }

            $respuesta = ModeloUsuarios::mdlMostrarUsuarios(self::$TABLE_NAME, "usuario", $usuario);
            if(!$respuesta || !isset($respuesta["password"])){
                throw new Exception("Usuario o contraseña incorrectos"); 
            }

            if(!password_verify($password, $respuesta["password"])){
                throw new Exception("Usuario o contraseña incorrectos");
            }

            if($respuesta["estado"] != 1){
                throw new Exception("El usuario aún no está activado");
            }

            self::iniciarSesionSegura(); // Call before setting session variables
            $_SESSION[self::$SESSION_KEY_LOGIN] = "ok";
            $_SESSION[self::$SESSION_KEY_ID] = $respuesta[self::$SESSION_KEY_ID];
            $_SESSION[self::$SESSION_KEY_NOMBRE] = $respuesta[self::$SESSION_KEY_NOMBRE];
            $_SESSION[self::$SESSION_KEY_USUARIO] = $respuesta[self::$SESSION_KEY_USUARIO];
            $_SESSION[self::$SESSION_KEY_FOTO] = $respuesta[self::$SESSION_KEY_FOTO];
            $_SESSION[self::$SESSION_KEY_PERFIL] = $respuesta[self::$SESSION_KEY_PERFIL];

            date_default_timezone_set("Etc/GMT+4"); 
            $fechaActual = date('Y-m-d H:i:s');
            $ultimoLogin = ModeloUsuarios::mdlActualizarUsuario(
                self::$TABLE_NAME, 
                "ultimo_login", 
                $fechaActual, 
                self::$SESSION_KEY_ID, 
                $respuesta[self::$SESSION_KEY_ID]
            );

            if($ultimoLogin != "ok"){
                error_log("Error al actualizar último login para usuario ID: " . $respuesta[self::$SESSION_KEY_ID]);
            }

            self::_jsonResponse(true, "Login exitoso", ["redirect" => "inicio"]);

        } catch (Exception $e) {
            self::_jsonResponse(false, $e->getMessage());
        }
    }

    public static function ctrCrearUsuario(){
        if (empty($_POST["nuevoNombre"]) || empty($_POST["nuevoUsuario"]) || empty($_POST["nuevoPassword"]) || !isset($_POST["nuevoPerfil"])) {
            self::_jsonResponse(false, "Nombre, usuario y contraseña son requeridos. Perfil también es necesario.");
        }

        try {
            $nombre = self::sanitizarEntrada($_POST["nuevoNombre"]);
            $usuario = self::sanitizarEntrada($_POST["nuevoUsuario"]);
            $password = $_POST["nuevoPassword"]; 
            $perfil = self::sanitizarEntrada($_POST["nuevoPerfil"]);

            if (!self::_validarNombreUsuario($nombre)) {
                throw new Exception("Formato de nombre inválido.");
            }
            if (!self::_validarCredencialUsuario($usuario)) {
                throw new Exception("Formato de usuario inválido.");
            }
            if (!self::_validarCredencialUsuario($password)) {
                throw new Exception("Formato de contraseña inválido."); 
            }

            $rutaFoto = ""; 
            if (isset($_FILES["nuevaFoto"]["tmp_name"]) && $_FILES["nuevaFoto"]["tmp_name"] != "") {
                $rutaFoto = self::_procesarImagenUsuario($_FILES["nuevaFoto"], $usuario); 
            }

            $encriptar = password_hash($password, PASSWORD_DEFAULT);

            $datos = [
                "nombre" => $nombre,
                "usuario" => $usuario,
                "password" => $encriptar,
                "perfil" => $perfil,
                "foto" => $rutaFoto
            ];

            $respuesta = ModeloUsuarios::mdlIngresarUsuario(self::$TABLE_NAME, $datos);

            if ($respuesta != "ok") {
                throw new Exception("Error al guardar el usuario. Intente más tarde."); 
            }

            self::_jsonResponse(true, "¡El usuario ha sido guardado correctamente!", [], "usuarios");

        } catch (Exception $e) {
            self::_jsonResponse(false, $e->getMessage());
        }
    }

    public static function ctrMostrarUsuarios($item, $valor){
        $tabla = self::$TABLE_NAME;
        $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);
        return $respuesta;
    }

    public static function ctrEditarUsuario(){
        if (!isset($_POST["idUsuario"]) || !isset($_POST["editarNombre"]) || !isset($_POST["editarUsuario"]) || !isset($_POST["editarPerfil"]) || !isset($_POST["passwordActual"]) || !isset($_POST["fotoActual"])) {
            self::_jsonResponse(false, "Datos de usuario incompletos para la edición.");
        }

        try {
            $idUsuario = self::sanitizarEntrada($_POST["idUsuario"]);
            $nombre = self::sanitizarEntrada($_POST["editarNombre"]);
            $usuario = self::sanitizarEntrada($_POST["editarUsuario"]); 
            $perfil = self::sanitizarEntrada($_POST["editarPerfil"]);
            $passwordActual = self::sanitizarEntrada($_POST["passwordActual"]); 
            $rutaFotoActual = self::sanitizarEntrada($_POST["fotoActual"]);

            if (!self::_validarNombreUsuario($nombre)) {
                throw new Exception("¡El nombre no puede ir vacío o llevar caracteres especiales!");
            }

            $rutaFoto = $rutaFotoActual; 
            if (isset($_FILES["editarFoto"]["tmp_name"]) && $_FILES["editarFoto"]["tmp_name"] != "") {
                $rutaFoto = self::_procesarImagenUsuario($_FILES["editarFoto"], $usuario, $rutaFotoActual);
            }

            $encriptarPassword = $passwordActual; 

            if (isset($_POST["editarPassword"]) && !empty($_POST["editarPassword"])) {
                $nuevaPassword = $_POST["editarPassword"]; 
                if (!self::_validarCredencialUsuario($nuevaPassword)) {
                    throw new Exception("¡La contraseña nueva tiene formato inválido!");
                }
                $encriptarPassword = password_hash($nuevaPassword, PASSWORD_DEFAULT);
            }

            $datos = [
                "id" => $idUsuario, 
                "nombre" => $nombre,
                "usuario" => $usuario,
                "password" => $encriptarPassword,
                "perfil" => $perfil,
                "foto" => $rutaFoto
            ];

            $respuesta = ModeloUsuarios::mdlEditarUsuario(self::$TABLE_NAME, $datos);

            if ($respuesta != "ok") {
                throw new Exception("Error al editar el usuario. Intente más tarde.");
            }

            self::_jsonResponse(true, "El usuario ha sido editado correctamente", [], "usuarios");

        } catch (Exception $e) {
            self::_jsonResponse(false, $e->getMessage());
        }
    }

    public static function ctrBorrarUsuario(){
        if (!isset($_GET["idUsuario"]) || !is_numeric($_GET["idUsuario"])) {
            self::_jsonResponse(false, "ID de usuario inválido o no proporcionado.");
        }
        if (!isset($_GET["usuario"])) { 
            self::_jsonResponse(false, "Nombre de usuario no proporcionado para la eliminación de archivos.");
        }

        try {
            $idUsuario = intval($_GET["idUsuario"]);
            $fotoUsuario = isset($_GET["fotoUsuario"]) ? $_GET["fotoUsuario"] : ""; 
            $nombreUsuario = self::sanitizarEntrada($_GET["usuario"]); 

            $defaultFoto = "vistas/img/usuarios/default/anonymous.png";
            $fotoFueEliminada = false;

            if (!empty($fotoUsuario) && $fotoUsuario != $defaultFoto && file_exists($fotoUsuario)) {
                if (unlink($fotoUsuario)) {
                    $fotoFueEliminada = true;
                } else {
                    error_log("Error al eliminar archivo de foto: " . $fotoUsuario . " para usuario ID: " . $idUsuario);
                }
            }
            
            if ($fotoFueEliminada && !empty($nombreUsuario)) {
                $directorioUsuario = "vistas/img/usuarios/" . $nombreUsuario;
                if (is_dir($directorioUsuario)) {
                    $iterator = new \FilesystemIterator($directorioUsuario);
                    if (!$iterator->valid()) { 
                        if (!rmdir($directorioUsuario)) {
                            error_log("Error al eliminar directorio: " . $directorioUsuario . " para usuario ID: " . $idUsuario);
                        }
                    } else {
                         error_log("Directorio no vacío, no eliminado: " . $directorioUsuario . " para usuario ID: " . $idUsuario);
                    }
                }
            }

            $respuesta = ModeloUsuarios::mdlBorrarUsuario(self::$TABLE_NAME, $idUsuario);

            if ($respuesta != "ok") {
                throw new Exception("Error al borrar el usuario. Intente más tarde.");
            }

            self::_jsonResponse(true, "El usuario ha sido borrado correctamente", ["redirect" => "usuarios"]);

        } catch (Exception $e) {
            self::_jsonResponse(false, $e->getMessage());
        }
    }
}
?>
