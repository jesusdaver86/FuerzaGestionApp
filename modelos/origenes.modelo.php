<?php

require_once "conexion.php";
// Importar la clase Conexion
use Modelos\Conexion;

class ModeloOrigenes{

	/*=============================================
	CREAR CATEGORIA
	=============================================*/

	public function mdlIngresarOrigen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(origen) VALUES (:origen)");

		$stmt->bindParam(":origen", $datos, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR origenes
	=============================================*/

	public static function mdlMostrarOrigenes($tabla, $item, $valor){

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

	public static function mdlEditarOrigen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET origen = :origen WHERE id = :id");

		$stmt -> bindParam(":origen", $datos["origen"], PDO::PARAM_STR);
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

	public static function mdlBorrarOrigen($tabla, $datos){

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

