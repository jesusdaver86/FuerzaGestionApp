<?php

class Conexion {

    private static $instance;

    private $pdo;


    private function __construct() {

        $this->pdo = new PDO("mysql:host=localhost;dbname=dbname", "user", pass");

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("SET NAMES utf8");

    }


    public static function conectar() {

        if (!self::$instance) {

            self::$instance = new self();

        }

        return self::$instance->pdo;

    }

}
