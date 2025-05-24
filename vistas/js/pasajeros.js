/*=============================================
EDITAR PASAJERO
=============================================*/


$(".tablas").on("click", ".btnEditarPasajero", function(){

  var idPasajero = $(this).attr("idPasajero");

  var datos = new FormData();
    datos.append("idPasajero", idPasajero);

    $.ajax({

      url:"ajax/pasajeros.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      
           $("#idPasajero").val(respuesta["id"]);
           $("#rutas").val(respuesta["rutas"]);
         $("#editarPasajero").val(respuesta["nombre"]);
         $("#editarDocumentoId").val(respuesta["documento"]);
         $("#editarGerencia").val(respuesta["gerencia"]);
         $("#editarNroUnidad").val(respuesta["nroUnidad"]);
           $("#editarFechaC").val(respuesta["fecha_c"]);
    }
    
    })
    
})



















































/*

$(".tablas").on("click", ".btnEditarPasajero", function() {

  var idPasajero = $(this).attr("idPasajero");


  var datos = new FormData();

  datos.append("idPasajero", idPasajero);


  $.ajax({

    url: "ajax/pasajeros.ajax.php",

    method: "POST",

    data: datos,

    cache: false,

    contentType: false,

    processData: false,

    dataType: "json",

    success: function(respuesta) {

      $("#idPasajero").val(respuesta.id);

      $("#rutas").val(respuesta.rutas);

      $("#editarPasajero").val(respuesta.nombre);

      $("#editarDocumentoId").val(respuesta.documento);

      $("#editarGerencia").val(respuesta.gerencia);

      $("#nuevoNroUnidad").val(respuesta.nroUnidad);

      $("#editarFechaC").val(respuesta.fecha_c);

    }

  });

});*/
  

  
  
  
/*=============================================
ACTIVAR PASAJERO
=============================================*/
/*
$(".tablas").on("click", ".btnActivar", function(){

  var idPasajero = $(this).attr("idPasajero");
  var estadoPasajero = $(this).attr("estadoPasajero");

  var datos = new FormData();
  datos.append("activarId", idPasajero);
    datos.append("activarPasajero", estadoPasajero);


    $.ajax({

    url:"ajax/pasajeros.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

          if(window.matchMedia("(max-width:767px)").matches){

             swal({
            title: "El pasajero ha sido actualizado",
            type: "success",
            confirmButtonText: "¡Cerrar!"
          }).then(function(result) {
              if (result.value) {

                window.location = "pasajeros";

              }


        });

          }

      }

    })*/







