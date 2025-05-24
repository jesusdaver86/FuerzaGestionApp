<?php
date_default_timezone_set("Etc/GMT+4");
setlocale(LC_TIME, "spanish");
/*header('Content-Type: application/json');*/

/*echo json_encode($respuesta);*/
/** Error reporting */

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
/** Error reporting */

/*include "06largescale-with-cellcaching-sqlite.php";*/



class ControladorUnidades{

	/*=============================================
	MOSTRAR UNIDADES
	=============================================*/

	public static function ctrMostrarUnidades($item, $valor, $orden){

		$tabla = "unidades";

		$respuesta = ModeloUnidades::mdlMostrarUnidades($tabla, $item, $valor, $orden);

		return $respuesta;




	}


	/*=============================================
	CREAR Unidad 
	=============================================*/

	public static function ctrCrearUnidad(){

		if(isset($_POST["nuevokmsalida"])){

			if(preg_match('/^[0-9]+$/', $_POST["nuevokmsalida"]) &&
			   preg_match('/^[0-9]+$/', $_POST["nuevokmllegada"]) &&
			   preg_match('/^[0-9]+$/', $_POST["nuevocantPasajeros"]) &&	
			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioCompra"]) &&
			   preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaObservacion"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioVenta"])){



			   	$ruta = "vistas/img/unidades/default/anonymous.png";

			   	if(isset($_FILES["nuevaImagen"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;



					$directorio = "vistas/img/unidades/".$_POST["nuevoCodigo"];

					mkdir($directorio, 0755);

		

					if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){

	

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/unidades/".$_POST["nuevoCodigo"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["nuevaImagen"]["type"] == "image/png"){

		

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/unidades/".$_POST["nuevoCodigo"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "unidades";

				$datos = array("id_marca" => $_POST["nuevaMarca"],
							   "codigo" => $_POST["nuevoCodigo"],
							   "id_operador" => $_POST["nuevoOperador"],
							   "id_origen" => $_POST["nuevoOrigen"],
							   "id_destino" => $_POST["nuevoDestino"],
							   "kmsalida" => $_POST["nuevokmsalida"],
							   "hrsSalida" => $_POST["nuevahrsSalida"],
							   "kmllegada" => $_POST["nuevokmllegada"],
							   "hrsLlegada" => $_POST["nuevahrsLlegada"],
							   "kmRecorrido" => $_POST["nuevokmRecorrido"],
							   "cantPasajeros" => $_POST["nuevocantPasajeros"],
							   "observacion" => $_POST["nuevaObservacion"],
							   "precio_compra" => $_POST["nuevoPrecioCompra"],
							   "precio_venta" => $_POST["nuevoPrecioVenta"],
							   
							   
							   "imagen" => $ruta);

				$respuesta = ModeloUnidades::mdlCrearUnidad($tabla, $datos);

				if($respuesta == "ok"){

					/*echo'<script>

						swal({
							  type: "success",
							  title: "La unidad ha sido guardada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "unidades";

										}
									})

						</script>';*/
						echo '<script>

      swal({

        type: "success",

        title: "La unidad ha sido guardada correctamente",

        showConfirmButton: true,

        confirmButtonText: "Cerrar"

      }).then(function(result){

        if (result.value) {

          event.preventDefault(); // Prevent the default behavior of the link

          // Redireccionar a la página de unidades utilizando JavaScript

          window.location.href = "unidades";

        }

      });

    </script>';

				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La unidad no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "unidades";

							}
						})

			  	</script>';
			}
		}

	}

	/*=============================================
	EDITAR UNIDAD
	=============================================*/

	public static function ctrEditarUnidad(){


if(isset($_POST["editarkmsalida"])){

			if(preg_match('/^[0-9]+$/', $_POST["editarkmsalida"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editarkmllegada"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editarcantPasajeros"]) &&
			   preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarObservacion"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["editarPrecioCompra"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["editarPrecioVenta"])){

			


		   		/*=============================================
				VALIDAR IMAGEN
				=============================================*/

			   	$ruta = $_POST["imagenActual"];

			   	if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/unidades/".$_POST["editarCodigo"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if(!empty($_POST["imagenActual"])){

						unlink($_POST["imagenActual"]);

					}else{

						mkdir($directorio, 0755);	
					
					}
					
					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["editarImagen"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/unidades/".$_POST["editarCodigo"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["editarImagen"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/unidades/".$_POST["editarCodigo"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "unidades";

				$datos = array("id_marca" => $_POST["editarMarca"],
							   "codigo" => $_POST["editarCodigo"],
							   "id_operador" => $_POST["editarOperador"],

							   "id_origen" => $_POST["editarOrigen"],

							   "id_destino" => $_POST["editarDestino"],


							   "kmsalida" => $_POST["editarkmsalida"],
							   "hrsSalida" => $_POST["editarhrsSalida"],
							   "kmllegada" => $_POST["editarkmllegada"],
							   "hrsLlegada" => $_POST["editarhrsLlegada"],
							   "kmRecorrido" => $_POST["editarkmRecorrido"],
							   "cantPasajeros" => $_POST["editarcantPasajeros"],
							   "observacion" => $_POST["editarObservacion"],
					
						
							   "imagen" => $ruta);

				$respuesta = ModeloUnidades::mdlEditarUnidad($tabla, $datos);

				if($respuesta == "ok"){

					/*echo'<script>

						swal({
							  type: "success",
							  title: "La Unidad ha sido editada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
										if (result.value) {

										window.location = "unidades";

										}
									})

						</script>';*/

					echo '<script>

      swal({

        type: "success",

        title: "La Unidad ha sido editada correctamente",

        showConfirmButton: true,

        confirmButtonText: "Cerrar"

      }).then(function(result){

        if (result.value) {

          event.preventDefault(); // Prevent the default behavior of the link

          // Redireccionar a la página de unidades utilizando JavaScript

          window.location.href = "unidades";

        }

      });

    </script>';









				}


			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La unidad no puede ir con los campos vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "unidades";

							}
						})

			  	</script>';
			}
		}

	}



