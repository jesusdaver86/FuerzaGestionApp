<?php
date_default_timezone_set("Etc/GMT+4");
setlocale(LC_TIME, "spanish");
/** Error reporting */
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/

/*ini_set('display_errors
/*ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/

/*define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');*/

class ControladorPasajeros{
	




	public static function ctrCrearPasajero(){


	if(isset($_POST["nuevoPasajero"])){


		if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoPasajero"]) &&

		   preg_match('/^[0-9]+$/', $_POST["nuevoDocumentoId"]) &&

		   preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevoNroUnidad"])){


		   	$tabla = "pasajeros";


		   	$datos = array("nombre"=>$_POST["nuevoPasajero"],

				           "documento"=>$_POST["nuevoDocumentoId"],

				           "gerencia"=>$_POST["nuevaGerencia"],

				           "nroUnidad"=>$_POST["nuevoNroUnidad"],

				           "fecha_c"=>$_POST["nuevaFechaC"]);


		   	$respuesta = ModeloPasajeros::mdlIngresarPasajero($tabla, $datos);


		   	if($respuesta == "ok"){


				echo'<script>


					swal({

						  type: "success",

						  title: "El pasajero ha sido guardado correctamente",

						  showConfirmButton: true,

						  confirmButtonText: "Cerrar"

						  }).then(function(result){

									if (result.value) {


									window.location = "pasajeros";


									}

								})


				</script>';


			}


		}else{


			echo'<script>


					swal({

						  type: "error",

						  title: "¡El pasajero no puede ir vacío o llevar caracteres especiales!",

						  showConfirmButton: true,

						  confirmButtonText: "Cerrar"

						  }).then(function(result){

							if (result.value) {


							window.location = "pasajeros";


							}

						})


		  	</script>';




		}


	}


}


	/*=============================================
	MOSTRAR PASAJEROS
	=============================================*/

	public static function ctrMostrarPasajeros($item, $valor){


		$tabla = "pasajeros";


		$respuesta = ModeloPasajeros::mdlMostrarPasajeros($tabla, $item, $valor);


		return $respuesta;


	}

	/*=============================================
	EDITAR PASAJERO
	=============================================*/

	public static function ctrEditarPasajero(){

		if(isset($_POST["editarPasajero"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarPasajero"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editarDocumentoId"]) &&
			   preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["editarNroUnidad"])){

			   	$tabla = "pasajeros";

			   	$datos = array("id"=>$_POST["idPasajero"],
			   			
			   				   "nombre"=>$_POST["editarPasajero"],
					           "documento"=>$_POST["editarDocumentoId"],
					           "gerencia"=>$_POST["editarGerencia"],
					           "nroUnidad"=>$_POST["editarNroUnidad"],
					           "fecha_c"=>$_POST["editarFechaC"]);

			   	$respuesta = ModeloPasajeros::mdlEditarPasajero($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El pasajero ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "pasajeros";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El pasajero no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "pasajeros";

							}
						})

			  	</script>';



			}


		}


	}




	

	/*=============================================
	ELIMINAR PASAJERO
	=============================================*/

	public static function ctrEliminarPasajero(){

		if(isset($_GET["idPasajero"])){

			$tabla ="pasajeros";
			$datos = $_GET["idPasajero"];

			$respuesta = ModeloPasajeros::mdlEliminarPasajero($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El pasajero ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result){
								if (result.value) {

								window.location = "pasajeros";

								}
							})

				</script>';

			}		

		}

	}



	public static function ctrRangoFechasPasajeros($fechaInicial, $fechaFinal) {

    $tabla = "pasajeros";

    $respuesta = ModeloPasajeros::mdlMostrarSumaPasajeros($tabla, $fechaInicial, $fechaFinal);


return $respuesta;

    

}



/*=============================================
	DESCARGAR EXCEL
	=============================================*/

	public function ctrDescargarReportePasajeros(){

		if(isset($_GET["reportep"])){



			$tabla = "pasajeros";


            


				$item = null;
				$valor = null;

				$ventas = ModeloPasajeros::mdlMostrarPasajeros($tabla, $item, $valor);


$tempFile = tempnam(sys_get_temp_dir(), 'excel_');




 $objPHPExcel = new PHPExcel();


$objPHPExcel->getActiveSheet()->setCellValue('G1', PHPExcel_Shared_Date::PHPToExcel(gmmktime(0, 0, 0, date('m'), date('d'), date('Y'))));
$objPHPExcel->getActiveSheet()->getStyle('G1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX15);


$objPHPExcel->getActiveSheet()->setCellValue('A3', 'RUTA');

$objPHPExcel->getActiveSheet()->setCellValue('B3', 'NOMBRE');

$objPHPExcel->getActiveSheet()->setCellValue('C3', 'CEDULA');

$objPHPExcel->getActiveSheet()->setCellValue('D3', 'GERENCIA');

$objPHPExcel->getActiveSheet()->setCellValue('E3', 'FECHA');

$objPHPExcel->getActiveSheet()->setCellValue('F3', 'ESTADO');

$objPHPExcel->getActiveSheet()->setCellValue('G3', 'FECHA MODIFIC');

$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(4, 50);


// Add data to the spreadsheet
$row = 4;

$i = 1;

foreach ($ventas as $item) {
    // Add a new row for each record
$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $item["nroUnidad"]);

$objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $item["nombre"]);

$objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $item["documento"]);

$objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $item["gerencia"]);

$objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $item["fecha_c"]);

$objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $item["estado"]);

/*$objPHPExcel->getActiveSheet()->setCellValue('I' . $row, substr($item["fecha"], 0, 10));*/

$objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $item["fecha"]);
    $row++;
    $i++;


 $styleRange = 'A' . $row . ':I' . $i;

    
