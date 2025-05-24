<?php

require_once "conexion.php";

class ModeloOperadores{

	/*=============================================
	CREAR OPERADOR
	=============================================*/

	public function mdlIngresarOperador($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(operador) VALUES (:operador)");

		$stmt->bindParam(":operador", $datos, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR operadores
	=============================================*/

	public static function mdlMostrarOperadores($tabla, $item, $valor){

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
	EDITAR OPERADOR
	=============================================*/

	public static function mdlEditarOperador($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET operador = :operador WHERE id = :id");

		$stmt -> bindParam(":operador", $datos["operador"], PDO::PARAM_STR);
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
	BORRAR OPERADOR
	=============================================*/

	public static function mdlBorrarOperador($tabla, $datos){

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

