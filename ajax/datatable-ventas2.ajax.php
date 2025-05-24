<?php
require_once "../controladores/unidades.controlador.php";
require_once "../modelos/unidades.modelo.php";


class TablaUnidadesVentas{

 	/*=============================================
 	 MOSTRAR LA TABLA DE UNIDADES
  	=============================================*/ 

	public function mostrarTablaUnidadesVentas(){

		$item = null;
    	$valor = null;
    	$orden = "id";

  		$unidades = ControladorUnidades::ctrMostrarUnidades($item, $valor, $orden);
 		
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

		  	$botones =  "<div class='btn-group'><button class='btn btn-primary agregarUnidad recuperarBoton' idUnidad='".$unidades[$i]["id"]."'>Agregar</button></div>"; 

		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$imagen.'",
			      "'.$unidades[$i]["codigo"].'",
			      "'.$unidades[$i]["descripcion"].'",
			      "'.$cantPasajeros.'",
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
$activarUnidadesVentas = new TablaUnidadesVentas();
$activarUnidadesVentas -> mostrarTablaUnidadesVentas();

