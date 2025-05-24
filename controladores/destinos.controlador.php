<?php

class ControladorDestinos{

	/*=============================================
	CREAR destino
	=============================================*/

	public static function ctrCrearDestino(){

		if(isset($_POST["nuevoDestino"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoDestino"])){

				$tabla = "destinos";

				$datos = $_POST["nuevoDestino"];

				$respuesta = ModeloDestinos::mdlIngresarDestino($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El destino ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "destinos";

									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El destino no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "destinos";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	MOSTRAR destinos
	=============================================*/

	public static function ctrMostrarDestinos($item, $valor){

		$tabla = "destinos";

		$respuesta = ModeloDestinos::mdlMostrarDestinos($tabla, $item, $valor);

		return $respuesta;
	
	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	public static function ctrEditarDestino(){

		if(isset($_POST["editarDestino"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDestino"])){

				$tabla = "destinos";

				$datos = array("destino"=>$_POST["editarDestino"],
							   "id"=>$_POST["idDestino"]);

				$respuesta = ModeloDestinos::mdlEditarDestino($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El Destino ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "destinos";
							
									}
								})

					</script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El Destino no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "destinos";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	public static function ctrBorrarDestino(){

		if(isset($_GET["idDestino"])){

			$tabla ="destinos";
			$datos = $_GET["idDestino"];

			$respuesta = ModeloDestinos::mdlBorrarDestino($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "El Destino ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "destinos";

									}
								}) 

					</script>';
			}
		}
		
	}
}
