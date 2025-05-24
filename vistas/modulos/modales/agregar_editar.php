<div class="modal fade" id="modalAgregarTrabajador" tabindex="-1" aria-labelledby="modalAgregarTrabajadorLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Gestión de Trabajador</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formTrabajador" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="id_trabajador">
          
          <div class="row g-4">
            <!-- Sección Foto y Datos Básicos -->
            <div class="col-md-4">
              <div class="avatar-upload">
                <div class="avatar-preview">
                  <img src="vistas/img/usuarios/default/anonymous.png" class="rounded-circle" id="fotoPreview">
                </div>
                <input type="file" id="fotoInput" name="foto" accept="image/*" class="d-none">
                <button type="button" class="btn btn-outline-primary btn-sm mt-3" onclick="document.getElementById('fotoInput').click()">
                  <i class="fa fa-camera me-2"></i>Subir Foto
                </button>
              </div>
              
              <div class="mt-4">
                <button type="button" class="btn btn-outline-info w-100" data-toggle="modal" data-target="#modalDocumentos">
                  <i class="fa fa-folder-open me-2"></i>Subir Documentos
                </button>
              </div>
            </div>

            <!-- Sección de Campos del Formulario -->
            <div class="col-md-8">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Cédula <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="cedula" required 
                         pattern="[VE]-\d{8}" title="Formato: V-12345678">
                </div>
                
                <div class="col-md-6">
                  <label class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="nombre" required>
                </div>
                
                <div class="col-md-6">
                  <label class="form-label">Correo Electrónico</label>
                  <input type="email" class="form-control" name="correo">
                </div>
                
                <div class="col-md-6">
                  <label class="form-label">Fecha de Nacimiento</label>
                  <input type="date" class="form-control" name="fecha_nacimiento">
                </div>
                
                <div class="col-12">
                  <label class="form-label">Dirección</label>
                  <textarea class="form-control" name="direccion" rows="2"></textarea>
                </div>
                
                <div class="col-md-6">
                  <label class="form-label">Cargo <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="cargo" required>
                </div>
                
                <div class="col-md-6">
                  <label class="form-label">Tipo de Nómina</label>
                  <select class="form-select" name="tipo_nomina">
                    <option value="NCD">NCD</option>
                    <option value="NCM">NCM</option>
                    <option value="NNC">NNC</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>