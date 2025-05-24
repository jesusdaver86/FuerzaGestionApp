<?php
require_once "../controladores/unidades.controlador.php";
require_once "../modelos/unidades.modelo.php";

require_once "../controladores/marcas.controlador.php";
require_once "../modelos/marcas.modelo.php";

require_once "../controladores/operadores.controlador.php";
require_once "../modelos/operadores.modelo.php";

require_once "../controladores/origenes.controlador.php";
require_once "../modelos/origenes.modelo.php";

require_once "../controladores/destinos.controlador.php";
require_once "../modelos/destinos.modelo.php";




class TablaUnidades{




	public static function mostrarTablaUnidades(){

		$item = null;
    	$valor = null;
    	$orden = "id";

  		$unidades = ControladorUnidades::ctrMostrarUnidades($item, $valor, $orden);	
  		$TotalUnidades = count($unidades);
  		
  		if(count($unidades) == 0){

  			echo '{"data": []}';

		  	return;
  		}
		
  		$datosJson = '{
		  "data": [';

		  for($i = 0; $i < count($unidades); $i++){

		  	/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/ 

		  	$imagen = "<img src='".$unidades[$i]["imagen"]."' width='40px'>";

		  	/*=============================================
 	 		TRAEMOS LA MARCA
  			=============================================*/ 

		  	$item = "id";
		  	$valor = $unidades[$i]["id_marca"];

		  	$marcas = ControladorMarcas::ctrMostrarMarcas($item, $valor);

		  	/*=============================================
 	 		TRAEMOS EL OPERADOR
  			=============================================*/ 

		  	$item1 = "id";
		  	$valor1 = $unidades[$i]["id_operador"];

		  	$operadores = ControladorOperadores::ctrMostrarOperadores($item1, $valor1);


		  	/*=============================================
 	 		TRAEMOS EL ORIGEN
  			=============================================*/ 

		  	$item2 = "id";
		  	$valor2 = $unidades[$i]["id_origen"];

		  	$origenes = ControladorOrigenes::ctrMostrarOrigenes($item2, $valor2);

		  	/*=============================================
 	 		TRAEMOS EL DESTINO
  			=============================================*/ 

		  	$item3 = "id";
		  	$valor3 = $unidades[$i]["id_destino"];

		  	$destinos = ControladorDestinos::ctrMostrarDestinos($item3, $valor3);

		  	/*=============================================
 	 		STOCK
  			=============================================*/ 

  			if($unidades[$i]["cantPasajeros"] <= 10){

  				$cantPasajeros = "<button class='btn btn-danger'>".$unidades[$i]["cantPasajeros"]."</button>";

  			}else if($unidades[$i]["cantPasajeros"] > 11 && $unidades[$i]["cantPasajeros"] <= 15){

  				$cantPasajeros = "<button class='btn btn-warning'>".$unidades[$i]["cantPasajeros"]."</button>";

  			}else{

  				$cantPasajeros = "<button class='btn btn-success'>".$unidades[$i]["cantPasajeros"]."</button>";

  			}



		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 

  			if(isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "Especial"){

  				$botones =  "<!--div class='btn-group'><button class='btn btn-warning btnEditarUnidad' idUnidad='".$unidades[$i]["id"]."' data-toggle='modal' data-target='#modalEditarUnidad'><i class='fa fa-pencil'></i></button></div-->"; 

  			}else{

  			 $botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarUnidad' idUnidad='".$unidades[$i]["id"]."' data-toggle='modal' data-target='#modalEditarUnidad'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarUnidad' idUnidad='".$unidades[$i]["id"]."' codigo='".$unidades[$i]["codigo"]."' imagen='".$unidades[$i]["imagen"]."'><i class='fa fa-times'></i></button></div>"; 

  			}



     
		 
		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$imagen.'",
			      "'.$unidades[$i]["codigo"].'",
			      
			      "'.$unidades[$i]["id_marca"].'",
			      "'.$unidades[$i]["id_operador"].'",
			      "'.$unidades[$i]["id_origen"].'",
			      "'.$unidades[$i]["id_destino"].'",
			  
				  "'.$unidades[$i]["kmsalida"].'",

				  "'.$unidades[$i]["hrsSalida"].'",
			  
			      "'.$unidades[$i]["kmllegada"].'",

			      "'.$unidades[$i]["hrsLlegada"].'",



			      "'.$unidades[$i]["kmRecorrido"].'",
			      "'.$cantPasajeros.'",

			      "'.$unidades[$i]["observacion"].'",

			 
			  			     
			      "'.$unidades[$i]["fecha"].'",
			      "'.$botones.'"
			    ],';

		  }

		

		  $datosJson = substr($datosJson, 0, -1);

		 $datosJson .=   '] 

		 }';

		 
		
		echo $datosJson;


	}


}


/*=============================================
ACTIVAR TABLA DE UNIDADES
=============================================*/ 
$activarUnidades = new TablaUnidades();
$activarUnidades -> mostrarTablaUnidades();

