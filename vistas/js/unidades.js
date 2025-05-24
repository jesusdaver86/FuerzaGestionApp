// Configuración de DataTables

function configureDataTables() {

  $.fn.dataTable.ext.errMode = 'none';

}


// Función para manejar errores de DataTables

function handleDataTablesError(event, settings, techNote, message) {

  const errorMessage = `🚀! DataTables ha informado de un error: ${message}`;

  console.error(errorMessage);

  console.info('🚀App:init');

}


// Función para inicializar la tabla

function initTable() {

  const perfilOculto = 'perfilOculto'; // Variable descriptiva

  /*var perfilOculto = $("#perfilOculto").val();*/

  const ajaxUrl = `ajax/datatable-unidades.ajax.php?perfilOculto=${perfilOculto}`;

  

  const table = $('.tablaUnidades').DataTable({

    "ajax": ajaxUrl,

    "deferRender": true,

    "retrieve": true,

    "processing": true,

    "buttons": true,

    "buttons": [

      { "extend": "excelHtml5", "className": "green fas fa-file-excel fa-2x", "autoFilter": true, "filename": "Reporte", "title": "Datos exportados" },

      { "extend": "pdfHtml5", "className": "green fas fa-file-pdf fa-2x", "orientation": "landscape", "filename": "Reporte", "title": "Datos exportados" },

    ],

    "language": {

      "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
      "sFirst":    "Primero",
      "sLast":     "Último",
      "sNext":     "Siguiente",
      "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }

  }

} );





return table;

}


// Función para reload la tabla

function reloadTable(table) {

  setInterval(function() {

    table.ajax.reload();

  }, 10000);

}


// Inicializar configuración de DataTables

configureDataTables();


// Inicializar tabla

const table = initTable();


// Asignar evento de error a la tabla

$('.tablaUnidades').on('error.dt', handleDataTablesError);


// Reload la tabla cada 10 segundos

reloadTable(table);


