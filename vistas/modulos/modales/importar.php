<div class="modal fade" id="modalImportData" tabindex="-1" aria-labelledby="modalImportDataLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Importar Datos Masivos</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formImportar" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="alert alert-info">
            <i class="fa fa-circle-info"></i> Formato requerido: 
            <a href="assets/formato_importacion.xls" download class="text-decoration-none">
              Descargar plantilla <i class="fa fa-download"></i>
            </a>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Archivo a importar</label>
            <input type="file" id="file-input" class="form-control" name="archivo" 
                   accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
            <div class="form-text">Formatos permitidos: XLS, XLSX, CSV (Max. 5MB)</div>
          </div>
          
          <div class="progress d-none">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" 
                 style="width: 0%">0%</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button id="import-btn" class="btn btn-success">
            <i class="fa fa-upload me-2"></i>Importar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
