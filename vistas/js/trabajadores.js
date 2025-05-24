/*function recargarTablaTrabajadores() {
    $.ajax({
        url: 'ajax/trabajadores.ajax.php',
        type: 'POST',
        data: {item: 'valor', valor: 'valor'},
        dataType: 'json',
        success: function(response) {
            // Limpiar la tabla actual
            $('tbody').html('');
            // Recorrer la respuesta y agregar filas a la tabla
            $.each(response, function(index, trabajador) {
                var fila = '<tr>';
                fila += '<td>' + (index + 1) + '</td>';
                fila += '<td>';
                if (trabajador.foto != "") {
                    fila += '<a href="' + trabajador.foto + '" data-lightbox="image-gallery">';
                    fila += '<img src="' + trabajador.foto + '" class="img-thumbnail" width="40px">';
                    fila += '</a>';
                } else {
                    fila += '<a href="vistas/img/trabajadores/default/anonymous.png" data-lightbox="image-gallery">';
                    fila += '<img src="vistas/img/trabajadores/default/anonymous.png" class="img-thumbnail" width="40px">';
                    fila += '</a>';
                }
                fila += '</td>';
                fila += '<td>' + trabajador.nombre + '</td>';
                fila += '<td>' + trabajador.cedula + '</td>';
                fila += '<td>' + trabajador.correo + '</td>';
                fila += '<td>' + trabajador.fechaNacimiento + '</td>';
                fila += '<td>' + trabajador.direccion + '</td>';
                fila += '<td>' + trabajador.cargo + '</td>';
                fila += '<td>' + trabajador.segundaLineaGerencia + '</td>';
                fila += '<td>';
                if (trabajador.fotoDocumento != "") {
                    var fechaVencimientoDocumento = trabajador.fechaVencimientoDocumento;
                    var claseDocumento = "";
                    if (new Date() > new Date(fechaVencimientoDocumento)) {
                        claseDocumento = "claseVencida";
                    } else if (new Date() > new Date(fechaVencimientoDocumento - 30)) {
                        claseDocumento = "claseProximoVencimiento";
                    }
                    fila += '<a href="' + trabajador.fotoDocumento + '" target="_blank">Ver copia de documento</a><br>';
                    fila += '<a href="#" data-toggle="modal" data-target="#modalVerDocumento" data-ruta="' + trabajador.fotoDocumento + '" data-vencimiento="' + fechaVencimientoDocumento + '"><span class="' + claseDocumento + '">' + fechaVencimientoDocumento + '</span></a><br/>';
                } else {
                    fila += '<span class="label label-danger">No disponible</span>';
                }
                fila += '</td>';
                fila += '<td>';
                if (trabajador.fotoCarnet != "") {
                    fila += '<a href="' + trabajador.fotoCarnet + '" target="_blank">Ver copia de carnet</a>';
                } else {
                    fila += '<span class="label label-danger">No disponible</span>';
                }
                fila += '</td>';
                fila += '<td>';
                if (trabajador.cartaMedica != "") {
                    var fechaVencimientoCartaMedica = trabajador.fechaVencimientoCartaMedica;
                    var claseCartaMedica = "";
                    if (new Date() > new Date(fechaVencimientoCartaMedica)) {
                        claseCartaMedica = "claseVencida";
                    } else if (new Date() > new Date(fechaVencimientoCartaMedica - 30)) {
                        claseCartaMedica = "claseProximoVencimiento";
                    }
                    fila += '<a href="' + trabajador.cartaMedica + '" target="_blank">Ver carta médica</a><br>';
                    fila += '<a href="#" data-toggle="modal" data-target="#modalVerDocumento" data-ruta="' + trabajador.cartaMedica + '" data-vencimiento="' + fechaVencimientoCartaMedica + '"><span class="' + claseCartaMedica + '">' + fechaVencimientoCartaMedica + '</span></a><br/>';
                } else {
                    fila += '<span class="label label-danger">No disponible</span>';
                }
                fila += '</td>';
                fila += '<td>';
                if (trabajador.certificadoManejo != "") {
                    var fechaVencimientoCertificadoManejo = trabajador.fechaVencimientoCertificadoManejo;
                    var claseCertificadoManejo = "";
                    if (new Date() > newDate(fechaVencimientoCertificadoManejo)) {
                        claseCertificadoManejo = "claseVencida";
                    } else if (new Date() > new Date(fechaVencimientoCertificadoManejo - 30)) {
                        claseCertificadoManejo = "claseProximoVencimiento";
                    }
                    fila += '<a href="' + trabajador.certificadoManejo + '" target="_blank">Ver certificado de manejo</a><br>';
                    fila += '<a href="#" data-toggle="modal" data-target="#modalVerDocumento" data-ruta="' + trabajador.certificadoManejo + '" data-vencimiento="' + fechaVencimientoCertificadoManejo + '"><span class="' + claseCertificadoManejo + '">' + fechaVencimientoCertificadoManejo + '</span></a><br/>';
                } else {
                    fila += '<span class="label label-danger">No disponible</span>';
                }
                fila += '</td>';
                fila += '<td>';
                var fechaVencimientoLicencia = trabajador.fechaVencimientoLicencia;
                var claseLicencia = "";
                if (new Date() > new Date(fechaVencimientoLicencia)) {
                    claseLicencia = "claseVencida";
                } else if (new Date() > new Date(fechaVencimientoLicencia - 30)) {
                    claseLicencia = "claseProximoVencimiento";
                }
                fila += '<a href="' + trabajador.nroLicencia + '" target="_blank">Ver Licencia</a><br>';
                fila += '<a href="#" data-toggle="modal" data-target="#modalVerDocumento" data-ruta="' + trabajador.nroLicencia + '" data-vencimiento="' + fechaVencimientoLicencia + '"><span class="' + claseLicencia + '">' + fechaVencimientoLicencia + '</span></a><br/>';
                fila += '</td>';
                fila += '<td>' + trabajador.tipoNomina + '</td>';
                fila += '<td>' + trabajador.created_at + '</td>';
                fila += '<td>';
                fila += '<button class="btn btn-warning btnEditarTrabajador" data-id="' + trabajador.id + '">';
                fila += '<i class="fa fa-pencil"></i>';
                fila += '</button>';
                fila += '</td>';
                fila += '<td>';
                if (trabajador.estado == 0) {
                    fila += '<button class="btn btn-success btnCambiarEstado" data-id="' + trabajador.id + '" data-estado="1">';
                    fila += '<i class="fa fa-check"></i>';
                    fila += '</button>';
                } else {
                    fila += '<button class="btn btn-danger btnCambiarEstado" data-id="' + trabajador.id + '" data-estado="0">';
                    fila += '<i class="fa fa-ban"></i>';
                    fila += '</button>';
                }
                fila += '</td>';
                fila += '</tr>';
                $('tbody').append(fila);
            });
        }
    });
}*/





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