$(document).ready(function() {

    $("#formAgregarPasajero").on("submit", function(e) {

        e.preventDefault(); // Evita la recarga de la página


        var datos = $(this).serialize(); // Serializa los datos del formulario


        $.ajax({

            url: "ajax/pasajeros.ajax.php", // Cambia a la URL correcta donde procesas la creación

            method: "POST",

            data: datos,

            success: function(respuesta) {

                if (respuesta == "ok") {

                    swal({

                        type: "success",

                        title: "El pasajero ha sido guardado correctamente",

                        showConfirmButton: true,

                        confirmButtonText: "Cerrar"

                    }).then(function(result) {

                        if (result.value) {

                            // Aquí puedes cerrar el modal o limpiar el formulario

                            $("#modalAgregarPasajero").modal('hide'); // Cierra el modal

                            $("#formAgregarPasajero")[0].reset(); // Resetea el formulario

                            // Opcional: Actualiza la tabla de pasajeros

                            $(".tablas").DataTable().ajax.reload();

                        }

                    });

                } else {

                    // Manejo de errores

                    swal({

                        type: "error",

                        title: "¡El pasajero no puede ir vacío o llevar caracteres especiales!",

                        showConfirmButton: true,

                        confirmButtonText: "Cerrar"

                    });

                }

            }

        });

    });

});









































       
        $(".tablas").on("click", ".btnActivar", function(e){

  e.preventDefault(); // prevent the page from reloading


  var idPasajero = $(this).attr("idPasajero");

  var estadoPasajero = $(this).attr("estadoPasajero");


  var datos = new FormData();

  datos.append("activarId", idPasajero);

  datos.append("activarPasajero", estadoPasajero);




    $.ajax({


      url:"ajax/pasajeros.ajax.php",

      method: "POST",

      data: datos,

      cache: false,

      contentType: false,

      processData: false,

      success: function(respuesta){


          if(window.matchMedia("(max-width:767px)").matches){


             swal({

              title: "El pasajero ha sido actualizado",

              type: "success",

              confirmButtonText: "¡Cerrar!"

            }).then(function(result) {

                if (result.value) {

                  /*window.location = "pasajeros";*/
                  $(".tablas").DataTable().ajax.reload();

                }

            });


          }


      }


    });






    if(estadoPasajero == 0){

      $(this).removeClass('btn-success');
      $(this).addClass('btn-danger');
      $(this).html('Desactivado');
      $(this).attr('estadoPasajero',1);

    }else{

      $(this).addClass('btn-success');
      $(this).removeClass('btn-danger');
      $(this).html('Activado');
      $(this).attr('estadoPasajero',0);

    }

})























































  // Handle click event for btnEditarPasajero button

  /*

  $(".btnEditarPasajero").click(function(e) {

    e.preventDefault(); // prevent default behavior

    var idPasajero = $(this).attr("idPasajero");


    var datos = new FormData();

    datos.append("idPasajero", idPasajero);


    $.ajax({

      url: "ajax/pasajeros.ajax.php",

      method: "POST",

      data: datos,

      cache: false,

      contentType: false,

      processData: false,

      dataType: "json",

      success: function(respuesta) {

        $("#idPasajero").val(respuesta.id);

        $("#rutas").val(respuesta.rutas);

        $("#editarPasajero").val(respuesta.nombre);

        $("#editarDocumentoId").val(respuesta.documento);

        $("#editarGerencia").val(respuesta.gerencia);

        $("#nuevoNroUnidad").val(respuesta.nroUnidad);

        $("#editarFechaC").val(respuesta.fecha_c);

      }

    });

  });

*/






























/*



  $(".btnActivar").click(function(e) {


    var estadoUsuario = $(this).attr("estadoPasajero");


  if (estadoUsuario == 0) {

    $(this).removeClass('btn-success');

    $(this).addClass('btn-danger');

    $(this).html('Desactivado');

    $(this).attr('estadoPasajero', 1);

  } else {

    $(this).addClass('btn-success');

    $(this).removeClass('btn-danger');

    $(this).html('Activado');

    $(this).attr('estadoPasajero', 0);

  }


    e.preventDefault(); // prevent default behavior

    var idPasajero = $(this).attr("idPasajero");

    var estadoPasajero = $(this).attr("estadoPasajero");


    var datos = new FormData();

    datos.append("activarId", idPasajero);

    datos.append("activarPasajero", estadoPasajero);


    $.ajax({

      url: "ajax/pasajeros.ajax.php",

      method: "POST",

      data: datos,

      cache: false,

      contentType: false,

      processData: false,

      success: function(respuesta) {

        if (window.matchMedia("(max-width:767px)").matches) {swal({

            title: "El pasajero ha sido actualizado",

            type: "success",

            confirmButtonText: "¡Cerrar!"

          }).then(function(result) {

            if (result.value) {

              window.location = "pasajeros";

            }

          });

        }

      }

    });

  });


*/



/*
$(".btnActivar").click(function() {
   e.preventDefault();
  var estadoUsuario = $(this).attr("estadoPasajero");

  if (estadoUsuario == 0) {
    $(this).removeClass('btn-success');
    $(this).addClass('btn-danger');
    $(this).html('Desactivado');
    $(this).attr('estadoPasajero', 1);
  } else {
    $(this).addClass('btn-success');
    $(this).removeClass('btn-danger');
    $(this).html('Activado');
    $(this).attr('estadoPasajero', 0);
  }

  // Make an AJAX request to update the user's status on the server
  var idPasajero = $(this).attr("idPasajero");
  var datos = new FormData();
  datos.append("activarId", idPasajero);
  datos.append("activarPasajero", $(this).attr("estadoPasajero"));

  $.ajax({
    url: "ajax/pasajeros.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function(respuesta) {
      if (window.matchMedia("(max-width:767px)").matches) {
        swal({
          title: "El pasajero ha sido actualizado",
          type: "success",
          confirmButtonText: "¡Cerrar!"
        }).then(function(result) {
          if (result.value) {
            window.location = "pasajeros";
          }
        });
      }
    }
  });
});


*/

