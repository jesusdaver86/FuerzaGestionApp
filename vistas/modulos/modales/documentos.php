<div class="modal fade" id="modalDocumentos" tabindex="-1" aria-labelledby="modalDocumentosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Gestión de Documentos</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formDocumentos" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="id_trabajador">
          
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
              <select class="form-select" name="tipo_documento" required>
                <option value="">Seleccionar...</option>
                <option value="cedula">Cédula</option>
                <option value="carnet">Carnet</option>
                <option value="licencia">Licencia</option>
                <option value="certificado_medico">Certificado Médico</option>
                <option value="certificado_flota">Certificado de Flota</option>
              </select>
            </div>
            
            <div class="col-md-6">
              <label class="form-label">Fecha de Vencimiento <span class="text-danger">*</span></label>
              <input type="date" class="form-control" name="fecha_vencimiento" required>
            </div>
            
            <div class="col-12">
              <label class="form-label">Archivo Digitalizado <span class="text-danger">*</span></label>
              <input type="file" class="form-control" name="documento" 
                     accept=".pdf, .jpg, .jpeg, .png" required>
              <div class="form-text">Formatos permitidos: PDF, JPG, PNG (Max. 5MB)</div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-info">Guardar Documento</button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.avatar-upload {
  position: relative;
  max-width: 200px;
  margin: 0 auto;
}

.avatar-preview {
  width: 150px;
  height: 150px;
  border: 2px solid #dee2e6;
  border-radius: 50%;
  overflow: hidden;
}

.avatar-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>

<script>
$(document).ready(function() {
  // Manejo de la foto
  $('#fotoInput').change(function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (event) => {
        $('#fotoPreview').attr('src', event.target.result);
      };
      reader.readAsDataURL(file);
    }
  });

  // Validación de documento único
  $('#formDocumentos').submit(function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    if (formData.get('documento').size > 5 * 1024 * 1024) {
      mostrarError('El archivo excede el tamaño máximo de 5MB');
      return;
    }
    
    // Aquí iría la lógica AJAX para guardar
    console.log('Datos del documento:', Object.fromEntries(formData));
  });

  // Función para mostrar errores
  function mostrarError(mensaje) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: mensaje,
      confirmButtonColor: '#3085d6'
    });
  }
});
</script>