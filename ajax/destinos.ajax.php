<?php

require_once "../controladores/destinos.controlador.php";
require_once "../modelos/destinos.modelo.php";

class Ajaxdestinos{

	/*=============================================
	EDITAR DESTINO
	=============================================*/	

	public $idDestino;

	public function ajaxEditarDestino(){

		$item = "id";
		$valor = $this->idDestino;

		$respuesta = ControladorDestinos::ctrMostrarDestinos($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR DESTINO
=============================================*/	
if(isset($_POST["idDestino"])){

	$destino = new Ajaxdestinos();
	$destino -> idDestino = $_POST["idDestino"];
	$destino -> ajaxEditarDestino();
}
