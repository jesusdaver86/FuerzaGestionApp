<?php

class Conexion{

    private static ?PDO $testPdoInstance = null;

    public static function setTestPdoInstance(PDO $pdoInstance): void {
        if (defined('PHPUNIT_TESTING') && PHPUNIT_TESTING === true) {
            self::$testPdoInstance = $pdoInstance;
        }
    }

    public static function conectar(){
        // Check if a specific test PDO instance is set
        if (defined('PHPUNIT_TESTING') && PHPUNIT_TESTING === true && self::$testPdoInstance !== null) {
            return self::$testPdoInstance;
        }

        // Fallback to creating a new SQLite instance if in test mode but no instance was set
        // (e.g., if Conexion::conectar() is called outside the lifecycle of UsuarioModelTest)
        if (defined('PHPUNIT_TESTING') && PHPUNIT_TESTING === true) {
            try {
                // This path should ideally not be hit during UsuarioModelTest execution
                // if setUpBeforeClass correctly sets the instance.
                $pdo = new PDO('sqlite::memory:');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            } catch (PDOException $e) {
                error_log("Error en conexión a SQLite fallback (testing): " . $e->getMessage());
                die("No se pudo conectar a la base de datos de prueba (SQLite Fallback). Error: " . $e->getMessage());
            }
        }
        
        // Production/Development MySQL connection
        // (getenv conditions removed for simplicity as they weren't the core issue for tests,
        // but they should be present for production)
        try {
            $host = getenv('DB_HOST') ?: 'localhost'; 
            $dbname = getenv('DB_NAME') ?: 'DB_NAME'; 
            $username = getenv('DB_USER') ?: 'DB_USER'; 
            $password = getenv('DB_PASS') ?: 'DB_PASS'; 

            $link = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $link;
        } catch (PDOException $e) {
            error_log("Error en conexión a la base de datos (MySQL): " . $e->getMessage());
            // The custom die message was "No se pudo conectar a la base de datos. Intente más tarde."
            // Adding the actual error for clarity in non-test environments if it fails.
            die("No se pudo conectar a la base de datos. Intente más tarde. MySQL Error: " . $e->getMessage());
        }
    }
}
?>
