<?php

require_once "conexion.php";

class ModeloPasajeros{

    /*=============================================
    CREAR PASAJERO
    =============================================*/

    public static function mdlIngresarPasajero($tabla,$datos){

    // Validar la entrada del usuario

    if (!isset($datos['nombre']) || !isset($datos['documento']) || !isset($datos['gerencia']) || !isset($datos['nroUnidad']) || !isset($datos['fecha_c'])) {

        return 'Error: faltan datos del pasajero';

    }

     if (

        empty($datos["nombre"]) || trim($datos["nombre"]) == "" ||

        empty($datos["documento"]) || !is_numeric($datos["documento"]) ||

        empty($datos["gerencia"]) || trim($datos["gerencia"]) == "" ||

        empty($datos["nroUnidad"]) || trim($datos["nroUnidad"]) == "" ||

        empty($datos["fecha_c"]) || trim($datos["fecha_c"]) == "") {


        return "error";

    }

    // Prepare una declaración SQL con marcadores de posición

    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla ( nombre, documento, gerencia, nroUnidad, fecha_c) VALUES (:nombre, :documento, :gerencia, :nroUnidad, :fecha_c)");


    // Vincular parámetros a la declaración
    

    $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);

    $stmt->bindParam(":documento", $datos['documento'], PDO::PARAM_INT);

    $stmt->bindParam(":gerencia", $datos['gerencia'], PDO::PARAM_STR);

    $stmt->bindParam(":nroUnidad", $datos['nroUnidad'], PDO::PARAM_STR);

    $stmt->bindParam(":fecha_c", $datos['fecha_c'], PDO::PARAM_STR);


    // Ejecutar declaración

    if ($stmt->execute()) {

        return 'ok';

    } else {

        return 'Error: no se pudo insertar el pasajero';

    }


    // Cerrar declaración y conexión

    $stmt->close();

    $stmt = null;

}

    /*=============================================
    MOSTRAR PASAJEROS
    =============================================*/

    public static function mdlMostrarPasajeros($tabla, $item, $valor) {
        $allowed_columns = ['id', 'nombre', 'documento', 'gerencia', 'nroUnidad', 'estado'];

        if ($item != null) {
            if (!in_array($item, $allowed_columns)) {
                // Consider logging this attempt or returning a more specific error/empty result
                return false; 
            }
            // Use the whitelisted $item directly in the placeholder name for clarity
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /*=============================================
    EDITAR PASAJERO
    =============================================*/

    public static function mdlEditarPasajero($tabla, $datos){


    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, documento = :documento, gerencia = :gerencia, nroUnidad = :nroUnidad, fecha_c = :fecha_c WHERE id = :id");


    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

    

    $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);

    $stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_INT);

    $stmt->bindParam(":gerencia", $datos["gerencia"], PDO::PARAM_STR);

    $stmt->bindParam(":nroUnidad", $datos["nroUnidad"], PDO::PARAM_STR); // Add this line

    $stmt->bindParam(":fecha_c", $datos["fecha_c"], PDO::PARAM_STR);


    if($stmt->execute()){


        return "ok";


    }else{


        return "error";

    

    }


    $stmt->close();

    $stmt = null;


}

    /*=============================================
    ELIMINAR PASAJERO
    =============================================*/

    public static function mdlEliminarPasajero($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

        $stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

        if($stmt -> execute()){

            return "ok";
        
        }else{

            return "error"; 

        }

        $stmt -> close();

        $stmt = null;

    }

    /*=============================================
    ACTUALIZAR PASAJERO
    =============================================*/

    public static function mdlActualizarPasajero($tabla, $item1, $valor1, $item2, $valor2){
        $allowed_columns_update = ['nombre', 'documento', 'gerencia', 'nroUnidad', 'fecha_c', 'estado'];
        $allowed_columns_where = ['id', 'documento'];

        if (!in_array($item1, $allowed_columns_update) || !in_array($item2, $allowed_columns_where)) {
            return "error";
        }

        $sql = "UPDATE $tabla SET $item1 = :val1 WHERE $item2 = :val2";
        $stmt = Conexion::conectar()->prepare($sql);

        // Determine param type for val1
        $param_type_val1 = PDO::PARAM_STR;
        if ($item1 == 'documento') { // Assuming 'documento' should be int, adjust if not
            $param_type_val1 = PDO::PARAM_INT;
        }
        $stmt->bindParam(":val1", $valor1, $param_type_val1);

        // Determine param type for val2
        $param_type_val2 = PDO::PARAM_STR;
        if ($item2 == 'id' || $item2 == 'documento') {
            $param_type_val2 = PDO::PARAM_INT;
        }
        $stmt->bindParam(":val2", $valor2, $param_type_val2);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error"; 
        }
    }















/*=============================================
    RANGO FECHAS
    =============================================*/ 

    public static function mdlRangoFechasPasajeros($tabla, $fechaInicial, $fechaFinal){
        if($fechaInicial == null){
            $stmt = Conexion::conectar()->prepare("SELECT YEAR(fecha_c) as year, MONTH(fecha_c) as month, COUNT(*) as total FROM $tabla GROUP BY YEAR(fecha_c), MONTH(fecha_c) ORDER BY fecha_c ASC");
            $stmt->execute();
            return $stmt->fetchAll(); 
        } else if($fechaInicial == $fechaFinal){
            $stmt = Conexion::conectar()->prepare("SELECT YEAR(fecha_c) as year, MONTH(fecha_c) as month, COUNT(*) as total FROM $tabla WHERE fecha_c LIKE :fecha_like GROUP BY YEAR(fecha_c), MONTH(fecha_c)");
            $fecha_like_param = "%".$fechaFinal."%";
            $stmt->bindParam(":fecha_like", $fecha_like_param, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            $fechaActual = new DateTime();
            $fechaActual->add(new DateInterval("P1D"));
            $fechaActualMasUno = $fechaActual->format("Y-m-d");

            $fechaFinal2 = new DateTime($fechaFinal);
            $fechaFinal2->add(new DateInterval("P1D"));
            $fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

            if($fechaFinalMasUno == $fechaActualMasUno){
                $stmt = Conexion::conectar()->prepare("SELECT YEAR(fecha_c) as year, MONTH(fecha_c) as month, COUNT(*) as total FROM $tabla WHERE fecha_c BETWEEN :fechaInicial AND :fechaFinalMasUno GROUP BY YEAR(fecha_c), MONTH(fecha_c) ORDER BY fecha_c ASC");
                $stmt->bindParam(":fechaInicial", $fechaInicial, PDO::PARAM_STR);
                $stmt->bindParam(":fechaFinalMasUno", $fechaFinalMasUno, PDO::PARAM_STR);
            } else {
                $stmt = Conexion::conectar()->prepare("SELECT YEAR(fecha_c) as year, MONTH(fecha_c) as month, COUNT(*) as total FROM $tabla WHERE fecha_c BETWEEN :fechaInicial AND :fechaFinal GROUP BY YEAR(fecha_c), MONTH(fecha_c) ORDER BY fecha_c ASC");
                $stmt->bindParam(":fechaInicial", $fechaInicial, PDO::PARAM_STR);
                $stmt->bindParam(":fechaFinal", $fechaFinal, PDO::PARAM_STR);
            }
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }

    /*=============================================
    MOSTRAR SUMA PASAJEROS
    =============================================*/ 

    public static function mdlMostrarSumaPasajeros($tabla){
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as total FROM $tabla");
        $stmt->execute();
        return $stmt->fetchColumn(); // Returns the value of the first column
    }






}
