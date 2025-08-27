<?php
class Conexion{

	public static function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=gestion_tp",
			            "root",
			            "raida2028");

		$link->exec("set names utf8");

		return $link;

	}

}

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    switch ($accion) {
        case 'obtenerNombre':
            obtenerNombre();
            break;
         case 'obtenerGerencia':
            obtenerGerencia();
            break;
    }
}

function obtenerNombre()
{
    $documento = $_POST['doc'];
   

    $stmt = Conexion::conectar()->prepare("SELECT nombre FROM tblpasajeros WHERE documento = ?");
    $stmt->execute([$documento]);
    $pasajero = $stmt->fetchColumn();

    if ($pasajero) {
        echo $pasajero;
    } else {
        echo '';
    }
}
function obtenerGerencia()
{
    $documento = $_POST['doc'];
   

    $stmt = Conexion::conectar()->prepare("SELECT gerencia FROM tblpasajeros WHERE documento = ?");
    $stmt->execute([$documento]);
    $gerencia = $stmt->fetchColumn();

    if ($gerencia) {
        echo $gerencia;
    } else {
        echo '';
    }
}









?>