$(".nuevaImagen").change(function(){

	var imagen = this.files[0];
	


  	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

  		$(".nuevaImagen").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen debe estar en formato JPG o PNG!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else if(imagen["size"] > 2000000){

  		$(".nuevaImagen").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen no debe pesar más de 2MB!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else{

  		var datosImagen = new FileReader;
  		datosImagen.readAsDataURL(imagen);

  		$(datosImagen).on("load", function(event){

  			var rutaImagen = event.target.result;

  			$(".previsualizar").attr("src", rutaImagen);

  		})

  	}
})


$(".tablaUnidades tbody").on("click", "button.btnEditarUnidad", function() {

  const idUnidad = $(this).attr("idUnidad");

  const datos = new FormData();

  datos.append("idUnidad", idUnidad);


 

  $.ajax({

    url: "ajax/unidades.ajax.php",

    method: "POST",

    data: datos,

    cache: false,

    contentType: false,

    processData: false,

    dataType: "json",

    success: function(respuesta) {


      $("#editarMarca").val(respuesta.id_marca);

      $("#editarMarca").html(respuesta.marca);


      $("#editarOperador").val(respuesta.id_operador);

      $("#editarOperador").html(respuesta.operador);


      $("#editarOrigen").val(respuesta.id_origen);

      $("#editarOrigen").html(respuesta.origen);


      $("#editarDestino").val(respuesta.id_destino);

      $("#editarDestino").html(respuesta.destino);


      $("#editarCodigo").val(respuesta.codigo);

      $("#editarkmsalida").val(respuesta.kmsalida);

      $("#editarhrsSalida").val(respuesta.hrsSalida);

      $("#editarkmllegada").val(respuesta.kmllegada);

      $("#editarhrsLlegada").val(respuesta.hrsLlegada);

      $("#editarkmRecorrido").val(respuesta.kmRecorrido);

      $("#editarcantPasajeros").val(respuesta.cantPasajeros);

      $("#editarObservacion").val(respuesta.observacion);

      $("#editarPrecioCompra").val(respuesta.precio_compra);

      $("#editarPrecioVenta").val(respuesta.precio_venta);


      if (respuesta.imagen != "") {

        $("#imagenActual").val(respuesta.imagen);

        $(".previsualizar").attr("src", respuesta.imagen);

      }

    },

  });

});




/*

 $(document).ready(function() {

            $(".tablaUnidades tbody").on("click", "button.btnEliminarUnidades", function() {

                const idUnidad = $(this).attr("idUnidad");

                const codigo = $(this).attr("codigo");

                const imagen = $(this).attr("imagen");

                swal

                    .fire({

                        title: "¿Está seguro de borrar la unidad?",

                        text: "¡Si no lo está, puede cancelar la acción!",

                        type: "warning",

                        showCancelButton: true,

                        confirmButtonColor: "#3085d6",

                        cancelButtonColor: "#d33",

                        cancelButtonText: "Cancelar",

                        confirmButtonText: "Si, borrar unidad!",

                    })

                    .then((result) => {

                        if (result.value) {

                       

                            $.ajax({

                                url: 'ajax/unidades.ajax.php',

                                type: 'POST',

                                data: {

                                    idUnidad: idUnidad,

                                    imagen: imagen,

                                    codigo: codigo

                                },

                                success: function(response) {

                                    var data = JSON.parse(response);


                                    if (data.status == 'success') {

                                        Swal.fire({

                                            icon: 'success',

                                            title: 'Éxito',

                                            text: data.message

                                        }).then(function() {

                                            window.location.reload();

                                        });

                                    } else {

                                        Swal.fire({

                                            icon: 'error',

                                            title: 'Error',

                                            text: data.message

                                        });

                                    }

                                },

                                error: function() {

                                    Swal.fire({

                                        icon: 'error',

                                        title: 'Error',

                                        text: 'Ocurrió un error al procesar la solicitud'

                                    });

                                }

                            });

                        }

                    });

            });

        });*/
/*

$(".tablaUnidades tbody").on("click", "button.btnEliminarUnidad", function() {
  const idUnidad = $(this).attr("idUnidad");

  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-success",
      cancelButton: "btn btn-danger",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "¿Estás seguro?",
      text: "¡No podrás revertir esto!",
      icon: "warning",
      confirmButtonText: "Sí, eliminar!",
      cancelButtonText: "No, cancelar!",
      showCancelButton: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        const datos = new FormData();
        datos.append("idUnidad", idUnidad);

        $.ajax({
          url: "ajax/unidades.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function(respuesta) {
            if (respuesta) {
              swalWithBootstrapButtons.fire("¡Eliminado!", "El registro ha sido eliminado.", "success");
              table.draw(); // Si estás utilizando DataTables, actualiza la tabla después de eliminar el registro
            } else {
              swalWithBootstrapButtons.fire("Error", "Hubo un error al eliminar el registro.", "error");
            }
          },
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire("Cancelado", "El registro está a salvo :)", "error");
      }
    });
});

*/



/*$(document).on("click", "button.btnEliminarUnidad", function(){*/
$(".tablaUnidades tbody").on("click", "button.btnEliminarUnidad", function() {

  var idUnidad = $(this).data("id");


  if (confirm("¿Estás seguro de eliminar esta unidad?")) {

    $.ajax({

      url: "ajax/unidades.ajax.php",

      method: "POST",

      data: { idUnidad: idUnidad },

      success: function(respuesta) {

        if (respuesta.success) {

          alert("Unidad eliminada correctamente");

          window.location.reload();

        } else {

          alert("Error al eliminar la unidad");

        }

      },

      error: function() {

        alert("Error en la solicitud AJAX");

      }

    });

  }

});












/*
const input1 = document.getElementById('nuevokmsal');

const input2 = document.getElementById('nuevokmlle');

input1.addEventListener('input', () => {
  if (input2.value) {
    const valor1 = parseInt(input1.value, 10);
    const valor2 = parseInt(input2.value, 10);
    if (valor1 > valor2) {
      input1.setCustomValidity("El valor del campo 'KM SALIDA' no puede ser mayor al valor del campo 'KM LLEGADA'");
    } else {
      input1.setCustomValidity('');
    }
  } else {
    input1.setCustomValidity('');
  }
  input1.reportValidity();
  input1.value = input1.value.replace(/[^0-9]/g, '');
});

input2.addEventListener('input', () => {
  if (input1.value) {
    const valor1 = parseInt(input1.value, 10);
    const valor2 = parseInt(input2.value, 10);
    if (valor2 < valor1) {
      input2.setCustomValidity("El valor ingresado en el campo 'KM LLEGADA' no puede ser menor o igual al valor del campo 'KM SALIDA'");
 
    } else {
      input2.setCustomValidity('');
    }
  } else {
    input2.setCustomValidity('');
  }
  input2.reportValidity();
  input2.value = input2.value.replace(/[^0-9]/g, '');
});
*/


// Make sure the elements exist before trying to access them
let input1;

let input2;
if (document.getElementById('nuevokmsal') && document.getElementById('nuevokmlle')) {
  const input1 = document.getElementById('nuevokmsal');
  const input2 = document.getElementById('nuevokmlle');

  input1.addEventListener('input', () => {
    if (input2.value) {
      const valor1 = parseInt(input1.value, 10);
      const valor2 = parseInt(input2.value, 10);
      if (valor1 > valor2) {
        input1.setCustomValidity("El valor del campo 'KM SALIDA' no puede ser mayor al valor del campo 'KM LLEGADA'");
      } else {
        input1.setCustomValidity('');
      }
    } else {
      input1.setCustomValidity('');
    }
    input1.reportValidity();
    input1.value = input1.value.replace(/[^0-9]/g, '');
  });

  input2.addEventListener('input', () => {
    if (input1.value) {
      const valor1 = parseInt(input1.value, 10);
      const valor2 = parseInt(input2.value, 10);
      if (valor2 < valor1) {
        input2.setCustomValidity("El valor ingresado en el campo 'KM LLEGADA' no puede ser menor o igual al valor del campo 'KM SALIDA'");
      } else {
        input2.setCustomValidity('');
      }
    } else {
      input2.setCustomValidity('');
    }
    input2.reportValidity();
    input2.value = input2.value.replace(/[^0-9]/g, '');
  });
} else {
  console.error('One or both of the input elements do not exist!');
}


function validarNroUnidad(inputField, alertaField) {

  const value = inputField.value.trim();

  const alerta = document.getElementById(alertaField);


  if (value === "") {

    mostrarAlerta(alerta, "El campo no puede estar vacío.");

    inputField.focus();

    inputField.value = "";

    return false;

  }


  if (/^\s+$/.test(value)) {

    mostrarAlerta(alerta, "El campo no puede consistir solo en espacios.");

    inputField.focus();

    inputField.value = "";

    return false;

  }


  ocultarAlerta(alerta);

  return true;

}

function validarCantPasajeros(inputField) {

  const value = inputField.value.trim();

  const alerta = document.getElementById("alertaCantPasajeros");


  if (value === "") {

    alerta.textContent = "El campo no puede estar vacío.";

    inputField.focus();

    inputField.value = "";

    return false;

  }


  if (/^\s+$/.test(value)) {

    alerta.textContent = "El campo no puede consistir solo en espacios.";

    inputField.focus();

    inputField.value = "";

    return false;

  }


  if (isNaN(value) || value < 0 || value > 500) {

    alerta.textContent = "Por favor, verifica la cantidad.";

    inputField.focus();

    inputField.value = "";

    return false;

  }


  alerta.textContent = "";

  return true;

}