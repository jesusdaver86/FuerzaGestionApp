<div class="content-wrapper">


  <section class="content-header">

    <?php

    if ($_SESSION["perfil"] == "Especial" || $_SESSION["perfil"] == "Vendedor") {

      echo '<script>

              window.location = "inicio";

            </script>';

      return;

    }

    ?>

    <h1>

      Administrar trabajadores

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar trabajadores</li>

    </ol>

  </section>


 <section class="content">

    <!-- Caja para el botón Agregar trabajador -->
    <div class="box">
        <div class="box-header with-border">

            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarTrabajador">
                Agregar trabajador
            </button>
<button class="btn btn-success" data-toggle="modal" data-target="#modalImportData">

    Importar masivamente

</button>
        </div>

    <div class="box-tools pull-right">
        <?php 
            echo '<a href="vistas/modulos/descargar-reportetrabajadores.php?reportet=reportet" target="_blank">';
         ?>
        <button class="btn btn-success" style="margin-top:5px">Descargar reporte en Excel</button>
      </a>
        <br>
         <br>
       </div>


</head>

<body>



<div class="box-body">
    <table id="example" class="table table-bordered table-striped dt-responsive tables" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Correo</th>
                <th>Fecha de nacimiento</th>
                <th>Dirección</th>
                <th>Cargo</th>
                <th>Segunda línea de gerencia</th>
                <th>Documento</th>
                <th>Carnet</th>
                <th>Carta médica</th>
                <th>Certificado de manejo</th>
                <th>Licencia</th>
                <th>Tipo de nómina</th>
                <th>Fecha de creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tbody-trabajadores">
            <!-- Los datos se renderizarán aquí -->
        </tbody>
    </table>
</div>

</div>




    </div>
</section>




<!-- Modal -->

<div class="modal fade" id="modalImportData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <h4 class="modal-title" id="myModalLabel">Importar datos masivamente</h4>

            </div>

            <div class="modal-body">

                <form id="import-form">

                    <input type="file" id="file-input" accept=".csv">

                    <button id="import-btn">Import Data</button>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

            </div>

        </div>

    </div>

</div>

