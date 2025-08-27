<?php

class ControladorOrigenes{

	/*=============================================
	CREAR origen
	=============================================*/

	public static function ctrCrearOrigen(){

		if(isset($_POST["nuevaOrigen"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaOrigen"])){

				$tabla = "origenes";

				$datos = $_POST["nuevaOrigen"];

				$respuesta = ModeloOrigenes::mdlIngresarOrigen($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El origen ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "origenes";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El origen no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "origenes";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	MOSTRAR origenes
	=============================================*/

	public static function ctrMostrarOrigenes($item, $valor){

		$tabla = "origenes";

		$respuesta = ModeloOrigenes::mdlMostrarOrigenes($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	public static function ctrEditarOrigen(){

		if(isset($_POST["editarOrigen"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarOrigen"])){

				$tabla = "origenes";

				$datos = array("origen"=>$_POST["editarOrigen"],
							   "id"=>$_POST["idOrigen"]);

				$respuesta = ModeloOrigenes::mdlEditarOrigen($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El Origen ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "origenes";
							
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

							window.location = "origenes";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	public static function ctrBorrarOrigen(){

		if(isset($_GET["idOrigen"])){

			$tabla ="origenes";
			$datos = $_GET["idOrigen"];

			$respuesta = ModeloOrigenes::mdlBorrarOrigen($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "El origen ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "origenes";

									}
								}) 

					</script>';
			}
		}
		
	}
}
