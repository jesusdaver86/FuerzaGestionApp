<?php
date_default_timezone_set("Etc/GMT+4");
setlocale(LC_TIME, "spanish");

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ControladorVentas{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/

	public static function ctrMostrarVentas($item, $valor){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
 
		return $respuesta;

	}

	/*=============================================
	CREAR VENTA
	=============================================*/

	public static function ctrCrearVenta(){

		if(isset($_POST["nuevaVenta"])){

			/*=============================================
			ACTUALIZAR LAS COMPRAS DEL PASAJERO Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS UNIDADES
			=============================================*/

			if($_POST["listaUnidades"] == ""){

					echo'<script>

				swal({
					  type: "error",
					  title: "La venta no se ha ejecuta si no hay productos",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

				return;
			}


			$listaUnidades = json_decode($_POST["listaUnidades"], true);

			$totalUnidadesComprados = array();

			foreach ($listaUnidades as $key => $value) {

			   array_push($totalUnidadesComprados, $value["cantidad"]);
				
			   $tablaUnidades = "productos";

			    $item = "id";
			    $valor = $value["id"];
			    $orden = "id";

			    $traerProducto = ModeloUnidades::mdlMostrarUnidades($tablaUnidades, $item, $valor, $orden);

				$item1a = "ventas";
				$valor1a = $value["cantidad"] + $traerProducto["ventas"];

			    $nuevasVentas = ModeloUnidades::mdlActualizarProducto($tablaUnidades, $item1a, $valor1a, $valor);

				$item1b = "cantPasajeros";
				$valor1b = $value["cantPasajeros"];

				$nuevocantPasajeros = ModeloUnidades::mdlActualizarProducto($tablaUnidades, $item1b, $valor1b, $valor);

			}

			$tablaPasajeros = "pasajeros";

			$item = "id";
			$valor = $_POST["seleccionarPasajero"];

			$traerPasajero = ModeloPasajeros::mdlMostrarPasajeros($tablaPasajeros, $item, $valor);

			$item1a = "compras";
				
			$valor1a = array_sum($totalUnidadesComprados) + $traerPasajero["compras"];

			$comprasPasajero = ModeloPasajeros::mdlActualizarPasajero($tablaPasajeros, $item1a, $valor1a, $valor);

			$item1b = "ultima_compra";

			/*date_default_timezone_set('America/Bogota');*/
			date_default_timezone_set("Etc/GMT+4");
			setlocale(LC_TIME, "spanish");

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;

			$fechaPasajero = ModeloPasajeros::mdlActualizarPasajero($tablaPasajeros, $item1b, $valor1b, $valor);

			/*=============================================
			GUARDAR LA COMPRA
			=============================================*/	

			$tabla = "pasajeros";

			$datos = array("id_vendedor"=>$_POST["idVendedor"],
						   "id_pasajero"=>$_POST["seleccionarPasajero"],
						   "codigo"=>$_POST["nuevaVenta"],
						   "unidades"=>$_POST["listaUnidades"],
						   "impuesto"=>$_POST["nuevoPrecioImpuesto"],
						   "neto"=>$_POST["nuevoPrecioNeto"],
						   "total"=>$_POST["totalVenta"],
						   "metodo_pago"=>$_POST["listaMetodoPago"]);

			$respuesta = ModeloPasajeros::mdlIngresarPasajero($tabla, $datos);

			if($respuesta == "ok"){

				// $impresora = "epson20";

				// $conector = new WindowsPrintConnector($impresora);

				// $imprimir = new Printer($conector);

				// $imprimir -> text("Hola Mundo"."\n");

				// $imprimir -> cut();

				// $imprimir -> close();

				/**$impresora = "epson20";

				$conector = new WindowsPrintConnector($impresora);

				$printer = new Printer($conector);

				$printer -> setJustification(Printer::JUSTIFY_CENTER);

				$printer -> text(date("Y-m-d H:i:s")."\n");//Fecha de la factura

				$printer -> feed(1); //Alimentamos el papel 1 vez*/

				/**$printer -> text("Inventory System"."\n");//Nombre de la empresa

				$printer -> text("NIT: 71.759.963-9"."\n");//Nit de la empresa

				$printer -> text("Dirección: Calle 44B 92-11"."\n");//Dirección de la empresa

				$printer -> text("Teléfono: 300 786 52 49"."\n");//Teléfono de la empresa

				$printer -> text("FACTURA N.".$_POST["nuevaVenta"]."\n");//Número de factura

				$printer -> feed(1); //Alimentamos el papel 1 vez*/

				/**$printer -> text("Pasajero: ".$traerPasajero["nombre"]."\n");//Nombre del pasajero

				$tablaVendedor = "usuarios";
				$item = "id";
				$valor = $_POST["idVendedor"];

				$traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);

				$printer -> text("Vendedor: ".$traerVendedor["nombre"]."\n");//Nombre del vendedor

				$printer -> feed(1); //Alimentamos el papel 1 vez*/

				/**foreach ($listaUnidades as $key => $value) {

					$printer->setJustification(Printer::JUSTIFY_LEFT);

					$printer->text($value["descripcion"]."\n");//Nombre del producto

					$printer->setJustification(Printer::JUSTIFY_RIGHT);

					$printer->text("$ ".number_format($value["precio"],2)." Und x ".$value["cantidad"]." = $ ".number_format($value["total"],2)."\n");

				}

				$printer -> feed(1); //Alimentamos el papel 1 vez*/			
				
				/**$printer->text("NETO: $ ".number_format($_POST["nuevoPrecioNeto"],2)."\n"); //ahora va el neto

				$printer->text("IMPUESTO: $ ".number_format($_POST["nuevoPrecioImpuesto"],2)."\n"); //ahora va el impuesto

				$printer->text("--------\n");

				$printer->text("TOTAL: $ ".number_format($_POST["totalVenta"],2)."\n"); //ahora va el total

				$printer -> feed(1); //Alimentamos el papel 1 vez*/	

				/**$printer->text("Muchas gracias por su compra"); //Podemos poner también un pie de página

				$printer -> feed(3); //Alimentamos el papel 3 veces*/

				/**$printer -> cut(); //Cortamos el papel, si la impresora tiene la opción

				$printer -> pulse(); //Por medio de la impresora mandamos un pulso, es útil cuando hay cajón moneder

				$printer -> close();*/

	
				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La venta ha sido guardada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

			}

		}

	}

	/*=============================================
	EDITAR VENTA
	=============================================*/

	public static function ctrEditarVenta(){

		if(isset($_POST["editarVenta"])){

			/*=============================================
			FORMATEAR TABLA DE UNIDADES Y LA DE PASAJEROS
			=============================================*/
			$tabla = "ventas";

			$item = "codigo";
			$valor = $_POST["editarVenta"];

			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			/*=============================================
			REVISAR SI VIENE UNIDADES EDITADOS
			=============================================*/

			if($_POST["listaUnidades"] == ""){

				$listaUnidades = $traerVenta["unidades"];
				$cambioProducto = false;


			}else{

				$listaUnidades = $_POST["listaUnidades"];
				$cambioProducto = true;
			}

			if($cambioProducto){

				$productos =  json_decode($traerVenta["unidades"], true);

				$totalUnidadesComprados = array();

				foreach ($productos as $key => $value) {

					array_push($totalUnidadesComprados, $value["cantidad"]);
					
					$tablaUnidades = "unidades";

					$item = "id";
					$valor = $value["id"];
					$orden = "id";

					$traerProducto = ModeloUnidades::mdlMostrarUnidades($tablaUnidades, $item, $valor, $orden);

					$item1a = "ventas";
					$valor1a = $traerProducto["ventas"] - $value["cantidad"];

					$nuevasVentas = ModeloUnidades::mdlActualizarUnidad($tablaUnidades, $item1a, $valor1a, $valor);

					$item1b = "cantPasajeros";
					$valor1b = $value["cantidad"] + $traerProducto["cantPasajeros"];

					$nuevocantPasajeros = ModeloUnidades::mdlActualizarUnidad($tablaUnidades, $item1b, $valor1b, $valor);

				}

				$tablaPasajeros = "pasajeros";

				$itemPasajero = "id";
				$valorPasajero = $_POST["seleccionarPasajero"];

				$traerPasajero = ModeloPasajeros::mdlMostrarPasajeros($tablaPasajeros, $itemPasajero, $valorPasajero);

				$item1a = "compras";
				$valor1a = $traerPasajero["compras"] - array_sum($totalUnidadesComprados);		

				$comprasPasajero = ModeloPasajeros::mdlActualizarPasajero($tablaPasajeros, $item1a, $valor1a, $valorPasajero);

				/*=============================================
				ACTUALIZAR LAS COMPRAS DEL PASAJERO Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS UNIDADES
				=============================================*/

				$listaUnidades_2 = json_decode($listaUnidades, true);

				$totalUnidadesComprados_2 = array();

				foreach ($listaUnidades_2 as $key => $value) {

					array_push($totalUnidadesComprados_2, $value["cantidad"]);
					
					$tablaUnidades_2 = "productos";

					$item_2 = "id";
					$valor_2 = $value["id"];
					$orden = "id";

					$traerUnidad_2 = ModeloUnidades::mdlMostrarUnidades($tablaUnidades_2, $item_2, $valor_2, $orden);

					$item1a_2 = "ventas";
					$valor1a_2 = $value["cantidad"] + $traerProducto_2["ventas"];

					$nuevasVentas_2 = ModeloUnidades::mdlActualizarProducto($tablaUnidades_2, $item1a_2, $valor1a_2, $valor_2);

					$item1b_2 = "cantPasajeros";
					$valor1b_2 = $value["cantPasajeros"];

					$nuevocantPasajeros_2 = ModeloUnidades::mdlActualizarProducto($tablaUnidades_2, $item1b_2, $valor1b_2, $valor_2);

				}

				$tablaPasajeros_2 = "pasajeros";

				$item_2 = "id";
				$valor_2 = $_POST["seleccionarPasajero"];

				$traerPasajero_2 = ModeloPasajeros::mdlMostrarPasajeros($tablaPasajeros_2, $item_2, $valor_2);

				$item1a_2 = "compras";

				$valor1a_2 = array_sum($totalUnidadesComprados_2) + $traerPasajero_2["compras"];

				$comprasPasajero_2 = ModeloPasajeros::mdlActualizarPasajero($tablaPasajeros_2, $item1a_2, $valor1a_2, $valor_2);

				$item1b_2 = "ultima_compra";

				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha.' '.$hora;

				$fechaPasajero_2 = ModeloPasajeros::mdlActualizarPasajero($tablaPasajeros_2, $item1b_2, $valor1b_2, $valor_2);

			}

			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/	

			$datos = array("id_vendedor"=>$_POST["idVendedor"],
						   "id_pasajero"=>$_POST["seleccionarPasajero"],
						   "codigo"=>$_POST["editarVenta"],
						   "productos"=>$listaUnidades,
						   "impuesto"=>$_POST["nuevoPrecioImpuesto"],
						   "neto"=>$_POST["nuevoPrecioNeto"],
						   "total"=>$_POST["totalVenta"],
						   "metodo_pago"=>$_POST["listaMetodoPago"]);


			$respuesta = ModeloVentas::mdlEditarVenta($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La venta ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

			}

		}

	}


	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	public static function ctrEliminarVenta(){

		if(isset($_GET["idVenta"])){

			$tabla = "ventas";

			$item = "id";
			$valor = $_GET["idVenta"];

			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			/*=============================================
			ACTUALIZAR FECHA ÚLTIMA COMPRA
			=============================================*/

			$tablaPasajeros = "pasajeros";

			$itemVentas = null;
			$valorVentas = null;

			$traerVentas = ModeloVentas::mdlMostrarVentas($tabla, $itemVentas, $valorVentas);

			$guardarFechas = array();

			foreach ($traerVentas as $key => $value) {
				
				if($value["id_pasajero"] == $traerVenta["id_pasajero"]){

					array_push($guardarFechas, $value["fecha"]);

				}

			}

			if(count($guardarFechas) > 1){

				if($traerVenta["fecha"] > $guardarFechas[count($guardarFechas)-2]){

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-2];
					$valorIdPasajero = $traerVenta["id_pasajero"];

					$comprasPasajero = ModeloPasajeros::mdlActualizarPasajero($tablaPasajeros, $item, $valor, $valorIdPasajero);

				}else{

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-1];
					$valorIdPasajero = $traerVenta["id_pasajero"];

					$comprasPasajero = ModeloPasajeros::mdlActualizarPasajero($tablaPasajeros, $item, $valor, $valorIdPasajero);

				}


			}else{

				$item = "ultima_compra";
				$valor = "0000-00-00 00:00:00";
				$valorIdPasajero = $traerVenta["id_pasajero"];

				$comprasPasajero = ModeloPasajeros::mdlActualizarPasajero($tablaPasajeros, $item, $valor, $valorIdPasajero);

			}

			/*=============================================
			FORMATEAR TABLA DE UNIDADES Y LA DE PASAJEROS
			=============================================*/

			$productos =  json_decode($traerVenta["productos"], true);

			$totalUnidadesComprados = array();

			foreach ($productos as $key => $value) {

				array_push($totalUnidadesComprados, $value["cantidad"]);
				
				$tablaUnidades = "productos";

				$item = "id";
				$valor = $value["id"];
				$orden = "id";

				$traerProducto = ModeloUnidades::mdlMostrarUnidades($tablaUnidades, $item, $valor, $orden);

				$item1a = "ventas";
				$valor1a = $traerProducto["ventas"] - $value["cantidad"];

				$nuevasVentas = ModeloUnidades::mdlActualizarProducto($tablaUnidades, $item1a, $valor1a, $valor);

				$item1b = "cantPasajeros";
				$valor1b = $value["cantidad"] + $traerProducto["cantPasajeros"];

				$nuevocantPasajeros = ModeloUnidades::mdlActualizarProducto($tablaUnidades, $item1b, $valor1b, $valor);

			}

			$tablaPasajeros = "pasajeros";

			$itemPasajero = "id";
			$valorPasajero = $traerVenta["id_pasajero"];

			$traerPasajero = ModeloPasajeros::mdlMostrarPasajeros($tablaPasajeros, $itemPasajero, $valorPasajero);

			$item1a = "compras";
			$valor1a = $traerPasajero["compras"] - array_sum($totalUnidadesComprados);

			$comprasPasajero = ModeloPasajeros::mdlActualizarPasajero($tablaPasajeros, $item1a, $valor1a, $valorPasajero);

			/*=============================================
			ELIMINAR VENTA
			=============================================*/

			$respuesta = ModeloVentas::mdlEliminarVenta($tabla, $_GET["idVenta"]);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "La venta ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

			}		
		}

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	
/*
	public static function ctrRangoFechasVentas($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}*/
	public static function ctrRangoFechasVentas($fechaInicial, $fechaFinal){

		$tabla = "pasajeros";

		$respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporte(){

		if(isset($_GET["reporte"])){

			$tabla = "ventas";

			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$ventas = ModeloVentas::mdlRangoFechasVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}else{

				$item = null;
				$valor = null;

				$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			}


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");
		
			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>PASAJERO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>UNIDADES</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NETO</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td	
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

			foreach ($ventas as $row => $item){

				$pasajero = ControladorPasajeros::ctrMostrarPasajeros("id", $item["id_pasajero"]);
				$vendedor = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_vendedor"]);

			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["codigo"]."</td> 
			 			<td style='border:1px solid #eee;'>".$pasajero["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>".$vendedor["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>");

			 	$productos =  json_decode($item["productos"], true);

			 	foreach ($productos as $key => $valueUnidades) {
			 			
			 			echo utf8_decode($valueUnidades["cantidad"]."<br>");
			 		}

			 	echo utf8_decode("</td><td style='border:1px solid #eee;'>");	

		 		foreach ($productos as $key => $valueUnidades) {
			 			
		 			echo utf8_decode($valueUnidades["descripcion"]."<br>");
		 		
		 		}

		 		echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["impuesto"],2)."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["neto"],2)."</td>	
					<td style='border:1px solid #eee;'>$ ".number_format($item["total"],2)."</td>
					<td style='border:1px solid #eee;'>".$item["metodo_pago"]."</td>
					<td style='border:1px solid #eee;'>".substr($item["fecha"],0,10)."</td>		
		 			</tr>");


			}


			echo "</table>";

		}

	}




















