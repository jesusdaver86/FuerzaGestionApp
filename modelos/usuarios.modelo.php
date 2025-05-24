<?php

require_once "conexion.php";

/*
 SUGGESTED DATABASE INDEXES for the 'usuarios' table:
 - PRIMARY KEY on `id` (if not already set)
   Example: ALTER TABLE usuarios ADD PRIMARY KEY (id);
 - INDEX on `usuario` for faster lookups during login and username validation.
   Example: CREATE INDEX idx_usuario ON usuarios (usuario);
 - CONSIDER an INDEX on `estado` if there are frequent queries filtering by state,
   though its utility depends on query patterns and table size due to low cardinality.
   Example: CREATE INDEX idx_estado ON usuarios (estado);
*/
class ModeloUsuarios {

    /*=============================================
    MOSTRAR USUARIOS
    =============================================*/
    public static function mdlMostrarUsuarios(string $tabla, ?string $item = null, $valor = null) {
        try {
            $db = Conexion::conectar();
            $columnas = "id, nombre, usuario, password, perfil, foto, estado, ultimo_login";

            if ($item !== null && $valor !== null) {
                $sql = "SELECT {$columnas} FROM {$tabla} WHERE {$item} = :valor LIMIT 1";
                $stmt = $db->prepare($sql);

                // Determine param type based on item.
                $paramType = PDO::PARAM_STR; // Default to string
                if ($item === 'id' || $item === 'estado') { // Assuming 'id' and 'estado' are integer types
                    $paramType = PDO::PARAM_INT;
                }
                $stmt->bindParam(':valor', $valor, $paramType);
                
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                $stmt = null; // Liberar recursos
                return $resultado;
            } else {
                $sql = "SELECT {$columnas} FROM {$tabla}";
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

            // Construct the SQL query dynamically based on whether password is being updated
            $sqlSetParts = [
                "nombre = :nombre",
                "perfil = :perfil",
                "foto = :foto"
            ];
            if (isset($datos["password"]) && $datos["password"] !== null) {
                $sqlSetParts[] = "password = :password";
            }
            // The problem description implies editing by 'usuario' field in existing code,
            // but editing by 'id' is generally safer if 'usuario' (username) can be changed.
            // For this task, I will stick to the existing structure which seems to use 'usuario' as the key for WHERE.
            // If 'usuario' itself is being changed, this query needs to be handled carefully
            // (e.g. WHERE id = :id and then set the new usuario field).
            // The controller (ctrEditarUsuario) passes 'usuario' in $datos, and it also passes 'id'.
            // Let's assume the original intent was to update based on ID if available, or user if ID is not primary for WHERE.
            
            // If $datos['usuario'] is the *new* username, and $datos['id'] is the constant user ID:
            $sqlSetParts[] = "usuario = :usuario_new"; // If username can be changed

            $sqlSetString = implode(", ", $sqlSetParts);
            
            // Using 'id' from $datos for the WHERE clause, assuming 'id' is passed and is the primary key.
            $sql = "UPDATE {$tabla} SET {$sqlSetString} WHERE id = :id";
            
            $stmt = $db->prepare($sql);

            $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
            $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
            $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT); // Assuming 'id' is integer
            
            // Bind new username if it's being set
            $stmt->bindParam(":usuario_new", $datos["usuario"], PDO::PARAM_STR);


            if (isset($datos["password"]) && $datos["password"] !== null) {
                $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
            }

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
            
            // Determine param type for valor1
            $paramType1 = PDO::PARAM_STR;
            if ($item1 === 'estado' || $item1 === 'ultimo_login_is_actually_a_timestamp_but_passed_as_string') { 
                // Assuming 'estado' is integer. 'ultimo_login' is complex if it's a native DB timestamp vs string.
                // If $valor1 for 'estado' is int, use PDO::PARAM_INT
                if (is_int($valor1) || ctype_digit($valor1)) { // Basic check if it looks like an int for 'estado'
                     if($item1 === 'estado') $paramType1 = PDO::PARAM_INT;
                }
            }
            $stmt->bindParam(":valor1", $valor1, $paramType1);

            // Determine param type for valor2 (often an ID)
            $paramType2 = PDO::PARAM_STR;
            if ($item2 === 'id') {
                $paramType2 = PDO::PARAM_INT;
            }
            $stmt->bindParam(":valor2", $valor2, $paramType2);

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
