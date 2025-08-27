<?php


class ControladorUsuarios{

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
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }
        // Regenerar ID de sesión para evitar fijación
        session_regenerate_id(true);
    }

    public static function ctrIngresoUsuario(){
    if(isset($_POST["ingUsuario"]) && isset($_POST["ingPassword"])){
        try {
            // Sanitizar entradas (mantén tu código actual)
            $usuario = self::sanitizarEntrada($_POST["ingUsuario"]);
            $password = $_POST["ingPassword"];
            
            // Validaciones (mantén tu código actual)
            if(!preg_match('/^[a-zA-Z0-9]+$/', $usuario)){
                throw new Exception("Formato de usuario inválido");
            }

            $tabla = "usuarios";
            $item = "usuario";
            $valor = $usuario;

            $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

            if(!$respuesta){
                throw new Exception("Usuario no encontrado");
            }

            if(!isset($respuesta["password"])){
                throw new Exception("Error interno, contraseña no encontrada");
            }

            if(!password_verify($password, $respuesta["password"])){
                /*throw new Exception("Contraseña incorrecta");*/
                 throw new Exception("shake");
            }

            if($respuesta["estado"] != 1){
                throw new Exception("El usuario aún no está activado");
            }

            // Iniciar sesión segura
            self::iniciarSesionSegura();

            $_SESSION["iniciarSesion"] = "ok";
            $_SESSION["id"] = $respuesta["id"];
            $_SESSION["nombre"] = $respuesta["nombre"];
            $_SESSION["usuario"] = $respuesta["usuario"];
            $_SESSION["foto"] = $respuesta["foto"];
            $_SESSION["perfil"] = $respuesta["perfil"];

            // Actualizar último login (mantén tu código actual)
            date_default_timezone_set("Etc/GMT+4");
            $fechaActual = date('Y-m-d H:i:s');

            $item1 = "ultimo_login";
            $valor1 = $fechaActual;
            $item2 = "id";
            $valor2 = $respuesta["id"];

            $ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

            if($ultimoLogin != "ok"){
                error_log("Error al actualizar último login");
            }

            // Respuesta para AJAX o tradicional
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                // Respuesta JSON para AJAX
                echo json_encode([
                    'success' => true,
                    'message' => 'Login exitoso',
                    'redirect' => 'inicio' // Agregamos redirección en la respuesta
                ]);
            } else {
                // Redirección tradicional
                header("Location: inicio");
                exit();
            }

        } catch (Exception $e) {
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                // Error en formato JSON para AJAX
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            } else {
                // Error tradicional
                echo '<br><div class="alert alert-danger">'.htmlspecialchars($e->getMessage()).'</div>';
            }
        }
    }
}
    /*=============================================
    MÉTODO CREAR USUARIO
    =============================================*/
    public static function ctrCrearUsuario(){

        if(isset($_POST["nuevoUsuario"]) && isset($_POST["nuevoPassword"]) && isset($_POST["nuevoNombre"])){

            // Sanitizar entradas
            $nombre = self::sanitizarEntrada($_POST["nuevoNombre"]);
            $usuario = self::sanitizarEntrada($_POST["nuevoUsuario"]);
            $password = $_POST["nuevoPassword"]; // No sanitizar para que funcione password_hash

            // Validar entradas con preg_match
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nombre) &&
               preg_match('/^[a-zA-Z0-9]+$/', $usuario) &&
               preg_match('/^[a-zA-Z0-9]+$/', $password)){

                $ruta = "";

                if(isset($_FILES["nuevaFoto"]["tmp_name"]) && $_FILES["nuevaFoto"]["tmp_name"] != ""){

                    list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

                    // Restricción tamaño máximo, ejemplo 2MB
                    if($_FILES["nuevaFoto"]["size"] > 2 * 1024 * 1024){
                        echo '<script>
                            swal({
                                type: "error",
                                title: "La imagen no debe pesar más de 2MB",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            });
                        </script>';
                        return;
                    }

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    $directorio = "vistas/img/usuarios/".$usuario;

                    if(!is_dir($directorio)){
                        mkdir($directorio, 0755, true);
                    }

                    $mimeType = mime_content_type($_FILES["nuevaFoto"]["tmp_name"]);

                    if(in_array($mimeType, ["image/jpeg", "image/png"])){

                        $aleatorio = mt_rand(100,999);

                        if($mimeType == "image/jpeg"){
                            $ruta = "vistas/img/usuarios/".$usuario."/".$aleatorio.".jpg";
                            $origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);
                        }else{
                            $ruta = "vistas/img/usuarios/".$usuario."/".$aleatorio.".png";
                            $origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
                        }

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        if($mimeType == "image/jpeg"){
                            imagejpeg($destino, $ruta);
                        }else{
                            imagepng($destino, $ruta);
                        }

                    }else{
                        echo '<script>
                            swal({
                                type: "error",
                                title: "Formato de imagen no permitido. Solo JPEG y PNG.",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            });
                        </script>';
                        return;
                    }

                }

                $tabla = "usuarios";

                // Hashear contraseña con password_hash
                $encriptar = password_hash($password, PASSWORD_DEFAULT);

                $datos = array(
                    "nombre" => $nombre,
                    "usuario" => $usuario,
                    "password" => $encriptar,
                    "perfil" => self::sanitizarEntrada($_POST["nuevoPerfil"]),
                    "foto" => $ruta
                );

                $respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);

                if($respuesta == "ok"){

                    echo '<script>
                        swal({
                            type: "success",
                            title: "¡El usuario ha sido guardado correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if(result.value){
                                window.location = "usuarios";
                            }
                        });
                    </script>';

                }else{
                    echo '<script>
                        swal({
                            type: "error",
                            title: "Error al guardar el usuario. Intente más tarde.",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        });
                    </script>';
                }

            }else{
                echo '<script>
                    swal({
                        type: "error",
                        title: "¡El usuario, nombre o contraseña tienen formato inválido!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if(result.value){
                            window.location = "usuarios";
                        }
                    });
                </script>';
            }

        }

    }

    /*=============================================
    MÉTODO MOSTRAR USUARIOS
    =============================================*/
    public static function ctrMostrarUsuarios($item, $valor){

        $tabla = "usuarios";

        $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

        return $respuesta;
    }

    /*=============================================
    MÉTODO EDITAR USUARIO
    =============================================*/
    public static function ctrEditarUsuario(){

        if(isset($_POST["editarUsuario"])){

            $nombre = self::sanitizarEntrada($_POST["editarNombre"]);

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nombre)){

                $ruta = self::sanitizarEntrada($_POST["fotoActual"]);

                if(isset($_FILES["editarFoto"]["tmp_name"]) && $_FILES["editarFoto"]["tmp_name"] != ""){

                    list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

                    if($_FILES["editarFoto"]["size"] > 2 * 1024 * 1024){
                        echo '<script>
                            swal({
                                type: "error",
                                title: "La imagen no debe pesar más de 2MB",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            });
                        </script>';
                        return;
                    }

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    $directorio = "vistas/img/usuarios/".self::sanitizarEntrada($_POST["editarUsuario"]);

                    if(!is_dir($directorio)){
                        mkdir($directorio, 0755, true);
                    }

                    // Eliminar foto anterior si existe
                    if(!empty($ruta) && file_exists($ruta)){
                        unlink($ruta);
                    }

                    $mimeType = mime_content_type($_FILES["editarFoto"]["tmp_name"]);

                    if(in_array($mimeType, ["image/jpeg", "image/png"])){

                        $aleatorio = mt_rand(100,999);

                        if($mimeType == "image/jpeg"){
                            $ruta = "vistas/img/usuarios/".self::sanitizarEntrada($_POST["editarUsuario"])."/".$aleatorio.".jpg";
                            $origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);
                        }else{
                            $ruta = "vistas/img/usuarios/".self::sanitizarEntrada($_POST["editarUsuario"])."/".$aleatorio.".png";
                            $origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);
                        }

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        if($mimeType == "image/jpeg"){
                            imagejpeg($destino, $ruta);
                        }else{
                            imagepng($destino, $ruta);
                        }

                    }else{
                        echo '<script>
                            swal({
                                type: "error",
                                title: "Formato de imagen no permitido. Solo JPEG y PNG.",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            });
                        </script>';
                        return;
                    }

                }

                $tabla = "usuarios";

                // Manejo contraseña
                if(isset($_POST["editarPassword"]) && $_POST["editarPassword"] != ""){

                    $passwordNueva = $_POST["editarPassword"];

                    if(preg_match('/^[a-zA-Z0-9]+$/', $passwordNueva)){

                        // Hashear nueva contraseña
                        $encriptar = password_hash($passwordNueva, PASSWORD_DEFAULT);

                    }else{
                        echo'<script>
                            swal({
                                type: "error",
                                title: "¡La contraseña no puede ir vacía o llevar caracteres especiales!",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                            }).then(function(result) {
                                if (result.value) {
                                    window.location = "usuarios";
                                }
                            })
                        </script>';
                        return;
                    }

                }else{
                    // Mantener la contraseña actual (base de datos)
                    $encriptar = self::sanitizarEntrada($_POST["passwordActual"]);
                }

                $datos = array(
                    "nombre" => $nombre,
                    "usuario" => self::sanitizarEntrada($_POST["editarUsuario"]),
                    "password" => $encriptar,
                    "perfil" => self::sanitizarEntrada($_POST["editarPerfil"]),
                    "foto" => $ruta
                );

                $respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

                if($respuesta == "ok"){

                    echo'<script>
                        swal({
                            type: "success",
                            title: "El usuario ha sido editado correctamente",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result) {
                            if (result.value) {
                                window.location = "usuarios";
                            }
                        })
                    </script>';

                }else{
                    echo'<script>
                        swal({
                            type: "error",
                            title: "Error al editar el usuario. Intente más tarde",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        });
                    </script>';
                }
            }else{
                echo'<script>
                    swal({
                        type: "error",
                        title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result) {
                        if (result.value) {
                            window.location = "usuarios";
                        }
                    })
                </script>';
            }
        }
    }

    /*=============================================
    MÉTODO BORRAR USUARIO
    =============================================*/
    public static function ctrBorrarUsuario(){

        if(isset($_GET["idUsuario"])){

            $tabla = "usuarios";
            $datos = intval($_GET["idUsuario"]);

            if(isset($_GET["fotoUsuario"]) && !empty($_GET["fotoUsuario"])){
                if(file_exists($_GET["fotoUsuario"])){
                    unlink($_GET["fotoUsuario"]);
                }
                $usuarioFolder = 'vistas/img/usuarios/' . basename($_GET["usuario"]);
                if(is_dir($usuarioFolder)){
                    rmdir($usuarioFolder);
                }
            }

            $respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);

            if($respuesta == "ok"){

                echo'<script>
                    swal({
                        type: "success",
                        title: "El usuario ha sido borrado correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then(function(result) {
                        if (result.value) {
                            window.location = "usuarios";
                        }
                    })
                </script>';

            }else{
                echo'<script>
                    swal({
                        type: "error",
                        title: "Error al borrar el usuario. Intente más tarde.",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    });
                </script>';
            }

        }

    }



/*=============================================
MÉTODO PARA CERRAR SESIÓN
=============================================*/
public static function ctrCerrarSesion() {
    // Iniciar sesión si no está activa
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    
    // Limpiar todas las variables de sesión
    $_SESSION = [];
    
    // Eliminar cookie de sesión
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    
    // Destruir completamente la sesión
    session_destroy();
    
    return true;
}

}
?>

