<?php
require_once "../controladores/operadores.controlador.php";
require_once "../modelos/operadores.modelo.php";

class Ajaxoperadores{

	/*=============================================
	EDITAR OPERADOR
	=============================================*/	

	public $idOperador;

	public function ajaxEditarOperador(){

		$item = "id";
		$valor = $this->idOperador;

		$respuesta = ControladorOperadores::ctrMostrarOperadores($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR OPERADOR
=============================================*/	
if(isset($_POST["idOperador"])){

	$operador = new Ajaxoperadores();
	$operador -> idOperador = $_POST["idOperador"];
	$operador -> ajaxEditarOperador();
}
