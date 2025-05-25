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
	    $response = []; 

	    if(isset($_POST["nuevoPasajero"])){ // Outer check
	        $valid_gerencia_regex = '/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\/\-\.\_ ]+$/'; 
	        $valid_fecha_regex = '/^\d{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])$/';

	        // Initial validation using $_POST
	        if(isset($_POST["nuevoPasajero"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoPasajero"]) &&
	           isset($_POST["nuevoDocumentoId"]) && preg_match('/^[0-9]+$/', $_POST["nuevoDocumentoId"]) &&
	           isset($_POST["nuevaGerencia"]) && preg_match($valid_gerencia_regex, $_POST["nuevaGerencia"]) &&
	           isset($_POST["nuevoNroUnidad"]) && preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevoNroUnidad"]) &&
	           isset($_POST["nuevaFechaC"]) && preg_match($valid_fecha_regex, $_POST["nuevaFechaC"])
	        ){
	            // Assign to local variables after passing initial checks
	            $nombre = $_POST["nuevoPasajero"];
	            $documentoId = $_POST["nuevoDocumentoId"];
	            $gerencia = $_POST["nuevaGerencia"];
	            $nroUnidad = $_POST["nuevoNroUnidad"];
	            $fechaC = $_POST["nuevaFechaC"];

	            $date_parts = explode('/', $fechaC); // Use local variable
	            if (checkdate((int)$date_parts[1], (int)$date_parts[2], (int)$date_parts[0])) {
	                $tabla = "pasajeros";
	                $datos = array(
	                    "nombre"=>$nombre,
	                    "documento"=>$documentoId,
	                    "gerencia"=>$gerencia,
	                    "nroUnidad"=>$nroUnidad,
	                    "fecha_c"=>$fechaC
	                );
	                $respuesta_modelo = ModeloPasajeros::mdlIngresarPasajero($tabla, $datos);

	                if($respuesta_modelo == "ok"){
	                    $response = ["status" => "success", "message" => "El pasajero ha sido guardado correctamente"];
	                } else {
	                    $response = ["status" => "error", "message" => "Error al guardar el pasajero: " . ($respuesta_modelo ?: "Error desconocido del modelo.")];
	                }
	            } else {
	                $response = ["status" => "error", "message" => "¡La fecha proporcionada no es válida!"];
	            }
	        } else {
	            $response = ["status" => "error", "message" => "¡Todos los campos son obligatorios y deben tener formatos válidos! Por favor, revise el nombre, documento, gerencia, nro. de unidad y fecha."];
	        }
	    } else {
	        $response = ["status" => "error", "message" => "No se recibieron datos del formulario."];
	    }
	    echo json_encode($response);
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
	    $response = []; 

	    if(isset($_POST["idPasajero"])){ 
	        $valid_gerencia_regex = '/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\/\-\.\_ ]+$/';
	        $valid_fecha_regex = '/^\d{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])$/';

	        // Initial validation using $_POST
	        if(isset($_POST["idPasajero"]) && filter_var($_POST["idPasajero"], FILTER_VALIDATE_INT) && ((int)$_POST["idPasajero"] > 0) &&
	           isset($_POST["editarPasajero"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarPasajero"]) &&
	           isset($_POST["editarDocumentoId"]) && preg_match('/^[0-9]+$/', $_POST["editarDocumentoId"]) &&
	           isset($_POST["editarGerencia"]) && preg_match($valid_gerencia_regex, $_POST["editarGerencia"]) &&
	           isset($_POST["editarNroUnidad"]) && preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["editarNroUnidad"]) &&
	           isset($_POST["editarFechaC"]) && preg_match($valid_fecha_regex, $_POST["editarFechaC"])
	        ){
	            // Assign to local variables after passing initial checks
	            $idPasajero = (int)$_POST["idPasajero"];
	            $editarPasajeroNombre = $_POST["editarPasajero"];
	            $editarDocumentoId = $_POST["editarDocumentoId"];
	            $editarGerencia = $_POST["editarGerencia"];
	            $editarNroUnidad = $_POST["editarNroUnidad"];
	            $editarFechaC = $_POST["editarFechaC"];

	            $date_parts = explode('/', $editarFechaC); // Use local variable
	            if (checkdate((int)$date_parts[1], (int)$date_parts[2], (int)$date_parts[0])) {
	                $tabla = "pasajeros";
	                $datos = array(
	                    "id"=>$idPasajero,
	                    "nombre"=>$editarPasajeroNombre,
	                    "documento"=>$editarDocumentoId,
	                    "gerencia"=>$editarGerencia,
	                    "nroUnidad"=>$editarNroUnidad,
	                    "fecha_c"=>$editarFechaC
	                );
	                $respuesta_modelo = ModeloPasajeros::mdlEditarPasajero($tabla, $datos);

	                if($respuesta_modelo == "ok"){
	                    $response = ["status" => "success", "message" => "El pasajero ha sido cambiado correctamente"];
	                } else {
	                    $response = ["status" => "error", "message" => "Error al actualizar el pasajero en la base de datos."];
	                }
	            } else {
	                $response = ["status" => "error", "message" => "¡La fecha 'Editar Fecha' proporcionada no es válida!"];
	            }
	        } else {
	            $response = ["status" => "error", "message" => "¡Todos los campos para editar son obligatorios y deben tener formatos válidos! Por favor, revise el ID, nombre, documento, gerencia, nro. de unidad y fecha."];
	        }
	    } else {
	        $response = ["status" => "error", "message" => "ID de pasajero no proporcionado para la edición."];
	    }
	    echo json_encode($response);
	}




	

	/*=============================================
	ELIMINAR PASAJERO
	=============================================*/

	public static function ctrEliminarPasajero(){
	    header('Content-Type: application/json'); 
	    $response = []; 

	    if(isset($_POST["idPasajero"])){ 
	        $idPasajero = $_POST["idPasajero"]; // Assign to local variable
	        if(filter_var($idPasajero, FILTER_VALIDATE_INT) && (int)$idPasajero > 0) {
	            $tabla = "pasajeros";
	            $datos = (int)$idPasajero; // Use casted local variable

	            $respuesta_modelo = ModeloPasajeros::mdlEliminarPasajero($tabla, $datos);

	            if($respuesta_modelo == "ok"){
	                $response = ["status" => "success", "message" => "El pasajero ha sido borrado correctamente"];
	            } else {
	                $response = ["status" => "error", "message" => "Error al borrar el pasajero. Es posible que esté asociado a otros registros."]; 
	            }
	        } else {
	            $response = ["status" => "error", "message" => "El identificador del pasajero no es válido."];
	        }     
	    } else {
	        $response = ["status" => "error", "message" => "No se proporcionó ID de pasajero."];
	    }
	    echo json_encode($response);
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
            // $reportep = $_GET["reportep"]; // Value not used, so assignment isn't critical

			$tabla = "pasajeros";
            
            // These are not from $_GET or $_POST, so no change needed here.
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



// $ruta = "vistas/img/plantilla/logo-blanco-bloque.png"; // Original line

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');

$logoPathOriginal = '../../vistas/img/plantilla/logo-blanco-bloque.png'; // Original path for fallback
// Path construction as per prompt's specific instruction:
$logoPathAttempt = dirname(__FILE__) . '/../../vistas/img/plantilla/logo-blanco-bloque.png';
$absoluteLogoPath = realpath($logoPathAttempt);

if ($absoluteLogoPath && file_exists($absoluteLogoPath)) {
    $objDrawing->setPath($absoluteLogoPath);
} else {
    // Fallback to original path if realpath fails or file doesn't exist at absolute path
    // Consider logging an error here in a real application
    $objDrawing->setPath($logoPathOriginal); 
    // For debugging, one might add: error_log("Logo not found at attempted absolute path: " . $logoPathAttempt . ", nor at realpath: " . $absoluteLogoPath . ". Falling back to: " . $logoPathOriginal);
}

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

/*
$contraseña = 'PHPExcel17';
$objPHPExcel->getActiveSheet()->getProtection()->setPassword($contraseña);
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->protectCells('A:Z', $contraseña);
*/


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