public function ctrEliminarUnidad(){


  $ruta = "ajax/unidades.ajax.php";


  if(isset($_POST["idUnidad"])){


    $idUnidad = $_POST["idUnidad"];


    $stmt = ControladorUnidades::$conexion->prepare("DELETE FROM unidades WHERE id = ?");

    $stmt->bind_param("i", $idUnidad);


    if($stmt->execute()){


      $respuesta = array(

        "respuesta" => "exito",

        "mensaje" => "Unidad eliminada correctamente"

      );


    }else{


      $respuesta = array(

        "respuesta" => "error",

        "mensaje" => "Error al eliminar la unidad"

      );


    }


    $stmt->close();


  }else{


    $respuesta = array(

      "respuesta" => "error",

      "mensaje" => "No se envió la información requerida"

    );


  }


  return $respuesta;


}






	/*=============================================
	RANGO FECHAS
	=============================================*/	

	public static function ctrRangoFechasUnidades($fechaInicial, $fechaFinal){

		$tabla = "unidades";


		$respuesta = ModeloUnidades::mdlRangoFechasUnidades($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}





	/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReporteUnidades(){

		if(isset($_GET["reporte"])){



			$tabla = "unidades";


            


			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){

				$ventas = ModeloUnidades::mdlRangoFechasUnidades($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);

			}else{

				$item = null;
				$valor = null;

				$ventas = ModeloUnidades::mdlMostrarUnidades($tabla, $item, $valor);

			}
				





 $objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setCellValue('G1', PHPExcel_Shared_Date::PHPToExcel(gmmktime(0, 0, 0, date('m'), date('d'), date('Y'))));
$objPHPExcel->getActiveSheet()->getStyle('G1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX15);

$objPHPExcel->getActiveSheet()->setCellValue('A3', 'NRO UNIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'OPERADOR');
$objPHPExcel->getActiveSheet()->setCellValue('C3', 'ORIGEN');
$objPHPExcel->getActiveSheet()->setCellValue('D3', 'DESTINO');
$objPHPExcel->getActiveSheet()->setCellValue('E3', 'KM SALIDA');
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'HRS SALIDA');
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'KM LLEGADA');
$objPHPExcel->getActiveSheet()->setCellValue('H3', 'HRS LLEGADA');
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'KM RECORRIDO');
$objPHPExcel->getActiveSheet()->setCellValue('J3', 'CANT. PASAJEROS');
$objPHPExcel->getActiveSheet()->setCellValue('K3', 'OBSERVACION');
$objPHPExcel->getActiveSheet()->setCellValue('L3', 'FECHA');

$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(4, 50);


// Add data to the spreadsheet
$row = 4;
$i = 1;

foreach ($ventas as $item) {



    // Add a new row for each record
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $item["codigo"]);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $item["id_operador"]);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $item["id_origen"]);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $item["id_destino"]);
   /* $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $operador["id"]);

    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $origen["id"]); 

	$objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $destino["destino"]); */
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $item["kmsalida"]);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $item["hrsSalida"]);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $item["kmllegada"]);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $item["hrsLlegada"]);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $item["kmRecorrido"]);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $item["cantPasajeros"]);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $item["observacion"]);
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, substr($item["fecha"], 0, 10));

    $row++;
    $i++;
}



