<?php

require_once "conexion.php";

class ModeloUsuarios {

    /*=============================================
    MOSTRAR USUARIOS
    =============================================*/
    public static function mdlMostrarUsuarios(string $tabla, ?string $item = null, $valor = null) {
        try {
            $db = Conexion::conectar();

            if ($item !== null && $valor !== null) {
                $sql = "SELECT * FROM {$tabla} WHERE {$item} = :valor LIMIT 1";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                $stmt = null; // Liberar recursos
                return $resultado;
            } else {
                $sql = "SELECT * FROM {$tabla}";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt = null; // Liberar recursos
                return $resultado;
            }

        } catch (PDOException $e) {
            error_log('Error en mdlMostrarUsuarios: ' . $e->getMessage());
            return false;
        }
    }

    /*=============================================
    REGISTRO DE USUARIO
    =============================================*/
    public static function mdlIngresarUsuario(string $tabla, array $datos) {
        try {
            $db = Conexion::conectar();

            $sql = "INSERT INTO {$tabla} (nombre, usuario, password, perfil, foto) 
                    VALUES (:nombre, :usuario, :password, :perfil, :foto)";
            $stmt = $db->prepare($sql);

            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
            $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
            $stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
            $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

            $resultado = $stmt->execute();
            $stmt = null; // Liberar recursos

            return $resultado ? "ok" : "error";

        } catch (PDOException $e) {
            error_log('Error en mdlIngresarUsuario: ' . $e->getMessage());
            return "error";
        }
    }

    /*=============================================
    EDITAR USUARIO
    =============================================*/
    public static function mdlEditarUsuario(string $tabla, array $datos) {
        try {
            $db = Conexion::conectar();

            $sql = "UPDATE {$tabla} SET nombre = :nombre, password = :password, perfil = :perfil, foto = :foto WHERE usuario = :usuario";
            $stmt = $db->prepare($sql);

            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
            $stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
            $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
            $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

            $resultado = $stmt->execute();
            $stmt = null; // Liberar recursos

            return $resultado ? "ok" : "error";

        } catch (PDOException $e) {
            error_log('Error en mdlEditarUsuario: ' . $e->getMessage());
            return "error";
        }
    }

    /*=============================================
    ACTUALIZAR USUARIO
    =============================================*/
    public static function mdlActualizarUsuario(string $tabla, string $item1, $valor1, string $item2, $valor2) {
        try {
            $db = Conexion::conectar();

            $sql = "UPDATE {$tabla} SET {$item1} = :valor1 WHERE {$item2} = :valor2";
            $stmt = $db->prepare($sql);

            $stmt->bindParam(":valor1", $valor1, PDO::PARAM_STR);
            $stmt->bindParam(":valor2", $valor2, PDO::PARAM_STR);

            $resultado = $stmt->execute();
            $stmt = null; // Liberar recursos

            return $resultado ? "ok" : "error";

        } catch (PDOException $e) {
            error_log('Error en mdlActualizarUsuario: ' . $e->getMessage());
            return "error";
        }
    }

    /*=============================================
    BORRAR USUARIO
    =============================================*/
    public static function mdlBorrarUsuario(string $tabla, int $id) {
        try {
            $db = Conexion::conectar();

            $sql = "DELETE FROM {$tabla} WHERE id = :id";
            $stmt = $db->prepare($sql);

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            $resultado = $stmt->execute();
            $stmt = null; // Liberar recursos

            return $resultado ? "ok" : "error";

        } catch (PDOException $e) {
            error_log('Error en mdlBorrarUsuario: ' . $e->getMessage());
            return "error";
        }
    }

}

?>
