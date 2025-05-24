<?php
/*
class Conexion{

	public static function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=gestion_tp",
			            "root",
			            "raida2028");

		$link->exec("set names utf8");

		return $link;

	}

}
*/
class Conexion{

    public static function conectar(){

        try {
            // Configuración sensible en variables de entorno
            $host = getenv('DB_HOST') ?: 'localhost';
            $dbname = getenv('DB_NAME') ?: 'heavkfwj_gestion_tp';
            $username = getenv('DB_USER') ?: 'heavkfwj_root';
            $password = getenv('DB_PASS') ?: 'Raida2028.';

            // Conexión PDO con UTF8 y manejo adecuado de errores
            $link = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $link;

        } catch (PDOException $e) {
            error_log("Error en conexión a la base de datos: " . $e->getMessage());
            // No mostrar detalles para el usuario
            die("No se pudo conectar a la base de datos. Intente más tarde.");
        }

    }

}


