<?php
if ($_SESSION["perfil"] == "Vendedor") {
    echo '<script>
  
      window.location = "inicio";
  
    </script>';

    return;
} ?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Administrar unidades
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar unidades</li>
    </ol>
  </section>
  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUnidad">
        Agregar unidad
        </button>
      </div>


      <div class="input-group">
        <button type="button" class="btn btn-default" id="daterange-btn2">
        <span>
        <i class="fa fa-calendar"></i> 
        <?php if (isset($_GET["fechaInicial"])) {
            echo $_GET["fechaInicial"] . " - " . $_GET["fechaFinal"];
        } else {
            echo 'Rango de fecha';
        } ?>
        </span>
        <i class="fa fa-caret-down"></i>
        </button>
      </div>
      <div class="box-tools pull-right">
        <?php if (isset($_GET["fechaInicial"])) {
            echo '<a href="vistas/modulos/descargar-reporteproduc.php?reporte=reporte&fechaInicial=' . $_GET["fechaInicial"] . '&fechaFinal=' . $_GET["fechaFinal"] . '">';
        } else {
            echo '<a href="vistas/modulos/descargar-reporteproduc.php?reporte=reporte">';
        } ?>
        <button class="btn btn-success" style="margin-top:5px">Descargar reporte en Excel</button>
      </a>
        <br>
       </div>
       <br>
      

    <div class="box-body">

      <br>
    <input id="Date_search" type="text" placeholder="Buscar por fecha" /><br />
      <table class="table table-bordered table-striped dt-responsive tablaUnidades" width="100%">
        <thead>
          <tr>
            <th style="width:10px">#</th>
            <th>Imagen</th>
            <th>Nro Unidad</th>
            <th>Marca</th>
            <th>Operador</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Km Salida</th>
            <th>Hrs Salida</th>
            <th>Km Llegada</th>
            <th>Hrs Llegada</th>
            <th>Km Recorrido</th>
            <th>Cantidad Pasajeros</th>
            <th>Observacion</th>
            <th>Agregado</th>

            <th>Acciones</th>



          </tr>
        </thead>
       

<tbody>

             
      <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto">
        </tbody>

        

         </table>
    </div>
</div>
</section>
</div>

<!--=====================================
  MODAL AGREGAR UNIDAD
  ======================================-->
