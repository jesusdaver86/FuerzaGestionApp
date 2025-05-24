
<style type="text/css">
/* Efecto shake mejorado */
@keyframes shake {
  0%, 100% { transform: translateX(0); }
  10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
  20%, 40%, 60%, 80% { transform: translateX(10px); }
}

/* Estilo del botón mejorado */
#login-btn {
  background-color: #1DA1F2; /* Azul Twitter */
  border: none;
  border-radius: 25px;
  padding: 10px 25px; /* Más padding horizontal */
  font-weight: bold;
  font-size: 16px; /* Tamaño de letra más grande */
  color: white;
  text-transform: none; /* Quitamos mayúsculas */
  letter-spacing: normal;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
  transition: all 0.3s ease;
  width: auto; /* Ancho automático según contenido */
  min-width: 180px; /* Ancho mínimo */
  display: inline-block; /* Para que no ocupe todo el ancho */
  margin: 10px auto !important; /* Margen vertical y centrado */
}

#login-btn:hover {
  background-color: #1991db;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

#login-btn:active {
  transform: translateY(0);
}

#login-btn.shake {
  animation: shake 0.6s cubic-bezier(.36,.07,.19,.97) both;
  background-color: #ff4444;
  position: relative;
}


/* Reset para permitir repetir la animación */
#login-btn {
    animation: none;
}

/* Asegurar que el contenedor del botón esté centrado */
.text-center {
  text-align: center;
}
  </style> 
<div id="back"></div>

<div class="login-box">
  <div class="login-logo">
    <img src="vistas/img/plantilla/logo-blanco-bloque.png" class="img-responsive">
  </div>

  <div class="login-box-body">
    <p class="login-box-msg">Ingresar al sistema</p>
    
    <!-- Formulario con ID para AJAX -->
    <form id="loginForm" method="post">

      <div class="form-group has-feedback">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" id="ingUsuario" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">

        <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" id="ingPassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="row" style="margin-top: 20px;">  <!-- Añadido margen superior -->
  <div class="col-xs-12 text-center">
    <button type="submit" id="login-btn" class="btn btn-primary btn-block btn-flat" style="max-width: 200px; margin: 15px auto;">Ingresar</button>
  </div>
</div>
      <!-- Área para mensajes AJAX -->
      <div id="login-message" style="margin-top: 15px;"></div>
    </form>
    
    <?php
    // Mantén esta línea COMENTADA para el enfoque AJAX
    // $login = new ControladorUsuarios();
    // $login -> ctrIngresoUsuario();
    ?>
  </div>
</div>

<!-- Incluir jQuery (si no lo tienes) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script AJAX mejorado -->
<script>
$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        // Mostrar carga
        $('#login-message').html('<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Verificando...</div>');
        
        // Deshabilitar el botón
        var $submitBtn = $('#login-btn');
        $submitBtn.prop('disabled', true);
        
        $.ajax({
            url: 'ajax/login.ajax.php',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(response) {
  if(response.success) {
    $('#login-message').html('<div class="alert alert-success"><i class="fa fa-check"></i> Login exitoso</div>');
    setTimeout(function() {
      window.location.href = response.redirect || 'inicio';
    }, 1500);
  } else {
    // Aplicar efecto shake al botón
    var $loginBtn = $('#login-btn');
    $loginBtn.addClass('shake');
    
    // Cambiar color temporalmente a rojo
    $loginBtn.css('background-color', '#ff4444');
    
    // Mostrar mensaje de error
    $('#login-message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Usuario o contraseña incorrectos</div>');
    
    // Restaurar después de 1 segundo
    setTimeout(function() {
      $loginBtn.removeClass('shake');
      $loginBtn.css('background-color', '#1DA1F2');
    }, 1000);
  }
},
            error: function(xhr) {
                let errorMsg = "Error en la conexión";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                $('#login-message').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> '+errorMsg+'</div>');
            },
            complete: function() {
                $submitBtn.prop('disabled', false);
            }
        });
    });
});
</script>
