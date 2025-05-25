<?php
/*header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json");*/


/*$url = "http://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json";*/
$url = "/node_modules/datatable/DataTables/js/es-ES.json";
/*$response = file_get_contents($url);

echo $response;*/

/*

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}*/


?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar pasajeros
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar pasajeros</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarPasajero">
          
          Agregar pasajero

        </button>

            <div class="box-tools pull-right">
        <?php 
            $download_url = "index.php?ruta=reporte-pasajeros";
            if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {
               $download_url .= "&reporte=reporte"; // Keep existing 'reporte' parameter for compatibility
               $download_url .= "&fechaInicial=" . urlencode($_GET["fechaInicial"]) . "&fechaFinal=" . urlencode($_GET["fechaFinal"]);
            } elseif (isset($_GET["reportep"])){ 
               $download_url .= "&reportep=" . urlencode($_GET["reportep"]);
            }
            // Fallback if neither date range nor specific reportep is set, can default to all or a specific flag
            // For now, if nothing is set, it will just be index.php?ruta=reporte-pasajeros which implies all data by default in the controller.
            // If the controller strictly requires 'reportep=reportep' for all data, add:
            // else { $download_url .= "&reportep=reportep"; } 

            echo '<a href="' . $download_url . '">';
        ?>
        <button class="btn btn-success" style="margin-top:5px">Descargar reporte en Excel</button>
      </a>
        <br>
         <br>
       </div>

      </div>

   
    

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
          <th>Ruta</th>
           <th>Nombre</th>
           <th>Cedula</th>
           <th>Gerencia</th>
           <th>Fecha</th>
           <th>Estado</th> 
           <!--th>-</th>
           <th>-</th-->
           <th>Ingreso al sistema</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $pasajeros = ControladorPasajeros::ctrMostrarPasajeros($item, $valor);


          foreach ($pasajeros as $key => $value) {
            

            echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.htmlspecialchars($value["nroUnidad"], ENT_QUOTES, 'UTF-8').'</td>

                    <td>'.htmlspecialchars($value["nombre"], ENT_QUOTES, 'UTF-8').'</td>

                    <td>'.htmlspecialchars($value["documento"], ENT_QUOTES, 'UTF-8').'</td>

                    <td>'.htmlspecialchars($value["gerencia"], ENT_QUOTES, 'UTF-8').'</td>

                    

                    <td>'.htmlspecialchars($value["fecha_c"], ENT_QUOTES, 'UTF-8').'</td>';

              /*echo '<td>'.$value["perfil"].'</td>';*/

                  if($value["estado"] != 0){

                    echo '<td><button class="btn btn-success btn-xs btnActivar" idPasajero="'.htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8').'" estadoPasajero="0">Activado</button></td>';

                  }else{

                    echo '<td><button class="btn btn-danger btn-xs btnActivar" idPasajero="'.htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8').'" estadoPasajero="1">Desactivado</button></td>';

                  }   


              


                    echo '<td>'.htmlspecialchars($value["fecha"], ENT_QUOTES, 'UTF-8').'</td>

                    <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarPasajero" data-toggle="modal" data-target="#modalEditarPasajero" idPasajero="'.htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8').'"><i class="fa fa-pencil"></i></button>';

                      if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-danger btnEliminarPasajero" idPasajero="'.htmlspecialchars($value["id"], ENT_QUOTES, 'UTF-8').'"><i class="fa fa-times"></i></button>';

                      }

                      echo '</div>  

                    </td>

                  </tr>';
          
            }

        ?>
   
        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR PASAJERO
======================================-->

<div id="modalAgregarPasajero" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" id="formAgregarPasajero">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar pasajero</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <!--div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoPasajero" placeholder="Ingresar nombre" required>

              </div>

            </div-->

            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" min="0" class="form-control input-lg" id="nuevoDocumentoId" name="nuevoDocumentoId" placeholder="Ingresar documento" required onblur="validarDocumentoId(this)">



              </div>
              <div id="alertaDocumentoId" class="text-danger"></div>

            </div>

<script type="text/javascript">
         $(document).ready(function() {
          
              $("#nuevoDocumentoId").on("keyup", function() {
                var documento =$(this).val();
                /*var gerencia =$(#nuevaGerencia).val();*/
                /*if (documento <> ''){*/
                  $.ajax({
                    url: "ajax/documentojs.php",
                    method: "POST",
                    data:{
                      'accion': 'obtenerNombre',
                      'doc':documento,
                    },
                    success: function(respuesta){
                      $("#nuevoPasajero").val(respuesta);
                      /*$("#nuevaGerencia").val(respuesta);*/
                    }
                  });
                /*}*/
              });
            });
</script>