$styleThinBlackBorderOutline = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
);


        $objPHPExcel->getActiveSheet()->getStyle($styleRange)->applyFromArray($styleThinBlackBorderOutline);

}




$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');

$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);




$objPHPExcel->setActiveSheetIndex(0);




$objPHPExcel->getActiveSheet()->setTitle('Movilizacion de Personal');



$ruta = "vistas/img/plantilla/logo-blanco-bloque.png";

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../../vistas/img/plantilla/logo-blanco-bloque.png');
$objDrawing->setHeight(36);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());





$objRichText = new PHPExcel_RichText();
$objRichText->createText('Movilizacion de Personal');

$objPayable = $objRichText->createTextRun(' ');
$objPayable->getFont()->setBold(true);
$objPayable->getFont()->setItalic(true);
$objPayable->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_DARKGREEN ) );

$objRichText->createText(' ');

$objPHPExcel->getActiveSheet()->getCell('C1')->setValue($objRichText); 



$objPHPExcel->getActiveSheet()->mergeCells('C1:E1');
$objPHPExcel->getActiveSheet()->mergeCells('C1:D1');    
$objPHPExcel->getActiveSheet()->unmergeCells('C1:D1');  




// Configuración de protección de celdas

$contraseña = 'PHPExcel17';
$objPHPExcel->getActiveSheet()->getProtection()->setPassword($contraseña);

$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);


$objPHPExcel->getActiveSheet()->protectCells('A:Z', $contraseña);


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);



$styleThickBrownBorderOutline = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK,
            'color' => array('argb' => 'FF993300'),
        ),
    ),
);








// Set document theme

        /*$objPHPExcel->getProperties()->setTheme('MyTheme');*/


        // Set cell styles

            // Set cell styles

        $styleArray = array(

            'font' => array(

                'bold' => true,

            ),

            'alignment' => array(

                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,

            ),

            'borders' => array(

                'top' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN,

                ),

            ),

            'fill' => array(

                'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,

                'rotation' => 90,

                'startcolor' => array(

                    'argb' => 'FFA0A0A0',

                ),

                'endcolor' => array(

                    'argb' => 'FFFFFFFF',

                ),

            ),

        );


        $objPHPExcel->getActiveSheet()->getStyle('A1:U3')->applyFromArray($styleArray);


        // Set header styles

        $objPHPExcel->getActiveSheet()->getStyle('A1:G2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

        $objPHPExcel->getActiveSheet()->getStyle('A1:G2')->getFill()->getStartColor()->setARGB('FF808080');


        // Set table header styles

        $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray(

            array(

                'font' => array(

                    'bold' => true,

                ),

                'alignment' => array(

                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,

                ),

                'borders' => array(

                    'top' => array(

                        'style' => PHPExcel_Style_Border::BORDER_THIN,

                    ),

                ),

                'fill' => array(

                    'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,

                    'rotation' => 90,

                    'startcolor' => array(

                        'argb' => 'FFA0A0A0',

                    ),

                    'endcolor' => array(

                        'argb' => 'FFFFFFFF',

                    ),

                ),

            )

        );


        // Set individual cell styles

        $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray(

            array(

                'alignment' => array(

                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,

                ),

                'borders' => array(

                    'left' => array(

                        'style' => PHPExcel_Style_Border::BORDER_THIN,

                    ),

                ),

            )

        );

          $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray(

            array(

                'alignment' => array(

                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,

                ),

            )

        );
            $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray(

            array(

                'alignment' => array(

                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,

                ),

            )

        );

              $objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray(

            array(

                'alignment' => array(

                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,

                ),

            )

        );

                $objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray(

            array(

                'alignment' => array(

                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,

                ),

            )

        );

                  $objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray(

            array(

                'alignment' => array(

                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,

                ),

            )

        );


        $objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray(

            array(

                'alignment' => array(

                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,

                ),

            )

        );


        $objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray(

            array(

                'borders' => array(

                    'right' => array(

                        'style' => PHPExcel_Style_Border::BORDER_THIN,

                    ),

                ),

            )

        );


        // Set font styles

        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setName('Candara');

        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(20);

        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);

        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);


        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);


        // Set alignment styles

        $objPHPExcel->getActiveSheet()->getStyle('D11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->getActiveSheet()->getStyle('D12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->getActiveSheet()->getStyle('D13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


        $objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);

        $objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


        $objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setShrinkToFit(true);


        // Set table styles

        $tableStyleArray = array(

            'font' => array(

                'bold' => true,

            ),

            'alignment' => array(

                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,

            ),

            'borders' => array(

                'outline' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN,

                ),

            ),

        );


        $objPHPExcel->getActiveSheet()->getStyle('A4:G' . ($row + 1))->applyFromArray($tableStyleArray);



$objPHPExcel->getActiveSheet()->insertNewRowBefore(6, 10);
$objPHPExcel->getActiveSheet()->removeRow(6, 10);
$objPHPExcel->getActiveSheet()->insertNewColumnBefore('E', 5);
$objPHPExcel->getActiveSheet()->removeColumn('E', 5);



$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BInvoice&RPrinted on &D');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');


$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);


$objPHPExcel->getActiveSheet()->setTitle('Pasajeros');



ob_end_clean(); 

// Generar archivo Excel

$tempFile = sys_get_temp_dir(). '/excel_'. uniqid(). '.xlsx';

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save($tempFile);



// Descargar archivo Excel

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

header('Content-Disposition: inline; filename="Reporte Pasajeros.xlsx"');

header('Content-Length: '. filesize($tempFile));

header('Expires: 0');

header('Cache-Control: must-revalidate');

header('Pragma: public');

readfile($tempFile);

exit;


}}}  






	



