<?php

namespace Modelos;

date_default_timezone_set("Etc/GMT+4");
setlocale(LC_TIME, "spanish");

class Conexion {
    private static $testPdoInstance = null;

    public static function setTestPdoInstance(\PDO $pdo) {
        self::$testPdoInstance = $pdo;
    }

    public static function conectar() {
        if (self::$testPdoInstance !== null) {
            return self::$testPdoInstance;
        }
        try {
            // Configuración sensible en variables de entorno
            $host = getenv('DB_HOST') ?: 'localhost';
            $dbname = getenv('DB_NAME') ?: 'gestion_tp';
            $username = getenv('DB_USER') ?: 'root';
            $password = getenv('DB_PASS') ?: 'raida2028';

            // Conexión PDO con UTF8 y manejo adecuado de errores
            $link = new \PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $link->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $link->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

            return $link;

        } catch (\PDOException $e) {
            error_log("Error en conexión a la base de datos: " . $e->getMessage());
            // No mostrar detalles para el usuario
            die("No se pudo conectar a la base de datos. Intente más tarde.");
        }
    }
}
