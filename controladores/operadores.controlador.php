<?php

class ControladorOperadores{

	/*=============================================
	CREAR operador
	=============================================*/

	public static function ctrCrearOperador(){

		if(isset($_POST["nuevoOperador"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoOperador"])){

				$tabla = "operadores";

				$datos = $_POST["nuevoOperador"];

				$respuesta = ModeloOperadores::mdlIngresarOperador($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El operador ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "operadores";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El nombre del operador no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "operadores";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	MOSTRAR operadores
	=============================================*/

	public static function ctrMostrarOperadores($item, $valor){

		$tabla = "operadores";

		$respuesta = ModeloOperadores::mdlMostrarOperadores($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	public static function ctrEditarOperador(){

		if(isset($_POST["editarOperador"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarOperador"])){

				$tabla = "operadores";

				$datos = array("operador"=>$_POST["editarOperador"],
							   "id"=>$_POST["idOperador"]);

				$respuesta = ModeloOperadores::mdlEditarOperador($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El Operador ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "operadores";
							
									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El nombre del Operador no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "operadores";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	public static function ctrBorrarOperador(){

		if(isset($_GET["idOperador"])){

			$tabla ="operadores";
			$datos = $_GET["idOperador"];

			$respuesta = ModeloOperadores::mdlBorrarOperador($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "El operador ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "operadores";

									}
								}) 

					</script>';
			}
		}
		
	}
}
