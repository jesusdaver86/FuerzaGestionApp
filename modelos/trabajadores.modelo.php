<?php
// Permitir cualquier origen
header("Access-Control-Allow-Origin: *");

// Permitir métodos HTTP específicos (GET, POST, etc.)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Permitir ciertos encabezados en la solicitud
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Permitir que las credenciales (cookies, encabezados de autenticación) se incluyan en la solicitud
header("Access-Control-Allow-Credentials: true");

// Si la solicitud es de tipo OPTIONS, finaliza la ejecución del script
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Tu lógica de la API o script PHP aquí
//echo "CORS configurado correctamente.";
require_once "conexion.php";
/*require_once "modelos/trabajadores.modelo.php";
require_once "controladores/trabajadores.controlador.php";*/

// Importar la clase Conexion
use Modelos\Conexion;
class ModeloTrabajadores{

    /*=============================================
    AGREGAR TRABAJADOR
    =============================================*/
    /*=============================================
    CREAR PASAJERO
    =============================================*/

   public static function mdlAgregarTrabajadores($tabla, $datos) {
    $conexion = Conexion::conectar();

    if ($conexion) {
        $stmt = $conexion->prepare("INSERT INTO $tabla (nombre, correo, cargo, fechaNacimiento, direccion, foto, fotoDocumento,  fotoCarnet, cartaMedica, certificadoManejo, nroLicencia, fechaVencimientoCartaMedica, fechaVencimientoCertificadoManejo, fechaVencimientoLicencia) VALUES (:nombre, :correo, :cargo, :fechaNacimiento, :direccion, :foto, :fotoDocumento, :fotoCarnet, :cartaMedica,  :certificadoManejo, :nroLicencia, :fechaVencimientoCartaMedica, :fechaVencimientoCertificadoManejo, :fechaVencimientoLicencia  )");

        // Vincular parámetros a la declaración
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
        $stmt->bindParam(':cargo', $datos['cargo'], PDO::PARAM_STR);
        $stmt->bindParam(':fechaNacimiento', $datos['fechaNacimiento'], PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $datos['direccion'], PDO::PARAM_STR);
        $stmt->bindParam(':foto', $datos['foto'], PDO::PARAM_STR);
        $stmt->bindParam(':fotoDocumento', $datos['fotoDocumento'], PDO::PARAM_STR);
        $stmt->bindParam(':fotoCarnet', $datos['fotoCarnet'], PDO::PARAM_STR);
        $stmt->bindParam(':cartaMedica', $datos['cartaMedica'], PDO::PARAM_STR);
        $stmt->bindParam(':certificadoManejo', $datos['certificadoManejo'], PDO::PARAM_STR);
         $stmt->bindParam(':nroLicencia', $datos['nroLicencia'], PDO::PARAM_STR);
        $stmt->bindParam(':fechaVencimientoCartaMedica', $datos['fechaVencimientoCartaMedica'], PDO::PARAM_STR);
        $stmt->bindParam(':fechaVencimientoCertificadoManejo', $datos['fechaVencimientoCertificadoManejo'], PDO::PARAM_STR);
        $stmt->bindParam(':fechaVencimientoLicencia', $datos['fechaVencimientoLicencia'], PDO::PARAM_STR);
       


        // Ejecutar declaración
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'Error: no se pudo insertar el trabajador';
        }

        // Cerrar declaración y conexión
        $stmt->close();
        $stmt = null;
    } else {
        return 'Error: no se pudo conectar a la base de datos';
    }
}


    /*=============================================
    ACTUALIZAR TRABAJADOR
    =============================================*/

    public static function mdlActualizarTrabajador($tabla, $item1, $valor1, $item2, $valor2){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

        $stmt->bindParam(":".$item1, $valor1, PDO::PARAM_STR);
        $stmt->bindParam(":".$item2, $valor2, PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";
        
        }else{

            return "error";    

        }

        $stmt->close();

        $stmt = null;

    }

    /*=============================================
    BORRAR TRABAJADOR
    =============================================*/
/*
    public static function mdlBorrarTrabajador($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if($stmt->execute()){

            return "ok";
        
        }else{

            return "error";    

        }

        $stmt->close();

        $stmt = null;

    }
*/


/*
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idTrabajador, nombre, correo, cargo, fechaNacimiento, direccion, foto, cartaMedica, certificadoManejo) VALUES (:idTrabajador, :nombre, :correo, :cargo, :fechaNacimiento, :direccion, :foto, :cartaMedica, :certificadoManejo)");

        $stmt->bindParam(':idTrabajador', $datos['idTrabajador'], PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
        $stmt->bindParam(':cargo', $datos['cargo'], PDO::PARAM_STR);
        $stmt->bindParam(':fechaNacimiento', $datos['fechaNacimiento'], PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $datos['direccion'], PDO::PARAM_STR);
        $stmt->bindParam(':foto', $datos['foto'], PDO::PARAM_STR);
        $stmt->bindParam(':cartaMedica', $datos['cartaMedica'], PDO::PARAM_STR);
        $stmt->bindParam(':certificadoManejo', $datos['certificadoManejo'], PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";
        
        }else{

            return "error";
        
        }

        $stmt->close();

        $stmt = null;

    }*/

    /*=============================================
    CONSULTAR TRABAJADOR
    =============================================*/

    public static function mdlConsultarTrabajador($tabla, $trabajador){

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE trabajador = :trabajador");

        $stmt->bindParam(":trabajador", $trabajador, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch();

        $stmt->close();

        $stmt = null;

    }

public static function mdlMostrarTrabajadores($tabla, $item = null, $valor = null) {
    $conexion = Conexion::conectar();
    $stmt = $conexion->prepare("SELECT * FROM $tabla ORDER BY id");
    
    if ($item!= null) {
        $stmt->bindParam(":$item", $valor, PDO::PARAM_STR);
        $stmt->execute(["$item" => $valor]);
    } else {
        $stmt->execute();
    }
    
    $resultados = $stmt->fetchAll();
    $stmt->closeCursor();
    $conexion = null;
    
    return $resultados;
}

    /*=============================================
    ACTUALIZAR TRABAJADOR
    =============================================*/
/*
    public static function mdlActualizarTrabajador($tabla, $item1, $valor1, $item2, $valor2){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

        $stmt->bindParam(":".$item1, $valor1, PDO::PARAM_STR);
        $stmt->bindParam(":".$item2, $valor2, PDO::PARAM_STR);

        if($stmt->execute()){

            return "ok";
        
        }else{

            return "error";    

        }

        $stmt->close();

        $stmt = null;

    }*/

    /*=============================================
    BORRAR TRABAJADOR
    =============================================*/

    public static function mdlBorrarTrabajador($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if($stmt->execute()){

            return "ok";
        
        }else{

            return "error";    

        }

        $stmt->close();

        $stmt = null;

    }

}
