/*=============================================
EDITAR ORIGEN
=============================================*/
/*$(".tablas").on("click", ".btnEditarOrigen", function(){


var idOrigen = $(this).attr("idOrigen");
	$.ajax({
		url: "ajax/origenes.ajax.php",
		method: "POST",
   
      	data: { idOrigen: idOrigen },
 
     	dataType:"json",
     	success: function(respuesta){

     		$("#editarOrigen").val(respuesta["origen"]);
     		$("#idOrigen").val(respuesta["id"]);

     	}

	})


})
*/


$(document).ready(function(){

$(".tablas").on("click", ".btnEditarOrigen", function(){

 

 // Get the ID of the origin to edit

 var idOrigen = $(this).attr("idOrigen");

 

 // Send an AJAX request to the server to get the data for the origin

 $.ajax({

   url: "ajax/origenes.ajax.php",

   method: "POST",

   data: { idOrigen: idOrigen },

   dataType: "json",

   success: function(respuesta) {

     // Update the form fields with the new data

     $("#editarOrigen").val(respuesta["origen"]);

     $("#idOrigen").val(respuesta["id"]);

   }

 });


});
});


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
$(".tablas").on("click", ".btnEliminarOrigen", function(){


	var idOrigen = $(this).attr("idOrigen");


	swal({

		title: '¿Está seguro de borrar el origen?',

		text: "¡Si no lo está puede cancelar la acción!",

		type: 'warning',

		showCancelButton: true,

		confirmButtonColor: '#3085d6',

		cancelButtonColor: '#d33',

		cancelButtonText: 'Cancelar',

		confirmButtonText: 'Si, borrar origen!'

	}).then(function(result){


		if(result.value){


			$.ajax({

				url: "ajax/origenes.ajax.php",

				method: "POST",

				data: { eliminarOrigen: idOrigen },

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
						window.location = "index.php?ruta=origenes&idOrigen="+idOrigen;


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