/*=============================================
	RANGO FECHAS
	=============================================*/	

	public static function ctrRangoFechasProduc($fechaInicial, $fechaFinal){

		$tabla = "productos";

		$respuesta = ModeloVentas::mdlRangoFechasProduc($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporteProduc(){

		if(isset($_GET["reporte"])){

			$tabla = "productos";

			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$ventas = ModeloVentas::mdlRangoFechasProduc($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}else{

				$item = null;
				$valor = null;

				$ventas = ModeloVentas::mdlMostrarProduc($tabla, $item, $valor);

			}


			/*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

			$Name = $_GET["reporte"].'.xls';

			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");
		
			echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>PASAJERO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>UNIDADES</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NETO</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td	
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

			foreach ($ventas as $row => $item){

				/*$pasajero = ControladorPasajeros::ctrMostrarPasajeros("id", $item["id_pasajero"]);
				$vendedor = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_vendedor"]);*/

			 echo utf8_decode("<tr>
			 			<!--td style='border:1px solid #eee;'>".$item["codigo"]."</td> 
			 			<td style='border:1px solid #eee;'>".$pasajero["nombre"]."</td>
			 			<td style='border:1px solid #eee;'>".$vendedor["nombre"]."</td-->
			 			<td style='border:1px solid #eee;'>");

			 	$productos =  json_decode($item["productos"], true);

			 	foreach ($productos as $key => $valueUnidades) {
			 			
			 			echo utf8_decode($valueUnidades["cantidad"]."<br>");
			 		}

			 	echo utf8_decode("</td><td style='border:1px solid #eee;'>");	

		 		foreach ($productos as $key => $valueUnidades) {
			 			
		 			echo utf8_decode($valueUnidades["descripcion"]."<br>");
		 		
		 		}

		 		echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["impuesto"],2)."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["neto"],2)."</td>	
					<td style='border:1px solid #eee;'>$ ".number_format($item["total"],2)."</td>
					<td style='border:1px solid #eee;'>".$item["metodo_pago"]."</td>
					<td style='border:1px solid #eee;'>".substr($item["fecha"],0,10)."</td>		
		 			</tr>");


			}


			echo "</table>";

		}

	}






































	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/

	public static function ctrSumaTotalVentas(){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlSumaTotalVentas($tabla);

		return $respuesta;

	}

	/*=============================================
	DESCARGAR XML
	=============================================*/

	public static function ctrDescargarXML(){

		if(isset($_GET["xml"])){


			$tabla = "ventas";
			$item = "codigo";
			$valor = $_GET["xml"];

			$ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			// UNIDADES

			$listaUnidades = json_decode($ventas["productos"], true);

			// PASAJERO

			$tablaPasajeros = "pasajeros";
			$item = "id";
			$valor = $ventas["id_pasajero"];

			$traerPasajero = ModeloPasajeros::mdlMostrarPasajeros($tablaPasajeros, $item, $valor);

			// VENDEDOR

			$tablaVendedor = "usuarios";
			$item = "id";
			$valor = $ventas["id_vendedor"];

			$traerVendedor = ModeloUsuarios::mdlMostrarUsuarios($tablaVendedor, $item, $valor);

			//http://php.net/manual/es/book.xmlwriter.php

			$objetoXML = new XMLWriter();

			$objetoXML->openURI($_GET["xml"].".xml"); //Creación del archivo XML

			$objetoXML->setIndent(true); //recibe un valor booleano para establecer si los distintos niveles de nodos XML deben quedar indentados o no.

			$objetoXML->setIndentString("\t"); // carácter \t, que corresponde a una tabulación

			$objetoXML->startDocument('1.0', 'utf-8');// Inicio del documento
			
			// $objetoXML->startElement("etiquetaPrincipal");// Inicio del nodo raíz

			// $objetoXML->writeAttribute("atributoEtiquetaPPal", "valor atributo etiqueta PPal"); // Atributo etiqueta principal

			// 	$objetoXML->startElement("etiquetaInterna");// Inicio del nodo hijo

			// 		$objetoXML->writeAttribute("atributoEtiquetaInterna", "valor atributo etiqueta Interna"); // Atributo etiqueta interna

			// 		$objetoXML->text("Texto interno");// Inicio del nodo hijo
			
			// 	$objetoXML->endElement(); // Final del nodo hijo
			
			// $objetoXML->endElement(); // Final del nodo raíz


			$objetoXML->writeRaw('<fe:Invoice xmlns:fe="http://www.dian.gov.co/contratos/facturaelectronica/v1" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:clm54217="urn:un:unece:uncefact:codelist:specification:54217:2001" xmlns:clm66411="urn:un:unece:uncefact:codelist:specification:66411:2001" xmlns:clmIANAMIMEMediaType="urn:un:unece:uncefact:codelist:specification:IANAMIMEMediaType:2003" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2" xmlns:sts="http://www.dian.gov.co/contratos/facturaelectronica/v1/Structures" xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dian.gov.co/contratos/facturaelectronica/v1 ../xsd/DIAN_UBL.xsd urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2 ../../ubl2/common/UnqualifiedDataTypeSchemaModule-2.0.xsd urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2 ../../ubl2/common/UBL-QualifiedDatatypes-2.0.xsd">');

			$objetoXML->writeRaw('<ext:UBLExtensions>');

			foreach ($listaUnidades as $key => $value) {
				
				$objetoXML->text($value["descripcion"].", ");
			
			}

			

			$objetoXML->writeRaw('</ext:UBLExtensions>');

			$objetoXML->writeRaw('</fe:Invoice>');

			$objetoXML->endDocument(); // Final del documento

			return true;	
		}

	}

}