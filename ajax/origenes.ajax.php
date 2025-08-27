<?php
require_once "../controladores/origenes.controlador.php";
require_once "../modelos/origenes.modelo.php";

class Ajaxorigenes{

	/*=============================================
	EDITAR ORIGEN
	=============================================*/	

	public $idOrigen;

	public function ajaxEditarOrigen(){

		$item = "id";
		$valor = $this->idOrigen;

		$respuesta = ControladorOrigenes::ctrMostrarOrigenes($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR ORIGEN
=============================================*/	
if(isset($_POST["idOrigen"])){

	$origen = new Ajaxorigenes();
	$origen -> idOrigen = $_POST["idOrigen"];
	$origen -> ajaxEditarOrigen();
}







