$(document).ready(function() {
    $('#formAgregarTrabajador').on('submit', function(e) {
        e.preventDefault();

        // Validar campos de fecha

        var fechaVencimientoDocumento = $('#fechaVencimientoDocumento').val();
        var fechaVencimientoCartaMedica = $('#fechaVencimientoCartaMedica').val();
        var fechaVencimientoCertificadoManejo = $('#fechaVencimientoCertificadoManejo').val();
        var fechaVencimientoLicencia = $('#fechaVencimientoLicencia').val();

        if (!fechaVencimientoDocumento || !fechaVencimientoCartaMedica || !fechaVencimientoCertificadoManejo || !fechaVencimientoLicencia) {
            swal({
                title: "Error al registrar",
                text: "¡Por favor ingrese todas las fechas de vencimiento!",
                type: "error",
                confirmButtonText: "¡Cerrar!"
            });
        } else {
            var formData = new FormData(this);

            formData.append("fechaVencimientoDocumento", $("#fechaVencimientoDocumento").val());
            formData.append("fechaVencimientoCartaMedica", $("#fechaVencimientoCartaMedica").val());
            formData.append("fechaVencimientoCertificadoManejo", $("#fechaVencimientoCertificadoManejo").val());
            formData.append("fechaVencimientoLicencia", $("#fechaVencimientoLicencia").val());

            // Agregar las nuevas imágenes al formulario (si se han seleccionado)
            if ($("#foto")[0].files[0]) {
                formData.append("foto", $("#foto")[0].files[0]);
            }
            if ($("#fotoDocumento")[0].files[0]) {
                formData.append("fotoDocumento", $("#fotoDocumento")[0].files[0]);
            }
            if ($("#fotoCarnet")[0].files[0]) {
                formData.append("fotoCarnet", $("#fotoCarnet")[0].files[0]);
            }
            if ($("#cartaMedica")[0].files[0]) {
                formData.append("cartaMedica", $("#cartaMedica")[0].files[0]);
            }
            if ($("#certificadoManejo")[0].files[0]) {
                formData.append("certificadoManejo", $("#certificadoManejo")[0].files[0]);
            }
            if ($("#nroLicencia")[0].files[0]) {
                formData.append("nroLicencia", $("#nroLicencia")[0].files[0]);
            }

            $.ajax({
                url: 'ajax/trabajadores.ajax.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        title: "Ok",
                        text: "El usuario se ha registrado con éxito!",
                        type: "success",
                        confirmButtonText: "¡Cerrar!",
                        closeOnConfirm: true,
                        onClose: function() {
                           $('#formAgregarTrabajador')[0].reset();
                           $('#formSubirFotoTrabajador')[0].reset();
                           $('#formSubirFotoDocumento')[0].reset();
                           $('#formFotoCarnet')[0].reset();
                           $('#formSubirCartaMedic')[0].reset();
                           $('#formSubirCertificadoManejo')[0].reset();
                           $('#formSubirLicencia')[0].reset();
                            /*recargarTablaTrabajadores()*/

                            $('#modalAgregarTrabajador').modal('hide');
                        }
                    });
                },
                error: function(xhr, status, error) {
                    swal({
                        title: "Error al registrar",
                        text: "¡Por favor ingrese todas las fechas de vencimiento!",
                        type: "error",
                        confirmButtonText: "¡Cerrar!"
                    });
                }
            });
        }
    });
});






// Función para cargar los datos del trabajador a editar
function cargarDatosTrabajador(idTrabajador) {
  $.ajax({
    url: "ajax/trabajadores.ajax.php",
    method: "POST",
    data: { idTrabajador: idTrabajador },
    dataType: "json",
    success: function (respuesta) {
      // Rellenar los campos del formulario de edición con los datos del trabajador
      $("#editarNombre").val(respuesta["nombre"]);
      $("#editarCorreo").val(respuesta["correo"]);
      $("#editarCargo").val(respuesta["cargo"]);
      $("#editarFechaNacimiento").val(respuesta["fechaNacimiento"]);
      $("#editarDireccion").val(respuesta["direccion"]);
      $("#fotoActual").val(respuesta["foto"]);
      $("#cartaMedicaActual").val(respuesta["cartaMedica"]);
      $("#certificadoManejoActual").val(respuesta["certificadoManejo"]);

      // Mostrar las imágenes actuales del trabajador
      mostrarImagenPrevisualizacion("foto", respuesta["foto"]);
      mostrarImagenPrevisualizacion("cartaMedica", respuesta["cartaMedica"]);
      mostrarImagenPrevisualizacion("certificadoManejo", respuesta["certificadoManejo"]);
    }
  });
}