<script>

 $(document).ready(function() {

        var table = $('#example').DataTable({

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

            },

            "ordering": true,

            "paging": true,

            "searching": true,

            "info": true,

            "responsive": true,

            "autoWidth": false,
            "columnDefs": [
            { "width": "2%", "targets": 4 },
            { "width": "2%", "targets": 5 },
            { "width": "2%", "targets": 7 },
            { "width": "5%", "targets": 16 },


         

    

        ],


            "ajax": {

                "url": "ajax/trabajadorjs.php",

                "dataSrc": function(json) {

             

                    return json;

                }

            },

            "columns": [

                { "data": "id" },

                { "data": "foto",

                    "render": function(data, type, row) {

                        if (type === 'display') {

                            if (data!= "") {

                                return '<a href="' + data + '" data-lightbox="image-gallery"><img src="' + data + '" class="img-thumbnail" width="40px"> </a>';

                            } else {

                                return '<a href="vistas/img/trabajadores/default/anonymous.png" data-lightbox="image-gallery"><img src="vistas/img/trabajadores/default/anonymous.png" class="img-thumbnail" width="40px"></a>';

                            }

                        }

                        return data;

                    }

                },

                { "data": "nombre" },

                { "data": "cedula" },

                { "data": "correo" },

                { "data": "fechaNacimiento" },

                { "data": "direccion" },

                { "data": "cargo" },

                { "data": "segundaLineaGerencia" },

                { "data": "fotoDocumento",

                 "render": function(data, type, row) {

                        if (type === 'display') {

                            if (data!= "") {

                                return '<a href="' + data + '" target="_blank">Ver copia de documento</a><br>' +

                                    '<a href="#" data-toggle="modal" data-target="#modalVerDocumento" data-ruta="' + data + '" data-vencimiento="' + row.fechaVencimientoDocumento + '"><span class="' + getClaseDocumento(row.fechaVencimientoDocumento) + '">' + row.fechaVencimientoDocumento + '</span></a><br/>';

                            } else {

                                return '<span class="label label-danger">No disponible</span>';

                            }

                        }

                        return data;

                    }

                },

                { "data": "fotoCarnet",

  "render": function(data, type, row) {

    if (type === 'display') {

      if (data != "") {

        return '<a href="' + data + '" target="_blank">Ver copia de carnet</a><br/>';

      } else {

        return '<span class="label label-danger">No disponible</span>';

      }

    }

    return data;

  }

},

                { "data": "cartaMedica",


                    "render": function(data, type, row) {

                        if (type === 'display') {

                            if (data!= "") {

                                return '<a href="' + data + '" target="_blank">Ver copia de documento</a><br>' +

                                    '<a href="#" data-toggle="modal" data-target="#modalVerDocumento" data-ruta="' + data + '" data-vencimiento="' + row.fechaVencimientoCartaMedica + '"><span class="' + getClaseCartaMedica(row.fechaVencimientoCartaMedica) + '">' + row.fechaVencimientoCartaMedica + '</span></a><br/>';

                            } else {

                                return '<span class="label label-danger">No disponible</span>';

                            }

                        }

                        return data;

                    }

                },

                { "data": "certificadoManejo",


                    "render": function(data, type, row) {

                        if (type === 'display') {

                            if (data!= "") {

                                return '<a href="' + data + '" target="_blank">Ver copia de documento</a><br>' +

                                    '<a href="#" data-toggle="modal" data-target="#modalVerDocumento" data-ruta="' + data + '" data-vencimiento="' + row.fechaVencimientoCertificadoManejo + '"><span class="' + getClaseCertificadoManejo(row.fechaVencimientoCartaMedica) + '">' + row.fechaVencimientoCertificadoManejo + '</span></a><br/>';

                            } else {

                                return '<span class="label label-danger">No disponible</span>';

                            }

                        }

                        return data;

                    }

                },

                { "data": "nroLicencia",


                    "render": function(data, type, row) {

                        if (type === 'display') {

                            if (data!= "") {

                                return '<a href="' + data + '" target="_blank">Ver copia de documento</a><br>' +

                                    '<a href="#" data-toggle="modal" data-target="#modalVerDocumento" data-ruta="' + data + '" data-vencimiento="' + row.fechaVencimientoLicencia + '"><span class="' + getClaseLicencia(row.fechaVencimientoLicencia) + '">' + row.fechaVencimientoLicencia + '</span></a><br/>';

                            } else {

                                return '<span class="label label-danger">No disponible</span>';

                            }

                        }

                        return data;

                    }

                },

                { "data": "tipoNomina" },

                { "data": "created_at" },

                { "data": "acciones", 
"render": function(data, type, row) {
   return '<td><button class="btn btn-warning btnEditarTrabajador" data-id="' + row.id + '"><i class="fa fa-pencil"></i> Editar </button>' + '<button class="btn btn-danger btnEliminarTrabajador" data-id="' + row.id + '"><i class="fa fa-trash"></i> Eliminar </button></td>';


}
              
} 

            ],

            "dom": '<"top"f>rt<"bottom"ip><"clear">',

            "buttons": [

                'copy', 'excel', 'pdf'

            ]







        });






        function actualizarTabla() {

       table.ajax.reload();
       /*dataTable.fnReloadAjax();*/
       

        }


        setInterval(actualizarTabla, 10000);










table.on('draw.dt', function () {

  let vencimientosRevisados = new Set();

  for (let i = 0; i < table.rows().count(); i++) {
    const row = table.row(i);
    const data = row.data();

    const registroId = data.idRegistro; // Suponiendo que exista una columna 'idRegistro'

    if (vencimientosRevisados.has(registroId)) continue;

    vencimientosRevisados.add(registroId);

    let notificacionesMostradas = false;

    // Mostrar notificaciones para cada fecha de vencimiento
    if (data.fechaVencimientoDocumento) {
      if (hasExpired(data.fechaVencimientoDocumento)) {
        showNotification('Documento', data.nombre, 'La fecha de vencimiento del documento ha expirado', true);
        notificacionesMostradas = true;
      } else if (isNearExpiration(data.fechaVencimientoDocumento)) {
        showNotification('Documento', data.nombre, 'La fecha de vencimiento del documento está cerca', true);
        notificacionesMostradas = true;
      }
    }
   if (data.fechaVencimientoCartaMedica) {
     if (hasExpired(data.fechaVencimientoCartaMedica)) {
       showNotification('Carta médica', data.nombre, 'La fecha de vencimiento de la carta médica ha expirado', true);
       notificacionesMostradas = true;
     } else if (isNearExpiration(data.fechaVencimientoCartaMedica)) {
       showNotification('Carta médica', data.nombre, 'La fecha de vencimiento de la carta médica está cerca', true);
       notificacionesMostradas = true;
     }
   }

   if (data.fechaVencimientoCertificadoManejo) {
     if (hasExpired(data.fechaVencimientoCertificadoManejo)) {
       showNotification('Certificado de manejo', data.nombre, 'La fecha de vencimiento del certificado de manejo ha expirado', true);
       notificacionesMostradas = true;
     } else if (isNearExpiration(data.fechaVencimientoCertificadoManejo)) {
       showNotification('Certificado de manejo', data.nombre, 'La fecha de vencimiento del certificado de manejo está cerca', true);
       notificacionesMostradas = true;
     }
   }

   if (data.fechaVencimientoLicencia) {
     if (hasExpired(data.fechaVencimientoLicencia)) {
       showNotification('Licencia', data.nombre, 'La fecha de vencimiento de la licencia ha expirado', true);
       notificacionesMostradas = true;
     } else if (isNearExpiration(data.fechaVencimientoLicencia)) {
       showNotification('Licencia', data.nombre, 'La fecha de vencimiento de la licencia está cerca', true);
       notificacionesMostradas = true;
     }
   }

    // Mostrar una sola notificación por registro si se ha mostrado alguna
    if (notificacionesMostradas) {
      showNotificationGeneral('Notificaciones para ' + data.nombre, 'Se han encontrado vencimientos o fechas cercanas para este registro', true);
    }
  }
});

const today = new Date(); // Almacenar en caché la fecha actual

function isNearExpiration(date) {
  const expirationDate = new Date(date);
  const diff = expirationDate.getTime() - today.getTime();
  return diff <= 30 * 24 * 60 * 60 * 1000; 
}


function hasExpired(date) {
  const expirationDate = new Date(date);
  return expirationDate.getTime() < today.getTime();
}

function showNotification(type, name, message, autocerrar = true) {
  const notification = new Notification(type + ' ' + name, {
    body: message,
    icon: 'assets/img/icon.png'
  });

  if (autocerrar) {
    setTimeout(() => notification.close(), 5000);
  }
}

function showNotificationGeneral(type, message, autocerrar = true) {
  const notification = new Notification(type, {
    body: message,
    icon: 'assets/img/icon.png'
  });

  if (autocerrar) {
    setTimeout(() => notification.close(), 5000);
  }
}   












    });































    function getClaseDocumento(fechaVencimiento) {

        var fechaV1 = new Date();

        var fechaVencimientoDate = new Date(fechaVencimiento);

        return fechaVencimientoDate < fechaV1 ? "claseVencida" : fechaVencimientoDate < fechaV1.setDate(fechaV1.getDate() + 30) ? "claseProximoVencimiento" : "";

    }


    function getClaseCartaMedica(fechaVencimiento) {

        var fechaV1 = new Date();

        var fechaVencimientoDate = new Date(fechaVencimiento);

        return fechaVencimientoDate < fechaV1 ? "claseVencida" : fechaVencimientoDate< fechaV1.setDate(fechaV1.getDate() + 30) ? "claseProximoVencimiento" : "";

    }


    function getClaseCertificadoManejo(fechaVencimiento) {

        var fechaV1 = new Date();

        var fechaVencimientoDate = new Date(fechaVencimiento);

        return fechaVencimientoDate < fechaV1 ? "claseVencida" : fechaVencimientoDate < fechaV1.setDate(fechaV1.getDate() + 30) ? "claseProximoVencimiento" : "";

    }


    function getClaseLicencia(fechaVencimiento) {

        var fechaV1 = new Date();

        var fechaVencimientoDate = new Date(fechaVencimiento);

        return fechaVencimientoDate < fechaV1 ? "claseVencida" : fechaVencimientoDate < fechaV1.setDate(fechaV1.getDate() + 30) ? "claseProximoVencimiento" : "";

    }


