/*
    $(document).ready(function(){
        $.ajax({
            url: 'controladores/trabajadores.controlador.php',
            type: 'GET',
            data: {action: 'ctrMostrarTrabajadoresJSON'},
            dataType: 'json',
            success: function(data) {
                $.each(data, function(index, trabajador) {
                    var fila = '<tr>';
                    fila += '<td>' + (index + 1) + '</td>';
                    fila += '<td>';
                    if (trabajador.foto != "") {
                        fila += '<a href="' + trabajador.foto + '" data-lightbox="image-gallery">';
                        fila += '<img src="' + trabajador.foto + '" class="img-thumbnail" width="40px">';
                        fila += '</a>';
                    } else {
                        fila += '<a href="vistas/img/trabajadores/default/anonymous.png" data-lightbox="image-gallery">';
                        fila += '<img src="vistas/img/trabajadores/default/anonymous.png" class="img-thumbnail" width="40px">';
                        fila += '</a>';
                    }
                    fila += '</td>';
                    fila += '<td>' + trabajador.nombre + '</td>';
                    fila += '<td>' + trabajador.cedula + '</td>';
                    fila += '<td>' + trabajador.correo + '</td>';
                    fila += '<td>' + trabajador.fechaNacimiento + '</td>';
                    fila += '<td>' + trabajador.direccion + '</td>';
                    fila += '<td>' + trabajador.cargo + '</td>';
                    fila += '<td>' + trabajador.segundaLineaGerencia + '</td>';
                    fila += '<td>';
                    if (trabajador.fotoDocumento != "") {
                        fila += '<a href="' + trabajador.fotoDocumento + '" target="_blank">Ver copia de documento</a><br>';
                        fila += '<a href="#" data-toggle="modal" data-target="#modalVerDocumento" data-ruta="' + trabajador.fotoDocumento + '" data-vencimiento="' + trabajador.fechaVencimientoDocumento + '"><span class="' + (trabajador.fechaVencimientoDocumento < date('Y-m-d') ? 'claseVencida' : (trabajador.fechaVencimientoDocumento < date('Y-m-d', strtotime('-30 days')) ? 'claseProximoVencimiento' : '')) + '">' + trabajador.fechaVencimientoDocumento + '</span></a><br/';
                    } else {
                        fila += '<span class="label label-danger">No disponible</span>';
                    }
                    fila += '</td>';
                    fila += '<td>';
                    if (trabajador.fotoCarnet!= "") {
                        fila += '<a href="' + trabajador.fotoCarnet + '" target="_blank">Ver copia de carnet</a>';
                    } else {
                        fila += '<span class="label label-danger">No disponible</span>';
                    }
                    fila += '</td>';
                    fila += '<td>';
                    if (trabajador.cartaMedica!= "") {
                        fila += '<a href="' + trabajador.cartaMedica + '" target="_blank">Ver carta médica</a><br>';
                        fila += '<a href="#" data-toggle="modal" data-target="#modalVerDocumento" data-ruta="' + trabajador.cartaMedica + '" data-vencimiento="' + trabajador.fechaVencimientoCartaMedica + '"><span class="' + (trabajador.fechaVencimientoCartaMedica < date('Y-m-d')? 'claseVencida' : (trabajador.fechaVencimientoCartaMedica < date('Y-m-d', strtotime('-30 days'))? 'claseProximoVencimiento' : '')) + '">' + trabajador.fechaVencimientoCartaMedica + '</span></a><br/. Answer in spanish.  ';
                    } else {
                        fila += '<span class="label label-danger">No disponible</span>';
                    }
                    fila += '</td>';
                    fila += '<td>';
                    if (trabajador.certificadoManejo!= "") {
                        fila += '<a href="' + trabajador.certificadoManejo + '" target="_blank">Ver certificado de manejo</a><br>';
                        fila += '<a href="#" data-toggle="modal" data-target="#modalVerDocumento" data-ruta="' + trabajador.certificadoManejo + '" data-vencimiento="' + trabajador.fechaVencimientoCertificadoManejo + '"><span class="' + (trabajador.fechaVencimientoCertificadoManejo < date('Y-m-d')? 'claseVencida' : (trabajador.fechaVencimientoCertificadoManejo < date('Y-m-d', strtotime('-30 days'))? 'claseProximoVencimiento' : '')) + '">' + trabajador.fechaVencimientoCertificadoManejo + '</span></a><br/. Answer in spanish.  ';
                    } else {
                        fila += '<span class="label label-danger">No disponible</span>';
                    }
                    fila += '</td>';
                    fila += '<td>';
                    if (trabajador.licencia!= "") {
                        fila += '<a href="' + trabajador.licencia + '" target="_blank">Ver licencia</a><br>';
                        fila += '<a href="#" data-toggle="modal" data-target="#modalVerDocumento" data-ruta="' + trabajador.licencia + '" data-vencimiento="' + trabajador.fechaVencimientoLicencia + '"><span class="' + (trabajador.fechaVencimientoLicencia < date('Y-m-d')? 'claseVencida' : (trabajador.fechaVencimientoLicencia < date('Y-m-d', strtotime('-30 days'))? 'claseProximoVencimiento' : '')) + '">' + trabajador.fechaVencimientoLicencia + '</span></a><br/. Answer in spanish.  ';
                    } else {
                        fila += '<span class="label label-danger">No disponible</span>';
                    }
                    fila += '</td>';
                    fila += '<td>' + trabajador.tipoNomina + '</td>';
                    fila += '<td>' + trabajador.created_at + '</td>';
                    fila += '<td>';
                    fila += '<button class="btn btn-warning btnEditarTrabajador" data-id="' + trabajador.id + '">';
                    fila += '<i class="fa fa-pencil"></i>';
                    fila += '</button>';
                    fila += '</td>';
                    fila += '<td>';
                    if (trabajador.estado == 0) {
                        fila += '<button class="btn btn-success btnCambiarEstado" data-id="' + trabajador.id + '" data-estado="1">';
                        fila += '<i class="fa fa-check"></i>';
                        fila += '</button>';
                    } else {
                        fila += '<button class="btn btn-danger btnCambiarEstado" data-id="' + trabajador.id + '" data-estado="0">';
                        fila += '<i class="fa fa-ban"></i>';
                        fila += '</button>';
                    }
                    fila += '</td>';
                    fila += '</tr>';
                    $('#tbody-trabajadores').append(fila);
                });
            }
        });
    });*/
/*
$('#example').DataTable({


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
*/