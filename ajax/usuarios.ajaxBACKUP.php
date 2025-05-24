<?php
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";
/*require_once "../controladores/unidades.controlador.php";
require_once "../modelos/unidades.modelo.php";
require_once "../controladores/marcas.controlador.php";
require_once "../modelos/marcas.modelo.php";
require_once "../modelos/operadores.modelo.php";
require_once "../modelos/origenes.modelo.php";
require_once "../modelos/destinos.modelo.php";*/

/*
class AjaxUnidades{


  public $idMarca;

  public function ajaxCrearCodigoUnidad(){

    $item = "id_marca";
    $valor = $this->idMarca;
    $orden = "id";

    $respuesta = ControladorUnidades::ctrMostrarUnidades($item, $valor, $orden);

    echo json_encode($respuesta);

  }




  public $idUnidad;
  public $traerUnidades;
  public $nombreUnidad;

  public function ajaxEditarUnidad(){

    if($this->traerUnidades == "ok"){

      $item = null;
      $valor = null;
      $orden = "id";

      $respuesta = ControladorUnidades::ctrMostrarUnidades($item, $valor,
        $orden);

      echo json_encode($respuesta);


    }else if($this->nombreUnidad != ""){

      $item = "codigo";
      $valor = $this->nombreUnidad;
      $orden = "id";

      $respuesta = ControladorUnidades::ctrMostrarUnidades($item, $valor,
        $orden);

      echo json_encode($respuesta);

    }else{

      $item = "id";
      $valor = $this->idUnidad;
      $orden = "id";

      $respuesta = ControladorUnidades::ctrMostrarUnidades($item, $valor,
        $orden);

      echo json_encode($respuesta);

    }

  }



  public $idUnidadEliminar;

  public function ajaxEliminarUnidad(){

    $item = "id";
    $valor = $this->idUnidadEliminar;

    $respuesta = ControladorUnidades::ctrEliminarUnidad($item, $valor);

    echo json_encode($respuesta);

  }

}



if(isset($_POST["idMarca"])){

  $codigoUnidad = new AjaxUnidades();
  $codigoUnidad -> idMarca = $_POST["idMarca"];
  $codigoUnidad -> ajaxCrearCodigoUnidad();

}



if(isset($_POST["idUnidad"])){

  $editarUnidad = new AjaxUnidades();
  $editarUnidad -> idUnidad = $_POST["idUnidad"];
  $editarUnidad -> ajaxEditarUnidad();

}



if(isset($_POST["traerUnidades"])){

  $traerUnidades = new AjaxUnidades();
  $traerUnidades -> traerUnidades = $_POST["traerUnidades"];
  $traerUnidades -> ajaxEditarUnidad();

}



if(isset($_POST["nombreUnidad"])){

  $traerUnidades = new AjaxUnidades();
  $traerUnidades -> nombreUnidad = $_POST["nombreUnidad"];
  $traerUnidades -> ajaxEditarUnidad();

}


if(isset($_POST["idUnidadEliminar"])){

  $eliminarUnidad = new AjaxUnidades();
  $eliminarUnidad -> idUnidadEliminar = $_POST["idUnidadEliminar"];
  $eliminarUnidad -> ajaxEliminarUnidad();

}

*/

class AjaxUsuarios{

  /*=============================================
  EDITAR USUARIO
  =============================================*/ 

  public $idUsuario;

  public function ajaxEditarUsuario(){

    $item = "id";
    $valor = $this->idUsuario;

    $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

    echo json_encode($respuesta);

  }

  /*=============================================
  ACTIVAR USUARIO
  =============================================*/ 

  public $activarUsuario;
  public $activarId;


  public function ajaxActivarUsuario(){

    $tabla = "usuarios";

    $item1 = "estado";
    $valor1 = $this->activarUsuario;

    $item2 = "id";
    $valor2 = $this->activarId;

    $respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

  }

  /*=============================================
  VALIDAR NO REPETIR USUARIO
  =============================================*/ 

  public $validarUsuario;

  public function ajaxValidarUsuario(){

    $item = "usuario";
    $valor = $this->validarUsuario;

    $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

    echo json_encode($respuesta);

  }
}

/*=============================================
EDITAR USUARIO
=============================================*/
if(isset($_POST["idUsuario"])){

  $editar = new AjaxUsuarios();
  $editar -> idUsuario = $_POST["idUsuario"];
  $editar -> ajaxEditarUsuario();

}

/*=============================================
ACTIVAR USUARIO
=============================================*/ 

if(isset($_POST["activarUsuario"])){

  $activarUsuario = new AjaxUsuarios();
  $activarUsuario -> activarUsuario = $_POST["activarUsuario"];
  $activarUsuario -> activarId = $_POST["activarId"];
  $activarUsuario -> ajaxActivarUsuario();

}

/*=============================================
VALIDAR NO REPETIR USUARIO
=============================================*/

if(isset( $_POST["validarUsuario"])){

  $valUsuario = new AjaxUsuarios();
  $valUsuario -> validarUsuario = $_POST["validarUsuario"];
  $valUsuario -> ajaxValidarUsuario();

}