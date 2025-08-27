<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/*namespace Modelos;*/

require_once "conexion.php";
// Importar la clase Conexion
use Modelos\Conexion;

class ModeloPasajeros {

    /*=============================================
    CREAR PASAJERO
    =============================================*/
  public static function mdlIngresarPasajero($tabla, $datos) {
    // Validar la entrada del usuario
    if (empty($datos['nombre']) || empty($datos['documento']) || empty($datos['gerencia']) || empty($datos['nroUnidad']) || empty($datos['fecha_c'])) {
        return 'Error: faltan datos del pasajero';
    }

    // Prepare una declaración SQL con marcadores de posición
    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, documento, gerencia, nroUnidad, fecha_c) VALUES (:nombre, :documento, :gerencia, :nroUnidad, :fecha_c)");

    // Vincular parámetros a la declaración
    $stmt->bindParam(":nombre", $datos['nombre'], \PDO::PARAM_STR);
    $stmt->bindParam(":documento", $datos['documento'], \PDO::PARAM_INT); // Asegúrate de que sea un entero
    $stmt->bindParam(":gerencia", $datos['gerencia'], \PDO::PARAM_STR);
    $stmt->bindParam(":nroUnidad", $datos['nroUnidad'], \PDO::PARAM_STR);
    $stmt->bindParam(":fecha_c", $datos['fecha_c'], \PDO::PARAM_STR); // Asegúrate de que sea una fecha válida

    // Ejecutar declaración
    if ($stmt->execute()) {
        return 'ok';
    } else {
        return 'Error: no se pudo insertar el pasajero';
    }
}


    /*=============================================
    MOSTRAR PASAJEROS
    =============================================*/
    public static function mdlMostrarPasajeros($tabla, $item, $valor) {
        $query = "SELECT * FROM $tabla";
        if ($item !== null && $valor !== null) {
            $query .= " WHERE $item = :$item";
        }

        $stmt = Conexion::conectar()->prepare($query);
        if ($item !== null && $valor !== null) {
            $stmt->bindParam(":$item", $valor, \PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /*=============================================
    EDITAR PASAJERO
    =============================================*/
    public static function mdlEditarPasajero($tabla, $datos) {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, documento = :documento, gerencia = :gerencia, nroUnidad = :nroUnidad, fecha_c = :fecha_c WHERE id = :id");

        $stmt->bindParam(":id", $datos["id"], \PDO::PARAM_INT);
        $stmt->bindParam(":nombre", $datos["nombre"], \PDO::PARAM_STR);
        $stmt->bindParam(":documento", $datos["documento"], \PDO::PARAM_STR);
        $stmt->bindParam(":gerencia", $datos["gerencia"], \PDO::PARAM_STR);
        $stmt->bindParam(":nroUnidad", $datos["nroUnidad"], \PDO::PARAM_STR);
        $stmt->bindParam(":fecha_c", $datos["fecha_c"], \PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "Error: no se pudo editar el pasajero";
        }
    }

    /*=============================================
    ELIMINAR PASAJERO
    =============================================*/
    public static function mdlEliminarPasajero($tabla, $datos) {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt->bindParam(":id", $datos, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "Error: no se pudo eliminar el pasajero";
        }
    }

    /*=============================================
    ACTUALIZAR PASAJERO
    =============================================*/
    public static function mdlActualizarPasajero($tabla, $item1, $valor1, $item2, $valor2) {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

        $stmt->bindParam(":$item1", $valor1, \PDO::PARAM_STR);
        $stmt->bindParam(":$item2", $valor2, \PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "Error: no se pudo actualizar el pasajero";
        }
    }

    /*=============================================
    RANGO FECHAS
    =============================================*/
    public static function mdlRangoFechasPasajeros($tabla, $fechaInicial, $fechaFinal) {
        if ($fechaInicial == null) {
            $stmt = Conexion::conectar()->prepare("SELECT YEAR(fecha_c) as year, MONTH(fecha_c) as month, COUNT(*) as total FROM $tabla GROUP BY YEAR(fecha_c), MONTH(fecha_c) ORDER BY fecha_c ASC");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else if ($fechaInicial == $fechaFinal) {
            $stmt = Conexion::conectar()->prepare("SELECT YEAR(fecha_c) as year, MONTH(fecha_c) as month, COUNT(*) as total FROM $tabla WHERE fecha_c = :fecha_c GROUP BY YEAR(fecha_c), MONTH(fecha_c)");
            $stmt->bindParam(":fecha_c", $fechaFinal, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT YEAR(fecha_c) as year, MONTH(fecha_c) as month, COUNT(*) as total FROM $tabla WHERE fecha_c BETWEEN :fechaInicial AND :fechaFinal GROUP BY YEAR(fecha_c), MONTH(fecha_c) ORDER BY fecha_c ASC");
            $stmt->bindParam(":fechaInicial", $fechaInicial, \PDO::PARAM_STR);
            $stmt->bindParam(":fechaFinal", $fechaFinal, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    /*=============================================
    MOSTRAR SUMA PASAJEROS
    =============================================*/
    public static function mdlMostrarSumaPasajeros($tabla) {
        $stmt = Conexion::conectar()->prepare("SELECT SUM(cantPasajeros) as total FROM $tabla");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
