<?php
require_once "../controladores/unidades.controlador.php";
require_once "../modelos/unidades.modelo.php";
require_once "../controladores/marcas.controlador.php";
require_once "../modelos/marcas.modelo.php";
require_once "../modelos/operadores.modelo.php";
require_once "../modelos/origenes.modelo.php";
require_once "../modelos/destinos.modelo.php";

class AjaxUnidades{

  /*=============================================
  GENERAR CÓDIGO A PARTIR DE ID MARCA
  =============================================*/
  public $idMarca;

  public function ajaxCrearCodigoUnidad(){

    $item = "id_marca";
    $valor = $this->idMarca;
    $orden = "id";

    $respuesta = ControladorUnidades::ctrMostrarUnidades($item, $valor, $orden);

    echo json_encode($respuesta);

  }


  /*=============================================
  EDITAR UNIDAD
  =============================================*/ 

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





  /*---------------------------------------------------*/

  /*===========================

  ELIMINAR UNIDAD

  =======================================*/

  /*---------------------------------------------------*/

  /*==================*/

  /*public $idUnidad;*/


  static public function ajaxEliminarUnidad(){


    $idUnidad = $this->idUnidad;


    $respuesta = ControladorUnidades::ctrEliminarUnidad($idUnidad);


    echo json_encode($respuesta);


  }



}











/*=============================================
GENERAR CÓDIGO A PARTIR DE ID MARCA
=============================================*/ 

if(isset($_POST["idMarca"])){

  $codigoUnidad = new AjaxUnidades();
  $codigoUnidad -> idMarca = $_POST["idMarca"];
  $codigoUnidad -> ajaxCrearCodigoUnidad();

}
/*=============================================
EDITAR UNIDAD
=============================================*/ 

if(isset($_POST["idUnidad"])){

  $editarUnidad = new AjaxUnidades();
  $editarUnidad -> idUnidad = $_POST["idUnidad"];
  $editarUnidad -> ajaxEditarUnidad();

}

/*=============================================
TRAER UNIDAD
=============================================*/ 

if(isset($_POST["traerUnidades"])){

  $traerUnidades = new AjaxUnidades();
  $traerUnidades -> traerUnidades = $_POST["traerUnidades"];
  $traerUnidadades -> ajaxEditarUnidad();

}

/*=============================================
TRAER UNIDAD
=============================================*/ 

if(isset($_POST["nombreUnidad"])){

  $traerUnidades = new AjaxUnidades();
  $traerUnidades -> nombreUnidad = $_POST["nombreUnidad"];
  $traerUnidades -> ajaxEditarUnidad();

}






