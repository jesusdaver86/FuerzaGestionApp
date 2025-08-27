<?php

require_once "conexion.php";
// Importar la clase Conexion
use Modelos\Conexion;

class ModeloDestinos{

	/*=============================================
	CREAR CATEGORIA
	=============================================*/

	public function mdlIngresarDestino($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(destino) VALUES (:destino)");

		$stmt->bindParam(":destino", $datos, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR destinos
	=============================================*/

	public static function mdlMostrarDestinos($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	public static function mdlEditarDestino($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET destino = :destino WHERE id = :id");

		$stmt -> bindParam(":destino", $datos["destino"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	public static function mdlBorrarDestino($tabla, $datos){

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

}