// Función para mostrar una imagen en el elemento de vista previa
function mostrarImagenPrevisualizacion(nombreImagen, rutaImagen) {
  if (rutaImagen != "") {
    $(`#${nombreImagen}Previsualizar`).attr("src", rutaImagen);
  } else {
    $(`#${nombreImagen}Previsualizar`).attr("src", `vistas/img/trabajadores/default/${nombreImagen}.png`);
  }
}

// Función para verificar y mostrar una vista previa de la nueva imagen
function verificarYMostrarNuevaImagen(nombreImagen, inputImagen) {
  var imagen = inputImagen.files[0];

  if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
    inputImagen.value = "";

    Swal.fire({
      title: "Error al subir la imagen",
      text: "¡La imagen debe estar en formato JPG o PNG!",
      type: "error",
      confirmButtonText: "¡Cerrar!"
    });
  } else if (imagen["size"] > 2000000) {
    inputImagen.value = "";

    Swal.fire({
      title: "Error al subir la imagen",
      text: "¡La imagen no debe pesar más de 2MB!",
      type: "error",
      confirmButtonText: "¡Cerrar!"
    });
  } else {
    var datosImagen = new FileReader;
    datosImagen.readAsDataURL(imagen);

    $(datosImagen).on("load", function (event) {
      var rutaImagen = event.target.result;

      mostrarImagenPrevisualizacion(nombreImagen, rutaImagen);
    });
  }
}

// Función para actualizar los datos del trabajador
function actualizarTrabajador() {
  var datosTrabajador = new FormData();

  // Agregar los datos del trabajador al formulario
  datosTrabajador.append("idTrabajador", $("#idTrabajador").val());
  datosTrabajador.append("nombre", $("#actualizarNombre").val());
datosTrabajador.append("correo", $("#actualizarCorreo").val());
  datosTrabajador.append("cargo", $("#actualizarCargo").val());
  datosTrabajador.append("fechaNacimiento", $("#actualizarFechaNacimiento").val());
  datosTrabajador.append("direccion", $("#actualizarDireccion").val());

  // Agregar las nuevas imágenes al formulario (si se han seleccionado)
  if ($("#nuevaFoto")[0].files[0]) {
    datosTrabajador.append("nuevaFoto", $("#nuevaFoto")[0].files[0]);
  }
  if ($("#cartaMedica")[0].files[0]) {
    datosTrabajador.append("nuevaCartaMedica", $("#cartaMedica")[0].files[0]);
  }
  if ($("#certificadoManejo")[0].files[0]) {
    datosTrabajador.append("nuevoCertificadoManejo", $("#certificadoManejo")[0].files[0]);
  }

  // Enviar la petición AJAX al servidor para actualizar los datos del trabajador
  $.ajax({
    url: "ajax/trabajadores.ajax.php",
    method: "POST",
    data: datosTrabajador,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      Swal.fire({
        title: "Trabajador actualizado",
        text: "¡El trabajador ha sido actualizado correctamente!",
        type: "success",
        confirmButtonText: "¡Cerrar!"
      }).then(function (result) {
        if (result.value) {
          window.location = "trabajadores";
        }
      });
    }
  });
}

// Eventos para los botones de edición y actualización del trabajador
$(".tablas").on("click", ".btnEditarTrabajador", function () {
  var idTrabajador = $(this).attr("data-id");

  cargarDatosTrabajador(idTrabajador);
});

$(".nuevaFoto").change(function () {
  verificarYMostrarNuevaImagen("foto", this);
});

$(".nuevaCartaMedica").change(function () {
  verificarYMostrarNuevaImagen("cartaMedica", this);
});

$(".nuevoCertificadoManejo").change(function () {
  verificarYMostrarNuevaImagen("certificadoManejo", this);
});

$(".formularioEditarTrabajador").submit(function (e) {
  e.preventDefault();

  actualizarTrabajador();
});