<div id="modalAgregarUnidad" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" id="kilometerForm" enctype="multipart/form-data">
        <!--=====================================
          CABEZA DEL MODAL
          ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar unidad</h4>
        </div>
        <!--=====================================
          CUERPO DEL MODAL
          ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA SELECCIONAR MARCA -->

                            <div class="form-group">

                  <label for="nuevaMarca">Marca:</label>

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-bus"></i></span> 

                    <select class="form-control input-lg" id="nuevaMarca" name="nuevaMarca" required>

                      <option value="">Seleccionar Marca</option>

                      <?php

                      $item = null;

                      $valor = null;


                      $marcas = ControladorMarcas::ctrMostrarMarcas($item, $valor);


                      foreach ($marcas as $key => $value) {

                          echo '<option value="' . $value["marca"] . '">' . $value["marca"] . '</option>';

                      }

                      ?>

                    </select>

                  </div>

                </div>
            <!-- ENTRADA PARA EL CÓDIGO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 
                <input type="text" class="form-control input-lg" id="nuevoCodigo" name="nuevoCodigo" placeholder="Ingresar Unidad" required onblur="validarNroUnidad(this, 'alertaUnidad')">
              </div>
              <div id="alertaUnidad" class="text-danger"></div>
            </div>

            <!-- ENTRADA PARA SELECCIONAR OPERADOR -->
          

            <div class="form-group">

              <label for="nuevoOperador">Operador:</label>

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <select class="form-control input-lg" id="nuevoOperador" name="nuevoOperador" required>

                  <option value="">Seleccionar Operador</option>

                  <?php

                  $item = null;

                  $valor = null;


                  $operadores = ControladorOperadores::ctrMostrarOperadores($item, $valor);


                  foreach ($operadores as $key => $value) {

                      echo '<option value="' . $value["operador"] . '">' . $value["operador"] . '</option>';

                  }

                  ?>

                </select>

              </div>

            </div>








            <br>
            <!-- ENTRADA PARA SELECCIONAR ORIGEN -->
        

            <div class="form-group">

              <label for="nuevoOrigen">Origen:</label>

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-road"></i></span> 

                <select class="form-control input-lg" id="nuevoOrigen" name="nuevoOrigen" required>

                  <option value="">Seleccionar Origen</option>

                  <?php

                  $item = null;

                  $valor = null;


                  $origenes = ControladorOrigenes::ctrMostrarOrigenes($item, $valor);


                  foreach ($origenes as $key => $value) {

                      echo '<option value="' . $value["origen"] . '">' . $value["origen"] . '</option>';

                  }

                  ?>

                </select>

              </div>

            </div>



           

            <div class="form-group">

              <label for="nuevoDestino">Destino:</label>

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-road"></i></span> 

                <select class="form-control input-lg" id="nuevoDestino" name="nuevoDestino" required>

                  <option value="">Seleccionar Destino</option>

                  <?php

                  $item = null;

                  $valor = null;


                  $destinos = ControladorDestinos::ctrMostrarDestinos($item, $valor);


                  foreach ($destinos as $key => $value) {

                      echo '<option value="' . $value["destino"] . '">' . $value["destino"] . '</option>';

                  }

                  ?>

                </select>

              </div>

            </div>
            <!-- ENTRADA PARA KM SALIDA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span> 
                <input type="text" class="form-control input-lg" id="nuevokmsal" name="nuevokmsalida" placeholder="KM SALIDA" pattern="[0-9]{0,6}" max="6"  maxlength="6" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 
                <input type="time" class="form-control input-lg" name="nuevahrsSalida" placeholder="HRS SALIDA" required>
              </div>
            </div>
            <br>
            <!-- ENTRADA PARA KM LLEGADA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span> 
                <input type="text" class="form-control input-lg" id="nuevokmlle" name="nuevokmllegada" placeholder="KM LLEGADA"  pattern="[0-9]{0,6}" max="6" maxlength="6" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 
                <input type="time" class="form-control input-lg" name="nuevahrsLlegada" placeholder="HRS LLEGADA" required>
              </div>
            </div>
            <!-- ENTRADA PARA LA KM RECORRIDO -->

                <input type="hidden" class="form-control input-lg" value="0" name="nuevokmRecorrido" placeholder="Ingresar km recorrido" required>
      
            <!-- ENTRADA PARA CANT. PASAJEROS -->
            <div class="form-group">
              <div class="input-group">         
                <span class="input-group-addon"><i class="fa fa-users"></i></span> 
            <input type="number" class="form-control input-lg" name="nuevocantPasajeros" min="0" pattern="[0-9]{0,3}" placeholder="Ingrese cantidad de pasajeros" required onblur="validarCantPasajeros(this)">
              </div>
              <div id="alertaCantPasajeros" class="text-danger"></div>

              </div>
               <div class="form-group"> 
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-sticky-note"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevaObservacion" placeholder="Ingresar observacion" required>
              </div>
            </div>
    
            <!-- ENTRADA PARA PRECIO COMPRA -->

            <input type="hidden" class="form-control input-lg" id="nuevoPrecioCompra" name="nuevoPrecioCompra" value="0" step="any" min="0" placeholder="Precio de compra" required>
       
            <input type="hidden" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" value="0" step="any" min="0" placeholder="Precio de venta" required>
    
            <input type="hidden" class="minimal porcentaje" checked>
        
            <input type="hidden" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
    
            <!-- ENTRADA PARA SUBIR FOTO -->
            <div class="form-group">
              <div class="panel">SUBIR IMAGEN</div>
              <input type="file" class="nuevaImagen" name="nuevaImagen">
              <p class="help-block">Peso máximo de la imagen 2MB</p>
              <img src="vistas/img/unidades/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
            </div>
          </div>
        </div>
        <!--=====================================
          PIE DEL MODAL
          ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar unidad</button>
        </div>
      
      <?php
      $crearUnidad = new ControladorUnidades();
      $crearUnidad->ctrCrearUnidad();
      ?>  
      </form>
    </div>
  </div>
</div>
<!--=====================================
  MODAL EDITAR UNIDAD
  ======================================-->
<div id="modalEditarUnidad" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
  <form role="form" method="post" enctype="multipart/form-data">
    <!--=====================================
      CABEZA DEL MODAL
      ======================================-->
    <div class="modal-header" style="background:#3c8dbc; color:white">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Editar unidad</h4>
    </div>
    <!--=====================================
      CUERPO DEL MODAL
      ======================================-->
    <div class="modal-body">
      <div class="box-body">
     <!-- ENTRADA PARA SELECCIONAR MARCA -->


 <div class="form-group">

  <label for="editarMarca">Editar marca:</label>

  <div class="input-group">

    <span class="input-group-addon"><i class="fa fa-user"></i></span>

    <select class="form-control input-lg" id="editarMarca" name="editarMarca" required>

      <option value="">Seleccionar Marca</option>

      <?php

      $item = null;

      $valor = null;


      $marcas = ControladorMarcas::ctrMostrarMarcas($item, $valor);


      foreach ($marcas as $key => $value) {

          echo '<option value="' . $value["marca"] . '">' . $value["marca"] . '</option>';

      }

      ?>

    </select>

  </div>

</div>




        <!-- ENTRADA PARA EL CÓDIGO -->
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-code"></i></span> 
            <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo" required>
          </div>
        </div>
        <!-- ENTRADA PARA SELECCIONAR OPERADOR -->
     <div class="form-group">

  <label for="editarOperador">Operador:</label>

  <div class="input-group">

    <span class="input-group-addon"><i class="fa fa-user"></i></span>

    <select class="form-control input-lg" id="editarOperador" name="editarOperador" required>

      <option value="">Seleccionar Operador</option>

      <?php

      $item = null;

      $valor = null;


      $operadores = ControladorOperadores::ctrMostrarOperadores($item, $valor);


      foreach ($operadores as $key => $value) {

          echo '<option value="' . $value["operador"] . '">' . $value["operador"] . '</option>';

      }

      ?>

    </select>

  </div>