<script type="text/javascript">
         $(document).ready(function() {
          
              $("#nuevoDocumentoId").on("keyup", function() {
                var documento =$(this).val();
            
                  $.ajax({
                    url: "ajax/documentojs.php",
                    method: "POST",
                    data:{
                      'accion': 'obtenerGerencia',
                      'doc':documento,
                    },
                    success: function(respuesta){
                      $("#nuevaGerencia").val(respuesta);
                     
                    }
                  });
    
              });
            });
</script>

             <!-- ENTRADA NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" min="0" class="form-control input-lg" id="nuevoPasajero" name="nuevoPasajero" placeholder="Ingresar nombre" required onblur="validarNombre(this)">

              </div>
              <div id="alertaNombre" class="text-danger"></div>

            </div>


               <!-- ENTRADA gerencia -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-building-o"></i></span> 

               <input type="text" class="form-control input-lg" id="nuevaGerencia" name="nuevaGerencia" placeholder="Ingresar Gerencia" required onblur="validarGerencia(this, 'alertaGerencia')">



              </div>

                  <div id="alertaGerencia" class="alerta-campo"></div>

            </div>
           

            <!-- ENTRADA PARA NRO UNIDAD -->
            
            <!--div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-bus"></i></span> 

                <input type="text" class="form-control input-lg" id="nuevoNroUnidad" name="nuevoNroUnidad" placeholder="Ingresar Ruta" required onblur="validarNroUnidad(this, 'alertaUnidad')">

    

              </div>
              <div id="alertaUnidad" class="alerta-campo"></div>

            </div-->


            <div class="form-group">

  <div class="input-group">

    <span class="input-group-addon"><i class="fa fa-bus"></i></span>

  <select class="form-control input-lg" id="nuevoNroUnidad" name="nuevoNroUnidad" placeholder="Ingresar Ruta" required onblur="validarNroUnidad(this, 'alertaUnidad')">
  <option value="">Seleccione una ruta</option>
  <option value="CABIMAS CVP 01-- LAGUNILLAS">CABIMAS CVP 01-- LAGUNILLAS</option>
  <option value="CABIMAS CVP 02-- LAGUNILLAS">CABIMAS CVP 02-- LAGUNILLAS</option>
  <option value="TTCC LA SALINA -- LAGUNILLAS">TTCC LA SALINA -- LAGUNILLAS</option>
  <option value="CABIMAS CVP -- TIA JUANA TAMARE">CABIMAS CVP -- TIA JUANA TAMARE</option>
  <option value="CABIMAS -- MENE GRANDE">CABIMAS -- MENE GRANDE</option>
  <option value="SANTA RITA -- LAGUNILLAS - MENITO">SANTA RITA -- LAGUNILLAS - MENITO</option>
  <option value="LOS PUERTOS -- LAGUNILLAS">LOS PUERTOS -- LAGUNILLAS</option>
  <option value="LOS PUERTOS ALTAGRACIA-- PUERTO MIRANDA">LOS PUERTOS ALTAGRACIA-- PUERTO MIRANDA</option>
  <option value="LAGO MEDIO -- LAGUNILLAS">LAGO MEDIO -- LAGUNILLAS</option>
  <option value="MIRANDA -- MENITO">MIRANDA -- MENITO</option>
  <option value="MARACAIBO INTERNO">MARACAIBO INTERNO</option>
  <option value="BACHAQUERO -- LA SALINA">BACHAQUERO -- LA SALINA</option>
  <option value="ZULIMA -- TTCC  SALINA">ZULIMA -- TTCC  SALINA</option>
  <option value="C. OJEDA -- MIRANDA - CENTRO PETROLERO">C. OJEDA -- MIRANDA - CENTRO PETROLERO</option>
  <option value="LAGUNILLAS--MIRANDA- EDIF 5 DE JULIO">LAGUNILLAS--MIRANDA- EDIF 5 DE JULIO</option>
  <option value="MARACAIBO -- MINPET">MARACAIBO -- MINPET</option>
  <option value="MENE GRANDE -- MENITO">MENE GRANDE -- MENITO</option>
  <option value="FABRICIO OJEDA -- MENE GRANDE">FABRICIO OJEDA -- MENE GRANDE</option>
  <option value="AMARILLO 1 MENE GRANDE- BARUA LA CEIBA 6X">AMARILLO 1 MENE GRANDE- BARUA LA CEIBA 6X</option>
  <option value="AMARILLO 2 MENE GRANDE- BARROSO - PUEBLO NUEVO - SAN LORENZO">AMARILLO 2 MENE GRANDE- BARROSO - PUEBLO NUEVO - SAN LORENZO</option>
</select>

  </div>

  <div id="alertaUnidad" class="alerta-campo"></div>

</div>


















             <!-- ENTRADA PARA LA FECHA -->
            
            <!--div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaFechaC" placeholder="Ingresar fecha" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>

              </div>

            </div-->

        <div class="form-group">

  <div class="input-group">

    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

    <input type="text" id="datepicker" class="form-control input-lg" name="nuevaFechaC" placeholder="Ingresar fecha" required>

  </div>

