<style type="text/css">
/* Estilos base modernizados */
.login-page {
  display: flex;
  min-height: 100vh;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, rgba(0,20,40,0.95) 0%, rgba(0,60,90,0.95) 100%);
  font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
}

#back {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background: url(vistas/img/plantilla/back.png) center/cover no-repeat;
  z-index: -1;
  opacity: 0.6;
  filter: blur(2px);
}

.login-box {
  width: 380px;
  animation: fadeInUp 0.5s cubic-bezier(0.22, 0.61, 0.36, 1) both;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(25px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.login-box-body {
  background: rgba(255,255,255,0.98);
  border-radius: 12px;
  box-shadow: 0 12px 30px rgba(0,0,0,0.25);
  padding: 35px;
  backdrop-filter: blur(5px);
  border: 1px solid rgba(255,255,255,0.15);
}

/* Estilos para el logo mejorado */
.login-logo {
  text-align: center;
  padding: 15px 0 25px;
  margin-bottom: 5px;
}

.login-logo img {
  width: 190px;
  height: auto;
  transition: all 0.3s ease;
  filter: drop-shadow(0 3px 6px rgba(0,0,0,0.15));
}

.login-logo img:hover {
  transform: scale(1.03);
  filter: drop-shadow(0 5px 10px rgba(0,0,0,0.2));
}

/* Corrección específica para iconos Glyphicon */
.glyphicon {
  position: relative;
  top: 1px; /* Ajuste fino para alinear verticalmente */
  display: inline-block;
  font-family: 'Glyphicons Halflings';
  font-style: normal;
  font-weight: 400;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
}

/* Ajuste específico para los iconos de usuario y contraseña */
.glyphicon-user:before {
  content: "\e008";
  position: relative;
  top: -1px;
}

.glyphicon-lock:before {
  content: "\e033";
  position: relative;
  top: -1px;
}

/* Formulario moderno y accesible */
.form-group {
  margin-bottom: 1.8rem;
  position: relative;
}
@media (max-width: 768px) {
.form-control {
  width: 100%;
  height: 52px;
  padding: 14px 20px 22px 50px;
  border: 2px solid #e0e3e7;
  border-radius: 10px;
  font-size: 15px;
  color: #2d3748;
  background-color: #f8fafc;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
}
.form-control {
  width: 100%;
  height: 52px;
  padding: 14px 20px 20px 50px;
  border: 2px solid #e0e3e7;
  border-radius: 10px;
  font-size: 15px;
  color: #2d3748;
  background-color: #f8fafc;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.form-control:focus {
  border-color: #1a73e8;
  background-color: #fff;
  box-shadow: 0 0 0 4px rgba(26, 115, 232, 0.15);
}

.form-control::placeholder {
  color: #94a3b8;
  font-weight: 400;
}

.form-control-feedback {
  position: absolute;
  top: 50%;
  left: 18px;
  transform: translateY(-50%);
  color: #94a3b8;
  font-size: 16px; /* Tamaño ligeramente reducido */
  width: 20px; /* Ancho fijo para mejor alineación */
  height: 20px;
  text-align: center;
  pointer-events: none;
  z-index: 2;
}

.form-control:focus + .form-control-feedback {
  color: #1a73e8;
}

.login-box-msg {
  color: #1e293b;
  font-size: 19px;
  margin-bottom: 28px;
  font-weight: 600;
  text-align: center;
}

/* Botón modernizado */
#login-btn {
  background: linear-gradient(to right, #1a73e8, #1a73e8);
  border: none;
  border-radius: 10px;
  padding: 15px 30px;
  font-weight: 600;
  font-size: 16px;
  color: white;
  box-shadow: 0 4px 12px rgba(26, 115, 232, 0.25);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  width: 100%;
  display: block;
  margin: 25px auto 15px;
  cursor: pointer;
}

#login-btn:hover {
  background: linear-gradient(to right, #1a73e8, #1a73e8);
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(26, 115, 232, 0.35);
}

#login-btn:active {
  transform: translateY(0);
  box-shadow: 0 2px 8px rgba(26, 115, 232, 0.3);
}

#login-btn.error {
  background: linear-gradient(to right, #d32f2f, #b71c1c);
  box-shadow: 0 4px 12px rgba(211, 47, 47, 0.25);
}

/* Sistema de mensajes mejorado */
#login-message {
  margin: 20px 0 10px;
  text-align: center;
}

.alert {
  padding: 14px 20px;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 500;
  display: inline-flex;
  align-items: center;
  max-width: 100%;
  animation: fadeIn 0.3s ease-out;
  box-shadow: 0 3px 10px rgba(0,0,0,0.08);
  border: 1px solid transparent;
}

.alert-danger {
  background-color: #fff5f5;
  border-color: #ffd6d6;
  color: #d32f2f;
}

.alert-success {
  background-color: #f0fff4;
  border-color: #c6f6d5;
  color: #2e7d32;
}

.alert-info {
  background-color: #f0f9ff;
  border-color: #cae3ff;
  color: #1a73e8;
}

.alert i {
  margin-right: 12px;
  font-size: 18px;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-5px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Icono de error con diseño moderno */
.error-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
  background-color: #dc2626;
  color: white;
  border-radius: 50%;
  margin-right: 10px;
  font-size: 14px;
  flex-shrink: 0;
}

/* Responsive mejorado */
@media (max-width: 768px) {
  .login-box {
    width: 90%;
    max-width: 420px;
  }

  .login-box-body {
    padding: 30px;
  }

  .login-logo img {
    width: 170px;
  }
}

@media (max-width: 480px) {
  .login-box-body {
    padding: 25px;
    border-radius: 10px;
  }

@media (max-width: 480px) {
  .form-control {
    padding-left: 45px;
  }

  .form-control-feedback {
    left: 15px;
    font-size: 14px;
  }

  .login-box-msg {
    font-size: 17px;
  }

  #login-btn {
    padding: 14px 25px;
  }

  .login-logo img {
    width: 150px;
  }

  .alert {
    padding: 12px 18px;
    font-size: 13px;
  }
}
</style>


<div id="back"></div>

<div class="login-box">
  <!-- Logo centrado con tamaño responsive -->
  <div class="login-logo">
    <img src="vistas/img/plantilla/logo-blanco-bloque.png" alt="Logo PDVSA" class="img-responsive">
  </div>

  <div class="login-box-body">
    <p class="login-box-msg">Ingresar al sistema</p>

    <form id="loginForm" method="post">
   <input type="hidden" name="csrf_token" value="<?= isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : '' ?>">

 <div class="form-group has-feedback">
  <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" id="ingUsuario" required>
  <span class="glyphicon glyphicon-user form-control-feedback"></span>
</div>

<div class="form-group has-feedback">
  <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" id="ingPassword" required>
  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>

      <div class="text-center">
        <button type="submit" id="login-btn" class="btn btn-primary btn-flat">Ingresar</button>
      </div>

      <div id="login-message"></div>
    </form>

    <?php
    // Mantén esta línea COMENTADA para el enfoque AJAX
   // $login = new ControladorUsuarios();
    // $login -> ctrIngresoUsuario();
    ?>
  </div>
</div>

<!-- Script AJAX mejorado -->
 <script>
    $(document).ready(function() {
      $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        // Mostrar carga
        $('#login-message').html(`
          <div class="alert alert-info">
            <i class="fa fa-spinner fa-spin"></i>
            <span>Verificando credenciales...</span>
          </div>
        `);

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
              $('#login-message').html(`
                <div class="alert alert-success">
                  <i class="fa fa-check-circle"></i>
                  <span>Login exitoso. Redireccionando...</span>
                </div>
              `);
              setTimeout(function() {
                window.location.href = response.redirect || 'inicio';
              }, 1500);
            } else {
              var $loginBtn = $('#login-btn');
              $loginBtn.addClass('error');
              $('#login-message').html(`<div class="alert alert-danger">
                  <span class="error-icon">!</span>
                  <span>Usuario o contraseña incorrectos. Por favor intente nuevamente.</span>
                </div>
              `);
              setTimeout(function() {
                $loginBtn.removeClass('error');
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