</script>









<script type="text/javascript">
    const form = document.getElementById('import-form');

const fileInput = document.getElementById('file-input');

const importBtn = document.getElementById('import-btn');

const resultDiv = document.getElementById('result');


importBtn.addEventListener('click', (e) => {

    e.preventDefault();

    const file = fileInput.files[0];

    const formData = new FormData();

    formData.append('file', file);


    fetch('ajax/import_data.php', {

        method: 'POST',

        body: formData

    })

    .then(response => response.json())

    .then((data) => {

        if (data.message === 'Data imported successfully!') {

            Swal.fire({

                title: 'Éxito!',

                text: data.message,

                icon: 'success',

                confirmButtonText: 'Ok'

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



<div class="modal fade" id="modalAgregarTrabajador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form role="form" method="post" id="formAgregarTrabajador" enctype="multipart/form-data">
        <div class="modal-header" style="background-color: #3c8dbc; color: white; padding: 10px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Agregar trabajador</h4>
        </div>
        <div class="modal-body">
          <div class="box-body text-center">
            <!-- Worker's photo -->
            <div class="worker-photo-container">
                      <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail worker-photo" width="100px" data-toggle="modal" >
             
                                                        
            </div>
            <!-- Other form fields -->

  <!-- ENTRADA PARA EL DOCUMENTO ID -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" min="0" class="form-control input-lg" id="cedula" name="cedula" placeholder="Ingresar documento" required onblur="validarDocumentoId(this)">



              </div>
              <div id="alertaDocumentoId" class="text-danger"></div>

            </div>

<script type="text/javascript">
         $(document).ready(function() {
          
              $("#cedula").on("keyup", function() {
                var documento =$(this).val();
        
                  $.ajax({
                    url: "ajax/documentojs.php",
                    method: "POST",
                    data:{
                      'accion': 'obtenerNombre',
                      'doc':documento,
                    },
                    success: function(respuesta){
                      $("#nombre").val(respuesta);
                
                    }
                  });
                /*}*/
              });
            });
</script>


             <!-- ENTRADA NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" min="0" class="form-control input-lg" id="nombre" name="nombre" placeholder="Ingresar nombre" required onblur="validarNombre(this)">

              </div>
              <div id="alertaNombre" class="text-danger"></div>

            </div>














            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control input-lg" id="correo" name="correo" placeholder="Ingresar correo" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control input-lg" name="fechaNacimiento" id="fechaNacimiento" placeholder="Ingresar fecha de nacimiento" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input type="text" class="form-control input-lg" id="direccion" name="direccion" placeholder="Ingresar dirección" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                <input type="text" class="form-control input-lg" id="cargo" name="cargo" placeholder="Ingresar cargo" required>
              </div>
            </div>




<div class="form-group row">


  <label for="fechaVencimientoDocumento" class="col-sm-4 col-form-label">Fecha de vencimiento del documento Id:</label>


  <div class="col-sm-8">


    <button type="button" class="btn btn-primary btn-lg mt-2" data-toggle="modal" data-target="#modalAgregarFotoDocumento">


      <i class="fa fa-plus"></i> Agregar foto documento


    </button>


  </div>


</div>


<div class="form-group row">

  <label for="fotoCarnet" class="col-sm-4 col-form-label">Foto de carnet:</label>

  <div class="col-sm-8">

    <button type="button" class="btn btn-primary btn-lg mt-2" data-toggle="modal" data-target="#modalAgregarFotoCarnet">

      <i class="fa fa-plus"></i> Agregar foto carnet

    </button>

  </div>

</div>




<div class="form-group row">

  <label for="fechaVencimientoCartaMedica" class="col-sm-4 col-form-label">Fecha de vencimiento de la carta médica:</label>

  <div class="col-sm-8">

    <button type="button" class="btn btn-primary btn-lg mt-2" data-toggle="modal" data-target="#modalAgregarCartaMedica">

      <i class="fa fa-plus"></i> Agregar carta médica

    </button>

  </div>

</div>

<div class="form-group row">

  <label for="fechaVencimientoCertificadoManejo" class="col-sm-4 col-form-label">Fecha de vencimiento del certificado de manejo:</label>

  <div class="col-sm-8">

    <button type="button" class="btn btn-primary btn-lg mt-2" data-toggle="modal" data-target="#modalAgregarCertificadoManejo">

      <i class="fa fa-plus"></i> Agregar certificado de manejo

    </button>

  </div>

</div>

<div class="form-group row">

  <label for="fechaVencimientoLicencia" class="col-sm-4 col-form-label">Fecha de vencimiento de licencia:</label>

  <div class="col-sm-8">

    <button type="button" class="btn btn-primary btn-lg mt-2" data-toggle="modal" data-target="#modalAgregarNroLicencia">

      <i class="fa fa-plus"></i> Agregar licencia

    </button>

  </div>

</div>






          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
        <?php
          $crearTrabajador = new ControladorTrabajadores();
          $crearTrabajador->ctrCrearTrabajador();
        ?>
      </form>
    </div>
  </div>
</div>

<div id="image-gallery"></div>


<!-- Upload worker photo modal -->




<div class="modal fade" id="modalSubirFotoTrabajador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <form role="form" id="formSubirFotoTrabajador" enctype="multipart/form-data">

        <div class="modal-header" style="background-color: #3c8dbc; color: white; padding: 10px;">

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true">&times;</span>

          </button>

          <h4 class="modal-title">Subir foto del trabajador</h4>

        </div>

        <div class="modal-body">

          <div class="form-group">

            <label for="foto">Seleccionar archivo:</label>

            <input type="file" id="foto" name="foto" required>

            <p class="help-block">Seleccione una imagen con un peso máximo de 2MB.</p>

          </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>

          <button type="button" class="btn btn-primary" id="btnSubirFoto">Guardar</button>

        </div>

      </form>

    </div>

  </div>

</div>



<!-- Modal para agregar foto documento -->

<div class="modal fade" id="modalAgregarFotoDocumento" tabindex="-1" role="dialog" aria-labelledby="modalAgregarFotoDocumentoLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header" style="background-color: #3c8dbc; color: white; padding: 10px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modalAgregarFotoDocumentoLabel">Agregar foto documento</h4>
      </div>

      <div class="modal-body">

        <form id="formSubirFotoDocumento" enctype="multipart/form-data">

          <div class="form-group">

            <div class="custom-file">

              <input type="file" id="fotoDocumento" name="fotoDocumento" class="custom-file-input" required>

              <label class="custom-file-label" for="fotoDocumento">Seleccione un archivo</label>

            </div>

          </div>

          <div class="form-group">
            <div class="form-group"> 
              <div class="input-group"> 
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                <input type="text" class="form-control input-lg" id="fechaVencimientoDocumento" name="fechaVencimientoDocumento" placeholder="Fecha de vencimiento documento Id" required> 
              </div> 
            </div>
          </div>

        </form>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

        <button type="button" class="btn btn-primary" id="btnSubirFotoDocumento">Guardar</button>

      </div>

    </div>

  </div>

</div>






<div class="modal fade" id="modalAgregarFotoCarnet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form role="form" id="formFotoCarnet" enctype="multipart/form-data">
        <div class="modal-header" style="background-color: #3c8dbc; color: white; padding: 10px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Cargar foto de carnet</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="foto">Seleccionar archivo:</label>
            <input type="file" id="fotoCarnet" name="fotoCarnet" required>
            <p class="help-block">Seleccione una imagen con un peso máximo de 2MB.</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btnSubirFotoCarnet">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal para agregar carta médica -->

<div class="modal fade" id="modalAgregarCartaMedica" tabindex="-1" role="dialog" aria-labelledby="modalAgregarCartaMedicaLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

   <div class="modal-header" style="background-color: #3c8dbc; color: white; padding: 10px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="modalAgregarCartaMedicaLabel">Agregar carta medica</h4>
        </div>

      <div class="modal-body">

        <form id="formSubirCartaMedic" enctype="multipart/form-data">

          <div class="form-group">


            <div class="custom-file">

              <input type="file" id="cartaMedica" name="cartaMedica" class="custom-file-input" required>

              <label class="custom-file-label" for="cartaMedica">Seleccione un archivo</label>

            </div>

          </div>



         <div class="form-group">
     
            <div class="form-group"> <div class="input-group"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span> <input type="text" class="form-control input-lg" id="fechaVencimientoCartaMedica" name="fechaVencimientoCartaMedica" placeholder="Fecha de vencimiento carta" required> </div> </div>

          </div>

        </form>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

        <button type="button" class="btn btn-primary" id="btnSubirCartaMedica">Guardar</button>

      </div>

    </div>

  </div>

</div>


<!-- Modal para agregar certificado de manejo -->

<div class="modal fade" id="modalAgregarCertificadoManejo" tabindex="-1" role="dialog" aria-labelledby="modalAgregarCertificadoManejoLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">


      <div class="modal-header" style="background-color: #3c8dbc; color: white; padding: 10px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="modalAgregarCertificadoManejoLabel">Agregar certificado de manejo</h4>
        </div>





      <div class="modal-body">

        <form  method="post" id="formSubirCertificadoManejo" enctype="multipart/form-data">

          <div class="form-group">

 

            <div class="custom-file">

              <input type="file" id="certificadoManejo" name="certificadoManejo" class="custom-file-input">

              <label class="custom-file-label" for="certificadoManejo">Seleccione un archivo</label>

            </div>

          </div>

   <div class="form-group">
     
            <div class="form-group"> <div class="input-group"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span> <input type="text" class="form-control input-lg" id="fechaVencimientoCertificadoManejo" name="fechaVencimientoCertificadoManejo" placeholder="Fecha de vencimiento certificado" required> </div> </div>

          </div>

        </form>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

        <button type="button" class="btn btn-primary" id="btnSubirCertificadoManejo">Guardar</button>

      </div>

    </div>

  </div>

</div>




<!-- Modal para agregar Licencia -->

<div class="modal fade" id="modalAgregarNroLicencia" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLicenciaLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">


      <div class="modal-header" style="background-color: #3c8dbc; color: white; padding: 10px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="modalAgregarNroLicenciaLabel">Agregar certificado de manejo</h4>
        </div>





      <div class="modal-body">

        <form  method="post" id="formSubirLicencia" enctype="multipart/form-data">

          <div class="form-group">

 

            <div class="custom-file">

              <input type="file" id="nroLicencia" name="nroLicencia" class="custom-file-input">

              <label class="custom-file-label" for="nroLicencia">Seleccione un archivo</label>

            </div>

          </div>

   <div class="form-group">
     
            <div class="form-group"> <div class="input-group"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span> <input type="text" class="form-control input-lg" id="fechaVencimientoLicencia" name="fechaVencimientoLicencia" placeholder="Fecha de vencimiento licencia" required> </div> </div>

          </div>

        </form>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

        <button type="button" class="btn btn-primary" id="btnSubirLicencia">Guardar</button>

      </div>

    </div>

  </div>

</div>



<style>


   .claseVencida {


        color: red;


    }


   .claseProximoVencimiento {


        color: orange;


    }


 /*   table {

  table-layout: fixed;

  width: 100%;

}


th, td {

  overflow: hidden;

  white-space: nowrap;

  text-overflow: ellipsis;

}*/


</style>

<style>
.text-center {

    text-align: center;

}


.bg-vencida {

    background-color: #FF0000; /* rojo */

}


.bg-proximo-vencimiento {

    background-color: #FFA500; /* naranja */

}

</style>



<style>


.worker-photo-container {


  position: relative;


  margin-bottom: 20px;

  width: 100px;

  height: 78px; 

border: 1px solid #ccc;



}



.worker-photo {


  cursor: pointer;



}

.worker-photo-container img {

  object-fit: contain; /* Mantiene el tamaño original de la imagen */

  width: 100%; /* Ancho del 100% del contenedor */

  height: 100%; /* Altura del 100% del contenedor */

}


</style>






<script>
$(document).ready(function() {
  var error = false;

  $('#btnSubirFoto').click(function() {
    var input = $('#foto');
    var file = input[0].files[0];

    if (file) {
      if (file.size > 2097152) { // 2 MB
        swal({
          title: "Error al subir la imagen",
          text: "¡La imagen no debe pesar más de 2MB!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
        error = true;
        return;
      }

      if (!file.type.match('image.*')) {
        swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
        error = true;
        return;
      }
    }

    $('#modalSubirFotoTrabajador').modal('hide');
  });

  $('#foto').on('change', function() {
    var file = this.files[0];
    var reader = new FileReader();

    reader.onload = function(event) {
      var img = $('<img>').attr('src', event.target.result);
      $('.worker-photo-container').html(img);
    };

    reader.readAsDataURL(file);
  });

  // Prevent the form from submitting when the modal is hidden
  $('#modalSubirFotoTrabajador').on('hidden.bs.modal', function(e) {
    e.preventDefault();
    /*$('#formSubirFotoTrabajador').trigger('reset');*/
    error = false;
  });

  // Evitar que se pueda modificar la previsualización de la imagen cuando ocurre un error
  $('.worker-photo-container').on('click', function() {
    if (!error) {
      $('#modalSubirFotoTrabajador').modal('show');
    }
  });
});
</script>









<script>

  $(document).ready(function() {

    $('#btnSubirFotoDocumento').click(function() {

      $('#modalAgregarFotoDocumento').modal('hide');

    });

  });

</script>


<script>

  $(document).ready(function() {

    $('#btnSubirFotoCarnet').click(function() {

      $('#modalAgregarFotoCarnet').modal('hide');

    });

  });

</script>

<script>

  $(document).ready(function() {

    $('#btnSubirCartaMedica').click(function() {

      $('#modalAgregarCartaMedica').modal('hide');

    });

  });

</script>

<script>

  $(document).ready(function() {

    $('#btnSubirCertificadoManejo').click(function() {

      $('#modalAgregarCertificadoManejo').modal('hide');

    });

  });

</script>

<script>

  $(document).ready(function() {

    $('#btnSubirLicencia').click(function() {

      $('#modalAgregarNroLicencia').modal('hide');

    });

  });

</script>










<script>

  $(document).ready(function() {

    $('#btnSubirFotoDocumento').click(function() {

      var input = $('#fotoDocumento');

      var file = input[0].files[0];

      if (file) {

        if (file.size > 2097152) { // 2 MB

          alert('El tamaño del archivo no debe exceder los 2 MB.');

          return;

        }

        if (!file.type.match('application/pdf')) {

          alert('El archivo debe ser un PDF.');

          return;

        }

      }

      $('#modalAgregarFotoDocumento').modal('hide');

    });


  });

</script>


<script>

  $(document).ready(function() {

    $('#btnSubirFotoCarnet').click(function() {

      var input = $('#fotoCarnet');

      var file = input[0].files[0];

      if (file) {

        if (file.size > 2097152) { // 2 MB

          alert('El tamaño del archivo no debe exceder los 2 MB.');

          return;

        }

        if (!file.type.match('application/pdf')) {

          alert('El archivo debe ser un PDF.');

          return;

        }

      }

      $('#modalAgregarFotoCarnet').modal('hide');

    });


  });

</script>




<script>

  $(document).ready(function() {

    $('#btnSubirLicencia').click(function() {

      var input = $('#nroLicencia');

      var file = input[0].files[0];

      if (file) {

        if (file.size > 2097152) { // 2 MB

          alert('El tamaño del archivo no debe exceder los 2 MB.');

          return;

        }

        if (!file.type.match('application/pdf')) {

          alert('El archivo debe ser un PDF.');

          return;

        }

      }

      $('#modalAgregarNroLicencia').modal('hide');

    });


  });

</script>


<script>

$(document).ready(function() {

  $('#fechaNacimiento').datepicker({

    format: 'yyyy-mm-dd',

    language: 'es',

    autoclose: true,

    todayHighlight: true,

    todayBtn: true,

    forceParse: true

  });

});


</script>

<script>
$(document).ready(function() {

  $('#fechaVencimientoDocumento').datepicker({

    format: 'yyyy-mm-dd',

    language: 'es',

    autoclose: true,

    todayHighlight: true,

    todayBtn: true,

    forceParse: true

  });

});

</script>


<script>

 

$(document).ready(function() {

  $('#fechaVencimientoCartaMedica').datepicker({

    format: 'yyyy-mm-dd',

    language: 'es',

    autoclose: true,

    todayHighlight: true,

    todayBtn: true,

    forceParse: true

  });

});

</script>


<script>
$(document).ready(function() {

  $('#fechaVencimientoCertificadoManejo').datepicker({

    format: 'yyyy-mm-dd',

    language: 'es',

    autoclose: true,

    todayHighlight: true,

    todayBtn: true,

    forceParse: true

  });

});

</script>
<script>
$(document).ready(function() {

  $('#fechaVencimientoLicencia').datepicker({

    format: 'yyyy-mm-dd',

    language: 'es',

    autoclose: true,

    todayHighlight: true,

    todayBtn: true,

    forceParse: true

  });

});

</script>

<div class="modal fade" id="modalSubirCertificadoManejo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Subir certificado de manejo</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <form method="post" enctype="multipart/form-data">

          <div class="form-group">

            <label for="fechaVencimientoCertificadoManejo">Fecha de vencimiento del certificado de manejo:</label>

            <input type="date" class="form-control" id="fechaVencimientoCertificadoManejo" name="fechaVencimientoCertificadoManejo" required>

          </div>

          <div class="form-group">

            <label for="certificadoManejo">Selecciona el certificado de manejo:</label>

            <input type="file" class="form-control" id="certificadoManejo" name="certificadoManejo" required>

          </div>

          <input type="hidden" id="idTrabajador" name="idTrabajador">

          <button type="submit" class="btn btn-primary">Guardar</button>

        </form>

      </div>

    </div>

  </div>

</div>



<div id="modalActualizarTrabajador" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" id="editarTrabajadorForm" enctype="multipart/form-data">
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Editar trabajador</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <!-- ID del trabajador (oculto) -->
            <input type="hidden" id="idTrabajadorEditar" name="idTrabajadorEditar" value="">
            <!-- Nombre del trabajador -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control input-lg" name="nombreEditar" id="nombreEditar" placeholder="Ingresar nombre" required>
              </div>
            </div>
            <!-- Correo del trabajador -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control input-lg" name="correoEditar" id="correoEditar" placeholder="Ingresar correo" required>
              </div>
            </div>
            <!-- Cargo del trabajador -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                <input type="text" class="form-control input-lg" name="cargoEditar" id="cargoEditar" placeholder="Ingresar cargo" required>
              </div>
            </div>
            <!-- Fecha de nacimiento del trabajador -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="date" class="form-control input-lg" name="fechaNacimientoEditar" id="fechaNacimientoEditar" placeholder="Ingresar fecha de nacimiento" required>
              </div>
            </div>
            <!-- Dirección del trabajador -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                <input type="text" class="form-control input-lg" name="direccionEditar" id="direccionEditar" placeholder="Ingresar dirección" required>
              </div>
            </div>
            <!-- Foto del trabajador -->
            <div class="form-group">
              <div class="panel">SUBIR FOTO</div>
              <input type="file" class="n-file" name="fotoEditar" id="fotoEditar">
              <p class="help-block">Peso máximo de la foto: 2MB</p>
              <img src="" class="img-thumbnail" width="100px" id="fotoEditarPreview">
            </div>
            <!-- Carta médica del trabajador -->
            <div class="form-group">
              <div class="panel">SUBIR CARTA MÉDICA</div>
              <input type="file" class="n-file" name="cartaMedicaEditar" id="cartaMedicaEditar">
              <p class="help-block">Peso máximo de la carta médica: 2MB</p>
            </div>
            <!-- Certificado de manejo del trabajador -->
            <div class="form-group">
              <div class="panel">SUBIR CERTIFICADO DE MANEJO</div>
              <input type="file" class="n-file" name="certificadoManejoEditar" id="certificadoManejoEditar">
              <p class="help-block">Peso máximo del certificado de manejo: 2MB</p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
           <?php
      $editarTrabajador = new ControladorTrabajadores();
      $editarTrabajador->ctrActualizarTrabajador();
      ?>  
      </form>
    </div>
  </div>
</div>