</div>

<script>

  $(function() {

    $('[name="nuevaFechaC"]').datepicker({

      format: 'yyyy/mm/dd',

      language: 'es',

      autoclose: true,

      todayHighlight: true

    });

  });

</script>
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar pasajero</button>

        </div>

      </form>

      <?php

        /*
        $crearPasajero = new ControladorPasajeros();
        $crearPasajero -> ctrCrearPasajero();
        */

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR PASAJERO
======================================-->

<div id="modalEditarPasajero" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" id="formEditarPasajero">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar pasajero</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="editarPasajero" id="editarPasajero" required>
                <input type="hidden" id="idPasajero" name="idPasajero">
              </div>

            </div>

            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="editarDocumentoId" id="editarDocumentoId" required>

              </div>

            </div>


            <!-- ENTRADA PARA LA GERENCIA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-building-o"></i></span> 

                <input type="text" min="0" class="form-control input-lg" name="editarGerencia" id="editarGerencia" required>

              </div>

            </div>

            <!-- ENTRADA PARA NRO UNIDAD -->


            <div class="form-group">

  <div class="input-group">

    <span class="input-group-addon"><i class="fa fa-road"></i></span>

<select class="form-control input-lg" name="editarNroUnidad" id="editarNroUnidad" required>
  <option value="">Seleccione una ruta</option>
  <option value="CABIMAS CVP 01-- LAGUNILLAS">CABIMAS CVP 01-- LAGUNILLAS</option>
  <option value="CABIMAS CVP 02-- LAGUNILLAS">CABIMAS CVP 02-- LAGUNILLAS</option>
  <option value="TTCC LA SALINA -- LAGUNILLAS">TTCC LA SALINA -- LAGUNILLAS</option>
  <option value="CABIMAS CVP -- TIA JUANA TAMARE">CABIMAS CVP -- TIA JUANA TAMARE</option>
  <option value="CABIMAS -- MENE GRANDE">CABIMAS -- MENE GRANDE</option>
  <option value="SANTA RITA -- LAGUNILLAS - MENITO">SANTA RITA -- LAGUNILLAS - MENITO</option>
  <option value="LOS PUERTOS -- LAGUNILLAS">LOS PUERTOS -- LAGUNILLAS</option>
  <option value="LOS PUERTOS ALTAGRACIA-- PUERTO MIRANDA">LOS PUERTOS ALTAGRACIA-- PUERTO MIRANDA</option>
  <option value="LAGO MEDIO -- LAGUNILLAS">LAGO MEDIO -- LAGUNILLAS</option>
  <option value="MIRANDA -- MENITO">MIRANDA -- MENITO</option>
  <option value="MARACAIBO INTERNO">MARACAIBO INTERNO</option>
  <option value="BACHAQUERO -- LA SALINA">BACHAQUERO -- LA SALINA</option>
  <option value="ZULIMA -- TTCC  SALINA">ZULIMA -- TTCC  SALINA</option>
  <option value="C. OJEDA -- MIRANDA - CENTRO PETROLERO">C. OJEDA -- MIRANDA - CENTRO PETROLERO</option>
  <option value="LAGUNILLAS--MIRANDA- EDIF 5 DE JULIO">LAGUNILLAS--MIRANDA- EDIF 5 DE JULIO</option>
  <option value="MARACAIBO -- MINPET">MARACAIBO -- MINPET</option>
  <option value="MENE GRANDE -- MENITO">MENE GRANDE -- MENITO</option>
  <option value="FABRICIO OJEDA -- MENE GRANDE">FABRICIO OJEDA -- MENE GRANDE</option>
  <option value="AMARILLO 1 MENE GRANDE- BARUA LA CEIBA 6X">AMARILLO 1 MENE GRANDE- BARUA LA CEIBA 6X</option>
  <option value="AMARILLO 2 MENE GRANDE- BARROSO - PUEBLO NUEVO - SAN LORENZO">AMARILLO 2 MENE GRANDE- BARROSO - PUEBLO NUEVO - SAN LORENZO</option>
</select>

  </div>

</div>


            
<div class="form-group">

  <div class="input-group">

    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

    <input type="text" class="form-control input-lg" name="editarFechaC" id="editarFechaC" required>

  </div>

</div>

<script>

  $(function() {

    $('[name="editarFechaC"]').datepicker({

      format: 'yyyy/mm/dd',

      language: 'es',

      autoclose: true,

      todayHighlight: true

    });

  });

</script>




 </div>

        </div>



        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      </form>

      <?php

        /*
        $editarPasajero = new ControladorPasajeros();
        $editarPasajero -> ctrEditarPasajero();
        */

      ?>

    

    </div>

  </div>

</div>

<?php

  $eliminarPasajero = new ControladorPasajeros();
  $eliminarPasajero -> ctrEliminarPasajero();

?>