</div>
        <!-- ENTRADA PARA SELECCIONAR ORIGEN -->
        <div class="form-group">

  <label for="editarOrigen">Origen:</label>

  <div class="input-group">

    <span class="input-group-addon"><i class="fa fa-road"></i></span>

    <select class="form-control input-lg" id="editarOrigen" name="editarOrigen" required>

      <option value="">Seleccionar Origen</option>

      <?php

      $item = null;

      $valor = null;


      $origenes = ControladorOrigenes::ctrMostrarOrigenes($item, $valor);


      foreach ($origenes as $key => $value) {

          echo '<option value="' . $value["origen"] . '">' . $value["origen"] . '</option>';

      }

      ?>

    </select>

  </div>

</div>
        <!-- ENTRADA PARA SELECCIONAR DESTINO -->
    <div class="form-group">

  <label for="editarDestino">Destino:</label>

  <div class="input-group">

    <span class="input-group-addon"><i class="fa fa-road"></i></span>

    <select class="form-control input-lg" id="editarDestino" name="editarDestino" required>

      <option value="">Seleccionar Destino</option>

      <?php

      $item = null;

      $valor = null;


      $destinos = ControladorDestinos::ctrMostrarDestinos($item, $valor);


      foreach ($destinos as $key => $value) {

          echo '<option value="' . $value["destino"] . '">' . $value["destino"] . '</option>';

      }

      ?>

    </select>

  </div>

</div>
        <!-- ENTRADA PARA KM SALIDA -->
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span> 
            <input type="text" class="form-control input-lg" id="editarkmsalida" name="editarkmsalida" pattern="[0-9]{0,6}"  max="6" maxlength="6" required>
          </div>
        </div>
        <br>
        <!-- ENTRADA PARA HRS SALIDA -->
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 
            <input type="time" class="form-control input-lg" id="editarhrsSalida" name="editarhrsSalida" required>
          </div>
        </div>
        <br>
        <!-- ENTRADA PARA EL KM LLEGADA -->         
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span> 
            <input type="text" class="form-control input-lg" id="editarkmllegada" name="editarkmllegada" pattern="[0-9]{0,6}"  max="6" maxlength="6" required>
          </div>
        </div>
          <br>
          <!-- ENTRADA PARA EL HRS LLEGADA -->        
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 
              <input type="time" class="form-control input-lg" id="editarhrsLlegada" name="editarhrsLlegada" required>
            </div>
          </div>
            <br>
            <!-- ENTRADA PARA LA KM RECORRIDO -->
            <!--div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span--> 
                <input type="hidden" class="form-control input-lg" id="editarkmRecorrido" value = "0" name="editarkmRecorrido" required>
              <!--/div>
            </div-->
          

    <!-- ENTRADA PARA CANT. PASAJEROS -->
            <div class="form-group">
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-users"></i></span> 
            <input type="number" class="form-control input-lg" id="editarcantPasajeros" name="editarcantPasajeros" min="0" pattern="[0-9]{0,3}" placeholder="Ingrese cantidad de pasajeros" required>
           
              </div>
              
              </div>

            <br>

            <!-- ENTRADA PARA OBSERVACION -->
               <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-sticky-note"></i></span> 

                <input type="text" class="form-control input-lg" id="editarObservacion" name="editarObservacion" placeholder="Ingresar observacion" required>

              </div>

            </div>
            <br>


            <!-- ENTRADA PARA PRECIO COMPRA -->
            <input type="hidden" class="form-control input-lg" value="0" id="editarPrecioCompra" name="editarPrecioCompra" step="any" min="0" required>
            <!-- ENTRADA PARA PRECIO VENTA -->
            <input type="hidden" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" value="0" step="any" min="0" readonly required>
            <!-- CHECKBOX PARA PORCENTAJE -->
            <input type="hidden" class="minimal porcentaje" checked>
            <!-- ENTRADA PARA PORCENTAJE -->
            <input type="hidden" class="form-control input-lg nuevoPorcentaje" min="0" value="40" required>
            <!-- ENTRADA PARA SUBIR FOTO -->
            <div class="form-group">
              <div class="panel">SUBIR IMAGEN</div>
              <input type="file" class="nuevaImagen" name="editarImagen">
              <p class="help-block">Peso máximo de la imagen 2MB</p>
              <img src="vistas/img/unidades/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
              <input type="hidden" name="imagenActual" id="imagenActual">
            </div>
          </div>
     
        <!--=====================================
          PIE DEL MODAL
          ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </div>

  <?php
  $editarUnidad = new ControladorUnidades();
  $editarUnidad->ctrEditarUnidad();
  ?>     
      </form> 
  </div>
  </div>
</div>
<?php
$eliminarUnidad = new ControladorUnidades();
$eliminarUnidad->ctrEliminarUnidad();


?>
