<?php
require_once "../controladores/pasajeros.controlador.php";
require_once "../modelos/pasajeros.modelo.php";

class AjaxPasajeros{

	/*=============================================
	EDITAR PASAJERO
	=============================================*/	

	public $idPasajero;

	public function ajaxEditarPasajero(){

		$item = "id";
		$valor = $this->idPasajero;

		$respuesta = ControladorPasajeros::ctrMostrarPasajeros($item, $valor);

		echo json_encode($respuesta);


	}

	/*=============================================
	ACTIVAR PASAJERO
	=============================================*/	



	public $activarPasajero;
	public $activarId;
	public function ajaxActivarPasajero(){


		$tabla = "pasajeros";

		$item1 = "estado";
		$valor1 = $this->activarPasajero;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloPasajeros::mdlActualizarPasajero($tabla, $item1, $valor1, $item2, $valor2);

	}

}






/*=============================================
EDITAR PASAJERO
=============================================*/	

if(isset($_POST["idPasajero"])){

	$pasajero = new AjaxPasajeros();
	$pasajero -> idPasajero = $_POST["idPasajero"];
	$pasajero -> ajaxEditarPasajero();

}

/*=============================================
ACTIVAR PASAJERO
=============================================*/	

if(isset($_POST["activarPasajero"])){

	$activarPasajero = new AjaxPasajeros();
	$activarPasajero -> activarPasajero = $_POST["activarPasajero"];
	$activarPasajero -> activarId = $_POST["activarId"];
	$activarPasajero -> ajaxActivarPasajero();

}