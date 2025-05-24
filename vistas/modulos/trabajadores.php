<div class="content-wrapper">
  <section class="content-header">
    <?php
    if ($_SESSION["perfil"] == "Especial" || $_SESSION["perfil"] == "Vendedor") {
      echo '<script>window.location = "inicio";</script>';
      return;
    }
    ?>
    <h1>Administrar trabajadores</h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar trabajadores</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarTrabajador">
          Agregar trabajador
        </button>
        <button class="btn btn-success" data-toggle="modal" data-target="#modalImportData">
          Importar masivamente
        </button>
        
        <div class="box-tools pull-right">
          <button class="btn btn-success" id="exportarBtn">
            <i class="fa fa-file-excel-o"></i>
          </button>
        </div>
      </div>

      <div class="box-body">
        <table id="tablaTrabajadores" class="table table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th>#</th>
              <th>Foto</th>
              <th>Nombre</th>
              <th>Cédula</th>
              <th>Correo</th>
              <th>Dirección</th>
              <th>Cargo</th>
              <th>Segunda línea</th>
              <th>Documento</th>
              <th>Carnet</th>
              <th>Carta médica</th>
              <th>Cert. Liviana</th>
              <th>Cert. Pesada</th>
              <th>Licencia</th>
              <th>Nómina</th>
              <th>Creación</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Modales -->
  <?php 
  include 'modales/importar.php';
  include 'modales/agregar_editar.php';
  include 'modales/documentos.php'; 
  ?>
</div>

<script>
$(document).ready(function() {
  const tabla = $('#tablaTrabajadores').DataTable({
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
    },
    ajax: {
      url: 'ajax/trabajadorjs.php',
      dataSrc: ''
    },
    columns: [
      { data: 'id' },
      { 
        data: 'foto',
        render: (data, type, row) => renderFoto(row) 
      },
      { data: 'nombre' },
      { data: 'cedula' },
      { data: 'correo' },
      { data: 'direccion' },
      { data: 'cargo' },
      { data: 'segundaLineaGerencia' },
      { 
        data: 'fotoDocumento',
        render: (data, type, row) => renderDocumento(row) 
      },
      { 
        data: 'fotoCarnet',
        render: data => renderArchivo(data) 
      },
      { 
        data: 'cartaMedica',
        render: (data, type, row) => renderDocumentoConFecha(row, 'CartaMedica') 
      },
      { 
        data: 'certificadoFlotaLiviana',
        render: (data, type, row) => renderDocumentoConFecha(row, 'CertificadoFlotaLiviana') 
      },
      { 
        data: 'certificadoFlotaPesada',
        render: (data, type, row) => renderDocumentoConFecha(row, 'CertificadoFlotaPesada') 
      },
      { 
        data: 'nroLicencia',
        render: (data, type, row) => renderDocumentoConFecha(row, 'Licencia') 
      },
      { data: 'tipoNomina' },
      { data: 'created_at' },
      { 
        data: 'acciones',
        render: (data, type, row) => `
          <button class="btn btn-warning btn Editar" data-id="${row.id}">
            <i class="fa fa-pencil"></i>
          </button>
          <button class="btn btn-danger btnEliminar" data-id="${row.id}">
            <i class="fa fa-trash"></i>
          </button>
        `
      }
    ]
  });





 // Función para exportar datos filtrados
  $('#exportarBtn').on('click', function() {
    const searchValue = tabla.search(); // Obtiene el valor de búsqueda actual
    const queryString = $.param({ search: searchValue }); // Convierte el valor a una cadena de consulta
    window.location.href = `vistas/modulos/descargar-reportetrabajadores.php?reportet=reportet&${queryString}`;
  });








  const renderFoto = (row) => {
    const cedula = row.cedula.padStart(9, '0');
    const imageUrl = `http://ccschu14.pdvsa.com/PHOTOS/${cedula}.jpg`;
    const defaultImage = 'vistas/img/files/default/anonymous.png';
    
    return `
      <a href="${imageUrl}" data-lightbox="image-gallery">
        <img src="${imageUrl}" class="img-thumbnail" 
             width="40px" onerror="this.src='${defaultImage}'">
      </a>
    `;
  };

  const renderDocumento = (data) => 
    data ? `<a href="${data}" target="_blank">Ver documento</a>` : 
    '<span class="label label-danger">No disponible</span>';

  const renderArchivo = (data) => 
    data ? `<a href="${data}" target="_blank">Ver documento</a>` : 
    '<span class="label label-danger">No disponible</span>';

  const renderDocumentoConFecha = (row, tipo) => {
    const fechaField = `fechaVencimiento${tipo}`;
    const fecha = row[fechaField];
    
    if (!fecha) return '<span class="label label-danger">No disponible</span>';
    
    const clase = getClaseVencimiento(fecha);
    return `
      ${row[`foto${tipo}`] ? `<a href="${row[`foto${tipo}`]}" target="_blank">Ver</a><br>` : ''}
      <span class="${clase}">${fecha}</span>
    `;
  };

  const getClaseVencimiento = (fecha) => {
    const hoy = new Date();
    const vencimiento = new Date(fecha);
    const diferencia = vencimiento - hoy;
    const dias = Math.ceil(diferencia / (1000 * 60 * 60 * 24));

    return dias <= 0 ? 'text-danger' : dias <= 30 ? 'text-warning' : 'text-success';
  };

 /* $('#exportarBtn').on('click', function() {
    const filtros = tabla.ajax.params();
    const queryString = $.param(filtros);
    window.location.href = `vistas/modulos/descargar-reportetrabajadores.php?reportet=reportet&${queryString}`;
  });*/

  setInterval(() => tabla.ajax.reload(null, false), 300000);
});
</script>
<script type="text/javascript">
    const fileInput = document.getElementById('file-input');
    const importBtn = document.getElementById('import-btn');

    importBtn.addEventListener('click', (e) => {
        e.preventDefault();

        const file = fileInput.files[0];

        if (!file) {
            Swal.fire({
                title: 'Error!',
                text: 'Por favor selecciona un archivo XLS, XLSX o CSV.',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return;
        }

        const formData = new FormData();
        formData.append('file', file);

        fetch('ajax/import_data.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then((data) => {
            if (data.message === 'Datos importados correctamente.') {
                Swal.fire({
                    title: 'Éxito!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then(() => {
                $('#modalImportData').modal('hide');
            });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        })
        .catch((error) => {
            Swal.fire({
                title: 'Error!',
                text: error.message,
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        });
    });
</script>
