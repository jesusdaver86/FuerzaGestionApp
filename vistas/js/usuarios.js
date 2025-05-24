// Helper functions for showing/hiding validation errors
function mostrarError(inputElement, mensaje) {
    quitarError(inputElement); // Clear previous error first
    var formGroup = $(inputElement).closest('.form-group');
    if (formGroup.length === 0) {
        formGroup = $(inputElement).parent(); // Fallback if .form-group is not found
    }
    // Add new error message
    formGroup.append('<div class="text-danger error-message" style="font-size: 0.9em; margin-top: 5px;">' + mensaje + '</div>');
    $(inputElement).addClass('is-invalid');
}

function quitarError(inputElement) {
    var formGroup = $(inputElement).closest('.form-group');
    if (formGroup.length === 0) {
        formGroup = $(inputElement).parent();
    }
    formGroup.find('.error-message').remove();
    $(inputElement).removeClass('is-invalid');
    // Also remove any specific AJAX error message if it's styled differently (e.g. the alert for existing user)
    formGroup.find('.alert.alert-warning').remove();
}

// Validation functions
function validarNombre(nombreInput) {
    var nombre = $(nombreInput).val().trim();
    var regex = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]{3,50}$/;
    if (!regex.test(nombre)) {
        mostrarError(nombreInput, "El nombre debe tener entre 3 y 50 caracteres y solo letras (ñ, áéíóú), números o espacios.");
        return false;
    }
    quitarError(nombreInput);
    return true;
}

function validarUsuario(usuarioInput, performAjaxCheck = true) {
    var usuario = $(usuarioInput).val().trim();
    var regex = /^[a-zA-Z0-9]{5,20}$/;

    // Clear previous format error messages & AJAX specific error messages first
    quitarError(usuarioInput);

    if (!regex.test(usuario)) {
        mostrarError(usuarioInput, "El usuario debe tener entre 5 y 20 caracteres y solo letras o números.");
        return false;
    }
    // If format is OK, clear format-specific error, then proceed to AJAX if needed
    quitarError(usuarioInput); // Clears the format error message

    if (performAjaxCheck && usuario.length >= 5) {
        var esValidoPorAjax = false; // Assume invalid until AJAX confirms otherwise
        var datos = new FormData();
        datos.append("validarUsuario", usuario);

        $.ajax({
            url: "ajax/usuarios.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            async: false, // Synchronous to ensure validation completes before form submission decision
            success: function(respuesta) {
                if (respuesta) { // If true, usuario exists
                    // Use mostrarError for consistency, or a more specific message styling
                    var formGroup = $(usuarioInput).closest('.form-group');
                    if (formGroup.length === 0) formGroup = $(usuarioInput).parent();
                    formGroup.append('<div class="alert alert-warning" style="margin-top:5px; font-size:0.9em;">Este usuario ya existe en la base de datos.</div>');
                    $(usuarioInput).addClass('is-invalid');
                    esValidoPorAjax = false;
                } else {
                    // User does not exist, so it's valid from AJAX perspective
                    // Ensure no error styling/message remains from any previous state
                    quitarError(usuarioInput);
                    esValidoPorAjax = true;
                }
            },
            error: function() {
                mostrarError(usuarioInput, "Error al validar el usuario. Intente nuevamente.");
                esValidoPorAjax = false;
            }
        });
        return esValidoPorAjax;
    }
    // If not performing AJAX check (e.g., on input for format only) AND format is valid
    if (!performAjaxCheck && regex.test(usuario)) {
        return true;
    }
    // If AJAX check is not needed because length is too short, but format is OK so far
    if (regex.test(usuario) && usuario.length < 5 && performAjaxCheck) {
         // This case is tricky: format might be valid but length for AJAX not met.
         // The overall validation should fail if length is not met for AJAX.
         // The regex for format already covers the length for format.
         // This path might not be hit if regex already ensures length >= 5.
    }
    
    // Fallback if format is valid but no AJAX check was performed (and it was requested for blur)
    // This ensures that if performAjaxCheck is true, it must return from AJAX block.
    // If performAjaxCheck is false, it means it's likely an 'input' event, and only format matters.
    return regex.test(usuario);
}