/*

$(".btnActivar").click(function() {

  var estadoUsuario = $(this).attr("estadoPasajero");


  if (estadoUsuario == 0) {

    $(this).removeClass('btn-success');

    $(this).addClass('btn-danger');

    $(this).html('Desactivado');

    $(this).attr('estadoPasajero', 1);

  } else {

    $(this).addClass('btn-success');

    $(this).removeClass('btn-danger');

    $(this).html('Activado');

    $(this).attr('estadoPasajero', 0);

  }




  var idPasajero = $(this).attr("idPasajero");

  var datos = new FormData();

  datos.append("activarId", idPasajero);

  datos.append("activarPasajero", $(this).attr("estadoPasajero"));


  $.ajax({

    url: "ajax/pasajeros.ajax.php",

    method: "POST",

    data: datos,

    cache: false,

    contentType: false,

    processData: false,

    success: function(respuesta) {

      if (window.matchMedia("(max-width:767px)").matches) {

        swal({

          title: "El pasajero ha sido actualizado",

          type: "success",

          confirmButtonText: "¡Cerrar!"

        }).then(function(result) {

          if (result.value) {


            $(".tablas").DataTable().ajax.reload();

          }

        });

      } else {

 

        $(".tablas").DataTable().ajax.reload();

      }

    }

  });

});*/


































/*=============================================
ELIMINAR PASAJERO
=============================================*/
$(".tablas").on("click", ".btnEliminarPasajero", function(){

  var idPasajero = $(this).attr("idPasajero");
  
  swal({
        title: '¿Está seguro de borrar el pasajero?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar pasajero!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=pasajeros&idPasajero="+idPasajero;
        }

  })

})







function validarNombre(inputField) {

  const value = inputField.value.trim();
  const alerta = document.getElementById("alertaNombre");


  if (value === "") {
   
  
    alerta.textContent = "El Nombre no puede estar vacío.";
    inputField.focus();

    inputField.value = "";

    return false;

  }


  if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(value)) {
   

    alerta.textContent = "El nombre solo puede contener letras";

    inputField.focus();

    inputField.value = "";

    return false;

  }

 alerta.textContent = "";

  return true;

}


function validarDocumentoId(inputField) {

  const value = inputField.value.trim();

  const alerta = document.getElementById("alertaDocumentoId");


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


  if (isNaN(value) || value < 3000000 || value > 40000000) {

    alerta.textContent = "Por favor, verifica la cedula.";

    inputField.focus();

    inputField.value = "";

    return false;

  }


  alerta.textContent = "";

  return true;

}

function validarGerencia(inputField, alertaField) {

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


function mostrarAlerta(alerta, mensaje) {

  alerta.textContent = mensaje;

  alerta.style.display = "block";

}


function ocultarAlerta(alerta) {

  alerta.textContent = "";

  alerta.style.display = "none";

}









$(document).ready(function() {

  // Listen for changes in the origen dropdown

  $('#nuevoOrigen').on('change', function() {

    actualizarRutaConcatenada();

  });


  // Listen for changes in the destino dropdown

  $('#nuevoDestino').on('change', function() {

    actualizarRutaConcatenada();

  });


  // Function to update the concatenated input field

  function actualizarRutaConcatenada() {

    // Get the selected values

    var origen = $('#nuevoOrigen').val();

    var destino = $('#nuevoDestino').val();


    // Concatenate the values with a hyphen

    var rutaConcatenada = origen + '-' + destino;


    // Display the concatenated value in the input field

    $('#rutas').val(rutaConcatenada);

  }

});




