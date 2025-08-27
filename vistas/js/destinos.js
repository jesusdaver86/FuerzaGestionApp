/*=============================================
EDITAR DESTINO
=============================================*/
$(".tablas").on("click", ".btnEditarDestino", function(){

	/*var idOperador = $(this).attr("idOperador");*/
/*
	var datos = new FormData();
	datos.append("idOperador", idOperador); */
var idDestino = $(this).attr("idDestino");
	$.ajax({
		url: "ajax/destinos.ajax.php",
		method: "POST",
      	/*data: datos,*/
      	data: { idDestino: idDestino },
      /*	cache: false,
     	contentType: false,
     	processData: false,*/
     	dataType:"json",
     	success: function(respuesta){

     		$("#editarDestino").val(respuesta["destino"]);
     		$("#idDestino").val(respuesta["id"]);

     	}

	})


})





/*=============================================
ELIMINAR ORIGEN
=============================================*/
/*
$(".tablas").on("click", ".btnEliminarOperador", function(){

	 var idOperador = $(this).attr("idOperador");

	 swal({
	 	title: '¿Está seguro de borrar el operador?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar operador!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = "index.php?ruta=operadores&idOperador="+idOperador;

	 	}

	 })

})

*/
$(".tablas").on("click", ".btnEliminarDestino", function(){


	var idDestino = $(this).attr("idDestino");


	swal({

		title: '¿Está seguro de borrar el destino?',

		text: "¡Si no lo está puede cancelar la acción!",

		type: 'warning',

		showCancelButton: true,

		confirmButtonColor: '#3085d6',

		cancelButtonColor: '#d33',

		cancelButtonText: 'Cancelar',

		confirmButtonText: 'Si, borrar destino!'

	}).then(function(result){


		if(result.value){


			$.ajax({

				url: "ajax/destinos.ajax.php",

				method: "POST",

				data: { eliminarDestino: idDestino },

				success: function(respuesta){


			/*		if(respuesta == "ok"){*/

/*
						swal({

							title: '¡Operador eliminado!',

							text: '¡El operador ha sido eliminado correctamente!',

							type: 'success'

						}).then(function(){


							location.reload();


						})*/
						window.location = "index.php?ruta=destinos&idDestino="+idDestino;


				/*	}else{


						swal({

							title: '¡Error!',

							text: '¡Ha ocurrido un error al eliminar el operador!',

							type: 'error'

						})


					}*/


				}


			})


		}


	})


})