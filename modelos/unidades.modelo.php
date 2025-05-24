	<?php

	require_once "conexion.php";

	class ModeloUnidades {

		/*=============================================
		MOSTRAR UNIDADES
		=============================================*/

	
	public static function mdlMostrarUnidades($tabla, $item = null, $valor = null, $orden = "id DESC"){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $orden");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);


			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden");

		}

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}







		/*=============================================
		REGISTRO DE UNIDAD
		=============================================*/
		public static function mdlCrearUnidad($tabla, $datos){


$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_marca, codigo, id_operador, id_origen, id_destino, kmsalida, hrsSalida, kmllegada, hrsLlegada, kmRecorrido, imagen, cantPasajeros, observacion, precio_compra, precio_venta) VALUES (:id_marca, :codigo, :id_operador, :id_origen, :id_destino, :kmsalida, :hrsSalida, :kmllegada, :hrsLlegada, :kmRecorrido, :imagen, :cantPasajeros, :observacion, :precio_compra, :precio_venta)");


$stmt->bindParam(":id_marca", $datos["id_marca"], PDO::PARAM_STR);


$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);


$stmt->bindParam(":id_operador", $datos["id_operador"], PDO::PARAM_STR);


$stmt->bindParam(":id_origen", $datos["id_origen"], PDO::PARAM_STR);


$stmt->bindParam(":id_destino", $datos["id_destino"], PDO::PARAM_STR);


$stmt->bindParam(":kmsalida", $datos["kmsalida"], PDO::PARAM_INT);


$stmt->bindParam(":hrsSalida", $datos["hrsSalida"], PDO::PARAM_INT);


$stmt->bindParam(":kmllegada", $datos["kmllegada"], PDO::PARAM_INT);


$stmt->bindParam(":hrsLlegada", $datos["hrsLlegada"], PDO::PARAM_INT);


$kmrecorrido = $datos["kmllegada"] - $datos["kmsalida"];

$stmt->bindParam(":kmRecorrido", $kmrecorrido, PDO::PARAM_INT);


$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);


$stmt->bindParam(":cantPasajeros", $datos["cantPasajeros"], PDO::PARAM_INT);


$stmt->bindParam(":observacion", $datos["observacion"], PDO::PARAM_STR);


$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);


$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);


// Elimina la siguiente línea porque no estás actualizando ninguna columna

// $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);


	

			$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

		/*=============================================
		EDITAR UNIDAD
		=============================================*/
		public static function mdlEditarUnidad($tabla, $datos){


			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_marca = :id_marca, codigo = :codigo, id_operador = :id_operador, id_origen = :id_origen, id_destino = :id_destino, kmsalida = :kmsalida, hrsSalida = :hrsSalida, kmllegada = :kmllegada, hrsLlegada = :hrsLlegada, kmRecorrido = :kmRecorrido, imagen = :imagen, cantPasajeros = :cantPasajeros, observacion = :observacion, precio_compra = :precio_compra, precio_venta = :precio_venta WHERE codigo = :codigo");


			$stmt->bindParam(":id_marca", $datos["id_marca"], PDO::PARAM_STR);

			$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);

			$stmt->bindParam(":id_operador", $datos["id_operador"], PDO::PARAM_STR);

			$stmt->bindParam(":id_origen", $datos["id_origen"], PDO::PARAM_STR);

			$stmt->bindParam(":id_destino", $datos["id_destino"], PDO::PARAM_STR);

			$stmt->bindParam(":kmsalida", $datos["kmsalida"], PDO::PARAM_INT);

			$stmt->bindParam(":hrsSalida", $datos["hrsSalida"], PDO::PARAM_INT);

			$stmt->bindParam(":kmllegada", $datos["kmllegada"], PDO::PARAM_INT);

			$stmt->bindParam(":hrsLlegada", $datos["hrsLlegada"], PDO::PARAM_INT);

			/*$stmt->bindParam(":kmRecorrido", $datos["kmRecorrido"], PDO::PARAM_INT);*/
			$kmrecorrido = $datos["kmllegada"] - $datos["kmsalida"];
						$stmt->bindParam(":kmRecorrido", $kmrecorrido, PDO::PARAM_INT);

			$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);

			$stmt->bindParam(":cantPasajeros", $datos["cantPasajeros"], PDO::PARAM_INT);

			$stmt->bindParam(":observacion", $datos["observacion"], PDO::PARAM_STR);

			$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);

			$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);

			$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		

	if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

		/*=============================================
		BORRAR UNIDAD
		=============================================*/
public static function mdlEliminarUnidad($id, $tabla){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt->bindParam(":id", $id, PDO::PARAM_INT);

	if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}







		/*=============================================
		ACTUALIZAR UNIDAD
		=============================================*/

		public static function mdlActualizarUnidad($tabla, $item1, $valor1, $valor){

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");

			$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

	if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}












/*=============================================
	RANGO FECHAS
	=============================================*/	
/*
	
	public static function mdlRangoFechasPasajeros($tabla, $fechaInicial, $fechaFinal){


    if($fechaInicial == null){


        $stmt = Conexion::conectar()->prepare("SELECT YEAR(fecha) as year, MONTH(fecha) as month, COUNT(*) as total FROM $tabla GROUP BY YEAR(fecha), MONTH(fecha) ORDER BY fecha ASC");


        $stmt -> execute();


        return $stmt -> fetchAll();	


    }else if($fechaInicial == $fechaFinal){


        $stmt = Conexion::conectar()->prepare("SELECT YEAR(fecha) as year, MONTH(fecha) as month, COUNT(*) as total FROM $tabla WHERE fecha like '%$fechaFinal%' GROUP BY YEAR(fecha), MONTH(fecha) ");


        $stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);


        $stmt -> execute();


        return $stmt -> fetchAll();


    }else{


        $fechaActual = new DateTime();

        $fechaActual ->add(new DateInterval("P1D"));

        $fechaActualMasUno = $fechaActual->format("Y-m-d");


        $fechaFinal2 = new DateTime($fechaFinal);

        $fechaFinal2 ->add(new DateInterval("P1D"));

        $fechaFinalMasUno = $fechaFinal2->format("Y-m-d");


        if($fechaFinalMasUno == $fechaActualMasUno){


            $stmt = Conexion::conectar()->prepare("SELECT YEAR(fecha) as year, MONTH(fecha) as month, COUNT(*) as total FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' GROUP BY YEAR(fecha), MONTH(fecha) ORDER BY fecha ASC");


        }else{


            $stmt = Conexion::conectar()->prepare("SELECT YEAR(fecha) as year, MONTH(fecha) as month, COUNT(*) as total FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal' GROUP BY YEAR(fecha), MONTH(fecha) ORDER BY fecha ASC");


        }


        $stmt -> execute();


        return $stmt -> fetchAll();


    }


}

*/











		/*=============================================
		MOSTRAR SUMA UNIDADES
		=============================================*/	

		public static function mdlMostrarSumaUnidades($tabla){

			$stmt = Conexion::conectar()->prepare("SELECT SUM(cantPasajeros) as total FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}


}