// Add rich-text string

$ruta = "vistas/img/plantilla/.jpg";

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../../vistas/img/plantilla/logo-blanco-bloque.png');
$objDrawing->setHeight(36);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());





$objRichText = new PHPExcel_RichText();
$objRichText->createText('Registro Rutas Bus TT');

$objPayable = $objRichText->createTextRun(' ');
$objPayable->getFont()->setBold(true);
$objPayable->getFont()->setItalic(true);
$objPayable->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_DARKGREEN ) );

$objRichText->createText(' ');

$objPHPExcel->getActiveSheet()->getCell('B1')->setValue($objRichText); 

// Merge cells

$objPHPExcel->getActiveSheet()->mergeCells('B1:E1');
$objPHPExcel->getActiveSheet()->mergeCells('B1:C1');		// Just to test...
$objPHPExcel->getActiveSheet()->unmergeCells('B1:C1');	// Just to test...

// Protect cells

$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);	// Needs to be set to true in order to enable any worksheet protection!
$objPHPExcel->getActiveSheet()->protectCells('A3:L13', 'PHPExcel');

// Set cell number formats
/*
$objPHPExcel->getActiveSheet()->getStyle('E4:E13')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

*/
// Set column widths

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
/*$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);*/
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
// Set fonts

$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

/*$objPHPExcel->getActiveSheet()->getStyle('D13')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E13')->getFont()->setBold(true);*/

// Set alignments

$objPHPExcel->getActiveSheet()->getStyle('D11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('D12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('D13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
$objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setShrinkToFit(true);

// Set thin black border outline around column

$styleThinBlackBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle('A4:L10')->applyFromArray($styleThinBlackBorderOutline);


// Set thick brown border outline around "Total"

$styleThickBrownBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THICK,
			'color' => array('argb' => 'FF993300'),
		),
	),
);

//NEGRITA LETRA
/*$objPHPExcel->getActiveSheet()->getStyle('D13:E13')->applyFromArray($styleThickBrownBorderOutline);*/

// Set fills

$objPHPExcel->getActiveSheet()->getStyle('A1:G2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:G2')->getFill()->getStartColor()->setARGB('FF808080');

// Set style for header row using alternative method

$objPHPExcel->getActiveSheet()->getStyle('A3:L3')->applyFromArray(
		array(
			'font'    => array(
				'bold'      => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			),
			'borders' => array(
				'top'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			),
			'fill' => array(
	 			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	  			'rotation'   => 90,
	 			'startcolor' => array(
	 				'argb' => 'FFA0A0A0'
	 			),
	 			'endcolor'   => array(
	 				'argb' => 'FFFFFFFF'
	 			)
	 		)
		)
);

$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray(
		array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
			'borders' => array(
				'left'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray(
		array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			)
		)
);

$objPHPExcel->getActiveSheet()->getStyle('L3')->applyFromArray(
		array(
			'borders' => array(
				'right'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			)
		)
);

// Unprotect a cell

$objPHPExcel->getActiveSheet()->getStyle('B1')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

// Add a hyperlink to the sheet


// Play around with inserting and removing rows and columns

$objPHPExcel->getActiveSheet()->insertNewRowBefore(6, 10);
$objPHPExcel->getActiveSheet()->removeRow(6, 10);
$objPHPExcel->getActiveSheet()->insertNewColumnBefore('E', 5);
$objPHPExcel->getActiveSheet()->removeColumn('E', 5);

// Set header and footer. When no different headers for odd/even are used, odd header is assumed.

$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BInvoice&RPrinted on &D');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

// Set page orientation and size

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

// Rename first worksheet

$objPHPExcel->getActiveSheet()->setTitle('Flota Bus');



/*header('Content-Disposition: attachment;filename="01simple.xls"');*/



// Set active sheet index to the first sheet, so Excel opens this as the first sheet




ob_end_clean(); // clean the output buffer


$filePath = str_replace('.php', '.xlsx', __FILE__);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save($filePath);


header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

header('Content-Disposition: inline; filename="' . basename($filePath) . '"');

header('Content-Length: ' . filesize($filePath));

header('Expires: 0');

header('Cache-Control: must-revalidate');

header('Pragma: public');

readfile($filePath);


exit;














		}





















	}














	/*=============================================
	MOSTRAR SUMA VENTAS
	=============================================*/

	public static function ctrMostrarSumaUnidades(){

		$tabla = "pasajeros";

		$respuesta = ModeloUnidades::mdlMostrarSumaUnidades($tabla);

		return $respuesta;

	}


}