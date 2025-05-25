/*=============================================
EDITAR PASAJERO
=============================================*/


$(".tablas").on("click", ".btnEditarPasajero", function(){
  var idPasajero = $(this).attr("idPasajero");
  var datos = new FormData();
  datos.append("idPasajero", idPasajero);

  $.ajax({
    url:"ajax/pasajeros.ajax.php", // This should point to the correct AJAX handler for fetching passenger details
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(respuesta){
        if(respuesta){ // Basic check if response is not null/empty
           $("#idPasajero").val(respuesta["id"]);
           // Check if #rutas exists before trying to set its value, or remove if truly unused
           if ($("#rutas").length) { // This check is good practice
             $("#rutas").val(respuesta["rutas"]);
           }
           $("#editarPasajero").val(respuesta["nombre"]);
           $("#editarDocumentoId").val(respuesta["documento"]);
           $("#editarGerencia").val(respuesta["gerencia"]);
           $("#editarNroUnidad").val(respuesta["nroUnidad"]);
           $("#editarFechaC").val(respuesta["fecha_c"]);
        } else {
            // Handle case where response is empty or indicates an issue not caught by error callback
            swal({
                title: "Atención",
                text: "No se recibieron datos para el pasajero. Puede que el pasajero no exista o haya un problema.",
                type: "warning", 
                confirmButtonText: "Cerrar"
            });
        }
    },
    error: function(jqXHR, textStatus, errorThrown){
        console.error("Error al obtener datos del pasajero: ", textStatus, errorThrown);
        swal({
            title: "Error",
            text: "No se pudo obtener la información del pasajero. Por favor, inténtelo de nuevo más tarde.",
            type: "error",
            confirmButtonText: "Cerrar"
        });
    }
  });
});

/*=============================================
ACTIVAR PASAJERO
=============================================*/

$(document).ready(function() {

    $("#formAgregarPasajero").on("submit", function(e) {

        e.preventDefault(); // Evita la recarga de la página


        var datos = $(this).serialize(); // Serializa los datos del formulario
        // Add the action for the AJAX handler in ajax/pasajeros.ajax.php
        datos += "&accion=crearPasajero"; 


        $.ajax({

            url: "ajax/pasajeros.ajax.php", 
            method: "POST",
            data: datos,
            dataType: "json", // Expect JSON response
            success: function(respuesta){ // 'respuesta' is now a JSON object
                if(respuesta.status === "success"){
                    swal({
                        type: "success",
                        title: respuesta.message, // Use message from JSON
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if (result.value) {
                            $("#modalAgregarPasajero").modal('hide');
                            $("#formAgregarPasajero")[0].reset();
                            // Reload DataTable to reflect the new entry
                            $(".tablas").DataTable().ajax.reload(null, false); 
                        }
                    });
                } else {
                    // Error reported by the server (e.g., validation, model error)
                    swal({
                        type: "error",
                        title: "Error al Guardar", // Generic title for server-side errors
                        text: respuesta.message, // Use message from JSON
                        confirmButtonText: "Cerrar"
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown){ 
                console.error("AJAX error: ", textStatus, errorThrown);
                swal({
                    type: "error",
                    title: "Error de Conexión",
                    text: "No se pudo conectar con el servidor para guardar el pasajero.",
                    confirmButtonText: "Cerrar"
                });
            }
        });
    });
});
       
$(".tablas").on("click", ".btnActivar", function(e){
  e.preventDefault(); 

  var idPasajero = $(this).attr("idPasajero");
  var estadoPasajero = $(this).attr("estadoPasajero"); // This is the TARGET state
  var button = $(this); // Store reference to the button

  var datos = new FormData();
  datos.append("activarId", idPasajero);
  datos.append("activarPasajero", estadoPasajero); // Send the TARGET state
  datos.append("accion", "activarPasajero"); // Action for the AJAX handler

  $.ajax({
    url:"ajax/pasajeros.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json", // Expect JSON from activarPasajero as well if it's refactored
    success: function(respuesta){
        // Assuming 'respuesta' from server is an object like {status: "success/error", message: "..."}
        // For now, sticking to the previous logic if respuesta isn't an object
        if (typeof respuesta === 'object' && respuesta.status) {
             if(respuesta.status === "success"){
                if(estadoPasajero == "0"){ 
                  button.removeClass('btn-success').addClass('btn-danger');
                  button.html('Desactivado');
                  button.attr('estadoPasajero', "1"); 
                }else{ 
                  button.removeClass('btn-danger').addClass('btn-success');
                  button.html('Activado');
                  button.attr('estadoPasajero', "0"); 
                }
             }
             // Display server message
             swal({
                title: respuesta.status === "success" ? "Actualizado!" : "Error!",
                text: respuesta.message,
                type: respuesta.status,
                timer: respuesta.status === "success" ? 1500 : null, 
                showConfirmButton: respuesta.status !== "success"
             });
        } else {
             // Fallback for non-JSON or unexpected response for btnActivar
            if(estadoPasajero == "0"){ 
              button.removeClass('btn-success').addClass('btn-danger');
              button.html('Desactivado');
              button.attr('estadoPasajero', "1"); 
            }else{ 
              button.removeClass('btn-danger').addClass('btn-success');
              button.html('Activado');
              button.attr('estadoPasajero', "0"); 
            }
        }

        // DataTable reload (kept outside conditional display logic for now)
        if(window.matchMedia("(max-width:767px)").matches){
           // For mobile, ensure alert is dismissable to see table
           if (!(typeof respuesta === 'object' && respuesta.status && respuesta.status === "success" && respuesta.timer)) {
             swal({ // Re-trigger swal if not auto-closing success
                title: "Actualizado!",
                text: "El estado del pasajero ha sido actualizado.",
                type: "success",
                confirmButtonText: "¡Cerrar!"
             }).then(function(result){
                if (result.value) {
                    $(".tablas").DataTable().ajax.reload(null, false);
                }
             });
           } else {
             $(".tablas").DataTable().ajax.reload(null, false);
           }
        } else {
            $(".tablas").DataTable().ajax.reload(null, false);
        }
    },
    error: function(jqXHR, textStatus, errorThrown){
        console.error("Error al activar/desactivar pasajero: ", textStatus, errorThrown);
        swal({
            title: "Error",
            text: "No se pudo actualizar el estado del pasajero. Por favor, inténtelo de nuevo.",
            type: "error",
            confirmButtonText: "Cerrar"
        });
    }
  });
});

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
            var datos = new FormData();
            datos.append("accion", "eliminarPasajero"); // New action for AJAX handler
            datos.append("idPasajero", idPasajero);

            $.ajax({
                url: "ajax/pasajeros.ajax.php", // Ensure this path is correct
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json", // Expect JSON response
                success: function(respuesta){
                    if(respuesta.status === "success"){
                        swal({
                            type: "success",
                            title: respuesta.message, // Message from server
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if (result.value) {
                                // Reload DataTable to reflect the deletion
                                $(".tablas").DataTable().ajax.reload(null, false); 
                            }
                        });
                    } else {
                        // Error reported by the server (e.g., validation, model error)
                        swal({
                            type: "error",
                            title: "Error",
                            text: respuesta.message, // Message from server
                            confirmButtonText: "Cerrar"
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    // AJAX communication error
                    console.error("AJAX error: ", textStatus, errorThrown);
                    swal({
                        type: "error",
                        title: "Error de Conexión",
                        text: "No se pudo conectar con el servidor para eliminar el pasajero.",
                        confirmButtonText: "Cerrar"
                    });
                }
            });
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