function validarPassword(passwordInput) {
    var password = $(passwordInput).val();
    // Mínimo 8 caracteres, al menos una mayúscula, una minúscula, un número y un carácter especial.
    var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]).{8,}$/;
    if (!regex.test(password)) {
        mostrarError(passwordInput, "La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas, números y un carácter especial.");
        return false;
    }
    quitarError(passwordInput);
    return true;
}

function validarPerfil(perfilSelect) {
    if ($(perfilSelect).val() === "" || $(perfilSelect).val() === null) {
        mostrarError(perfilSelect, "Debe seleccionar un perfil.");
        return false;
    }
    quitarError(perfilSelect);
    return true;
}


$(document).ready(function() {

    /*=============================================
    SUBIENDO LA FOTO DEL USUARIO (Existing Code Preserved)
    =============================================*/
    $(".nuevaFoto").change(function(){
        var imagen = this.files[0];
        if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
            $(".nuevaFoto").val("");
            swal({
                title: "Error al subir la imagen",
                text: "¡La imagen debe estar en formato JPG o PNG!",
                type: "error",
                confirmButtonText: "¡Cerrar!"
            });
        } else if (imagen["size"] > 2000000){
            $(".nuevaFoto").val("");
            swal({
                title: "Error al subir la imagen",
                text: "¡La imagen no debe pesar más de 2MB!",
                type: "error",
                confirmButtonText: "¡Cerrar!"
            });
        } else {
            var datosImagen = new FileReader;
            datosImagen.readAsDataURL(imagen);
            $(datosImagen).on("load", function(event){
                var rutaImagen = event.target.result;
                $(".previsualizar").attr("src", rutaImagen);
            });
        }
    });

    // Event listeners for real-time validation in #modalAgregarUsuario
    // Using 'input' for immediate feedback, 'blur' can also be used.
    $('#modalAgregarUsuario').on('input', 'input[name="nuevoNombre"]', function() {
        validarNombre(this);
    });

    $('#modalAgregarUsuario').on('input', 'input[name="nuevoUsuario"]', function() {
        validarUsuario(this, false); // Validate format only on input
    });
    $('#modalAgregarUsuario').on('blur', 'input[name="nuevoUsuario"]', function() {
        validarUsuario(this, true); // Validate format AND perform AJAX check on blur
    });
    
    $('#modalAgregarUsuario').on('input', 'input[name="nuevoPassword"]', function() {
        validarPassword(this);
    });

    $('#modalAgregarUsuario').on('change', 'select[name="nuevoPerfil"]', function() {
        validarPerfil(this);
    });

    // Form submission validation for #modalAgregarUsuario
    $("#modalAgregarUsuario form").on("submit", function(event) {
        var esFormularioValido = true;

        if (!validarNombre($('#modalAgregarUsuario input[name="nuevoNombre"]'))) {
            esFormularioValido = false;
        }
        // For nuevoUsuario, run with AJAX check true to be absolutely sure.
        // The blur event should have already run it, but this is a final check.
        if (!validarUsuario($('#modalAgregarUsuario input[name="nuevoUsuario"]'), true)) { 
            esFormularioValido = false;
        }
        if (!validarPassword($('#modalAgregarUsuario input[name="nuevoPassword"]'))) {
            esFormularioValido = false;
        }
        if (!validarPerfil($('#modalAgregarUsuario select[name="nuevoPerfil"]'))) {
            esFormularioValido = false;
        }

        // Also check for the image, if there's specific validation required before submission
        // For example, if an image is mandatory (not covered by current rules but as an example)
        // if ($(".nuevaFoto").get(0).files.length === 0 && some_condition_image_is_mandatory) {
        //     mostrarError($(".nuevaFoto"), "Debe seleccionar una imagen.");
        //     esFormularioValido = false;
        // }


        if (!esFormularioValido) {
            event.preventDefault(); // Stop form submission
            swal({
                title: "Formulario incompleto",
                text: "Por favor, corrija los campos marcados como inválidos.",
                type: "error",
                confirmButtonText: "Entendido"
            }).then((result) => {
                // Focus the first invalid input
                var firstInvalid = $('#modalAgregarUsuario .is-invalid').first();
                if (firstInvalid.length) {
                    // Slight delay to ensure modal is not animating or interfering
                    setTimeout(function() {
                        firstInvalid.focus();
                         // If it's a select2 or custom select, .focus() might not work as expected.
                         // Additional handling might be needed for those.
                    }, 100);
                }
            });
        }
        // If esFormularioValido is true, the form will submit as usual.
    });

    /*=============================================
    EDITAR USUARIO (Existing Code Preserved)
    =============================================*/
    $(".tablas").on("click", ".btnEditarUsuario", function(){
        var idUsuario = $(this).attr("idUsuario");
        var datos = new FormData();
        datos.append("idUsuario", idUsuario);
        $.ajax({
            url:"ajax/usuarios.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                $("#editarNombre").val(respuesta["nombre"]);
                $("#editarUsuario").val(respuesta["usuario"]);
                $("#editarPerfil").html(respuesta["perfil"]);
                $("#editarPerfil").val(respuesta["perfil"]);
                $("#fotoActual").val(respuesta["foto"]);
                $("#passwordActual").val(respuesta["password"]);
                if(respuesta["foto"] != ""){
                    $(".previsualizarEditar").attr("src", respuesta["foto"]);
                } else {
                    $(".previsualizarEditar").attr("src", "vistas/img/usuarios/default/anonymous.png");
                }
            }
        });
    });

    /*=============================================
    ACTIVAR USUARIO (Existing Code Preserved)
    =============================================*/
    $(".tablas").on("click", ".btnActivar", function(){
        var idUsuario = $(this).attr("idUsuario");
        var estadoUsuario = $(this).attr("estadoUsuario");
        var datos = new FormData();
        datos.append("activarId", idUsuario);
        datos.append("activarUsuario", estadoUsuario);
        $.ajax({
            url:"ajax/usuarios.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function(respuesta){
                if(window.matchMedia("(max-width:767px)").matches){
                    swal({
                        title: "El usuario ha sido actualizado",
                        type: "success",
                        confirmButtonText: "¡Cerrar!"
                    }).then(function(result) {
                        if (result.value) {
                            window.location = "usuarios";
                        }
                    });
                }
            }
        });
        if(estadoUsuario == 0){
            $(this).removeClass('btn-success');
            $(this).addClass('btn-danger');
            $(this).html('Desactivado');
            $(this).attr('estadoUsuario',1);
        } else {
            $(this).addClass('btn-success');
            $(this).removeClass('btn-danger');
            $(this).html('Activado');
            $(this).attr('estadoUsuario',0);
        }
    });

    /*=============================================
    ELIMINAR USUARIO (Existing Code Preserved)
    =============================================*/
    $(".tablas").on("click", ".btnEliminarUsuario", function(){
      var idUsuario = $(this).attr("idUsuario");
      var fotoUsuario = $(this).attr("fotoUsuario");
      var usuario = $(this).attr("usuario");
      swal({
        title: '¿Está seguro de borrar el usuario?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar usuario!'
      }).then(function(result){
        if(result.value){
          window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&usuario="+usuario+"&fotoUsuario="+fotoUsuario;
        }
      });
    });

    // The old $("#nuevoUsuario").change(function(){...}) for AJAX validation
    // has been REMOVED as its logic is now integrated into validarUsuario()
    // and its associated event listeners ('input' and 'blur' on #modalAgregarUsuario input[name="nuevoUsuario"]).

}); // End of $(document).ready()
