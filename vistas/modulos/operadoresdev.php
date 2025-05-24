<?php
if($_SESSION["perfil"] == "Vendedor"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar operadores
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar operadores</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary btnAgregarOperador">
          
          Agregar operador

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>operador</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $operadores = ControladorOperadores::ctrMostrarOperadores($item, $valor);

          foreach ($operadores as $key => $value) {
           
            echo ' <tr>

                    <td>'.($key+1).'</td>

                    <td class="text-uppercase">'.$value["operador"].'</td>

                    <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarOperador" idOperador="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarOperador"><i class="fa fa-pencil"></i></button>';

                        if($_SESSION["perfil"] == "Administrador"){

                          echo '<button class="btn btn-danger btnEliminarOperador" idOperador="'.$value["id"].'"><i class="fa fa-times"></i></button>';

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
MODAL AGREGAR operador
======================================-->

<div id="modalAgregarOperador" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar operador</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoOperador" id="nuevaOperador" placeholder="Ingresar operador" required>

              </div>

            </div>
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="button" class="btn btn-primary btnAgregarNuevoOperador">Guardar operador</button>

        </div>

      </form>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR operador
======================================-->

<div id="modalEditarOperador" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar operador</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <input type="text" class="form-control input-lg" name="editarOperador" id="editarOperador" required>

                 <input type="hidden"  name="idOperador" id="idOperador" required>

              </div>

            </div>
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="button" class="btn btn-primary btnEditarOperadorAjax">Guardar cambios</button>

        </div>

      </form>

    </div>

  </div>

</div>

<script>

$(document).ready(function(){

  // Agregar un nuevo operador
  $(".btnAgregarOperador").click(function(){

    $("#modalAgregarOperador").modal("show");

  });

  // Enviar el formulario de agregar un nuevo operador
  $(".btnAgregarNuevoOperador").click(function(){

    // Obtener los datos del formulario
    var nuevoOperador = $("#nuevoOperador").val();

    // Enviar los datos al servidor
    $.ajax({

      type: "POST",
      url: "ajax/operadores.ajax.php",
      data: { nuevoOperador: nuevoOperador },
      success: function(respuesta){

        if(respuesta == "ok"){

          // Cerrar el modal
          $("#modalAgregarOperador").modal("hide");

          // Mostrar la tabla actualizada
          cargarTablaOperadores();

        } else {

          alert("Error al agregar el operador");

        }

      }

    });

  });

  // Editar un operador
  $(".btnEditarOperador").click(function(){

    // Obtener el ID del operador
    var idOperador = $(this).attr("idOperador");

    // Enviar el ID al servidor
    $.ajax({

      type: "POST",
      url: "ajax/operadores.ajax.php",
      data: { idOperador: idOperador },
      success: function(respuesta){

        // Convertir la respuesta en un objeto
        var operador = JSON.parse(respuesta);

        // Llenar los campos del formulario
        $("#editarOperador").val(operador.operador);
        $("#idOperador").val(operador.id);

      }

    });

  });

  // Enviar el formulario de editar un operador
  $(".btnEditarOperadorAjax").click(function(){

    // Obtener los datos del formulario
    var idOperador = $("#idOperador").val();
    var editarOperador = $("#editarOperador").val();

    // Enviar los datos al servidor
    $.ajax({

      type: "POST",
      url: "ajax/operadores.ajax.php",
      data: { idOperador: idOperador, editarOperador: editarOperador },
      success: function(respuesta){

        if(respuesta == "ok"){

          // Cerrar el modal
          $("#modalEditarOperador").modal("hide");

          // Mostrar la tabla actualizada
          cargarTablaOperadores();

        } else {

          alert("Error al editar el operador");

        }

      }

    });

  });

  // Eliminar un operador
  $(".btnEliminarOperador").click(function(){

    // Obtener el ID del operador
    var idOperador = $(this).attr("idOperador");

    // Enviar el ID al servidor
    $.ajax({

      type: "POST",
      url: "ajax/operadores.ajax.php",
      data: { idOperador: idOperador },
      success: function(respuesta){

        if(respuesta == "ok"){

          // Mostrar la tabla actualizada
          cargarTablaOperadores();

        } else {

          alert("Error al eliminar el operador");

        }

      }

    });

  });

  // Función para cargar la tabla de operadores
  function cargarTablaOperadores(){

    // Enviar la solicitud al servidor
    $.ajax({

      type: "GET",
      url: "ajax/operadores.ajax.php",
      success: function(respuesta){

        // Convertir la respuesta en un objeto
        var operadores = JSON.parse(respuesta);

        // Limpiar el tbody de la tabla
        $("tbody").html("");

        // Recorrer el arreglo de operadores
        for(var i = 0; i < operadores.length; i++){

          // Obtener el ID del operador
          var idOperador = operadores[i]["id"];

          // Obtener el nombre del operador
          var operador = operadores[i]["operador"];

          // Agregar una fila a la tabla
          $("tbody").append("<tr>" +
                            "<td>" + (i+1) + "</td>" +
                            "<td>" + operador + "</td>" +
                            "<td>" +
                              "<button class='btn btn-warning btnEditarOperador' idOperador='" + idOperador + "' data-toggle='modal' data-target='#modalEditarOperador'><i class='fa fa-pencil'></i></button>" +
                              "<button class='btn btn-danger btnEliminarOperador' idOperador='" + idOperador + "'><i class='fa fa-times'></i></button>" +
                            "</td>" +
                          "</tr>");

        }

      }

    });

  }

});

</script>