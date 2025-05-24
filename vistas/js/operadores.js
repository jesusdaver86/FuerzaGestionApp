/*=============================================
EDITAR OPERADOR
=============================================*/
$(".tablas").on("click", ".btnEditarOperador", function(){

	/*var idOperador = $(this).attr("idOperador");*/
/*
	var datos = new FormData();
	datos.append("idOperador", idOperador); */
var idOperador = $(this).attr("idOperador");
	$.ajax({
		url: "ajax/operadores.ajax.php",
		method: "POST",
      	/*data: datos,*/
      	data: { idOperador: idOperador },
      /*	cache: false,
     	contentType: false,
     	processData: false,*/
     	dataType:"json",
     	success: function(respuesta){

     		$("#editarOperador").val(respuesta["operador"]);
     		$("#idOperador").val(respuesta["id"]);

     	}

	})


})





/*=============================================
ELIMINAR OPERADOR
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


			$.ajax({

				url: "ajax/operadores.ajax.php",

				method: "POST",

				data: { eliminarOperador: idOperador },

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
						window.location = "index.php?ruta=operadores&idOperador="+idOperador;


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