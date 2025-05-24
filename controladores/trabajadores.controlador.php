<?php
/*error_reporting(E_ALL); ini_set('display_errors', 1);*/

class ControladorTrabajadores {

public static function ctrCrearTrabajador() {


    if (isset($_POST["nuevoTrabajador"])) {


        if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&

            preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoTrabajador"]) &&

            filter_var($_POST["nuevoCorreo"], FILTER_VALIDATE_EMAIL) &&

            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCargo"]) &&

            preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $_POST["nuevaFechaNacimiento"]) &&

            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ#.,\s]+$/', $_POST["nuevaDireccion"]) &&

            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ#.,\s]+$/', $_POST["nuevaCartaMedica"]) &&

            preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ#.,\s]+$/', $_POST["nuevoCertificadoManejo"])) {


            $tabla = "trabajadores";

            $ruta = "";


            $directorio = "vistas/img/files/" . $_POST["nuevoTrabajador"];


            // Verificar si el directorio existe, si no existe, crearlo

            if (!file_exists($directorio)) {

                if (!mkdir($directorio, 0755, true)) {

                    echo 'Error al crear el directorio';

                    return;

                }

            }


            // Crear carpetas para foto, carta médica y certificado de manejo

            $rutaFoto = $directorio . "/foto";

            $rutaFotoDocumento = $directorio . "/fotoDocumento";

            $rutaFotoCarnet = $directorio . "/fotoCarnet";

            $rutaCartaMedica = $directorio . "/cartaMedica";

            $rutaCertificadoManejo = $directorio . "/certificadoManejo";

            $rutanroLicencia = $directorio . "/nroLicencia";


            if (!file_exists($rutaFoto)) {

                mkdir($rutaFoto, 0755, true);

            }

            if (!file_exists($rutaFotoDocumento)) {

                mkdir($rutaFotoDocumento, 0755, true);

            }

            if (!file_exists($rutaFotocarnet)) {

                mkdir($rutaFotoCarnet, 0755, true);

            }


            if (!file_exists($rutaCartaMedica)) {

                mkdir($rutaCartaMedica, 0755, true);

            }


            if (!file_exists($rutaCertificadoManejo)) {

                mkdir($rutaCertificadoManejo, 0755, true);

            }

            if (!file_exists($rutaNroLicencia)) {

                mkdir($rutaNroLicencia, 0755, true);

            }


            if (isset($_FILES["nuevaFoto"]["tmp_name"])) {


                // Verificar si el archivo subido es válido


                if ($_FILES["nuevaFoto"]["error"] == 0 && $_FILES["nuevaFoto"]["size"] > 0) {


                    list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);


                    $nuevoAncho = 500;

                    $nuevoAlto = 500;


                    if ($_FILES["nuevaFoto"]["type"] == "image/jpeg") {


                        $aleatorio = mt_rand(100, 999);


                        $ruta = $rutaFoto . "/" . $aleatorio . ".jpg";


                        $origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);


                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);


                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);


                        imagejpeg($destino, $ruta);


                    }


                    if ($_FILES["nuevaFoto"]["type"] == "image/png") {


                        $aleatorio = mt_rand(100, 999);


                        $ruta = $rutaFoto . "/" . $aleatorio . ".png";


                        $origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);


                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);


                        imagealphablending($destino, 1);


                        imagesavealpha($destino, TRUE);


                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $newAlto, $ancho, $alto);


                        imagepng($destino, $ruta);


                    }


                } else {


                    echo 'Error al subir archivo';


                    return;


                    $ruta = "";


                }


            }


                $fotoDocumento = "";


            if (isset($_FILES["nuevaFotoDocumento"]["tmp_name"])) {


                if ($_FILES["nuevaFotoDocumento"]["error"] == 0 && $_FILES["nuevaFotoDocumento"]["size"] > 0) {


                    $archivo = $_FILES["nuevaFotoDocumento"]["tmp_name"];


                    $nombreArchivo = basename($_FILES["nuevaFotoDocumento"]["name"]);


                    $fotoDocumento = $rutaFotoDocumento . "/" . $nombreArchivo;


                    if (move_uploaded_file($archivo, $fotoDocumento)) {


                        // Mensaje de exito al subir el archivo


                    } else {


                        // Mensaje de error al subir el archivo


                    }


                } else {


                    // Mensaje de error al subir el archivo


                }


            }


              $fotoCarnet= "";


            if (isset($_FILES["nuevaFotoCarnet"]["tmp_name"])) {


                if ($_FILES["nuevaFotoCarnet"]["error"] == 0 && $_FILES["nuevaFotoCarnet"]["size"] > 0) {


                    $archivo = $_FILES["nuevaFotoCarnet"]["tmp_name"];


                    $nombreArchivo = basename($_FILES["nuevaFotoCarnet"]["name"]);


                    $fotoCarnet = $rutaFotoCarnet . "/" . $nombreArchivo;


                    if (move_uploaded_file($archivo, $fotoCarnet)) {


                        // Mensaje de exito al subir el archivo


                    } else {


                        // Mensaje de error al subir el archivo


                    }


                } else {


                    // Mensaje de error al subir el archivo


                }


            }


            $cartaMedica = "";


            if (isset($_FILES["nuevaCartaMedica"]["tmp_name"])) {


                if ($_FILES["nuevaCartaMedica"]["error"] == 0 && $_FILES["nuevaCartaMedica"]["size"] > 0) {


                    $archivo = $_FILES["nuevaCartaMedica"]["tmp_name"];


                    $nombreArchivo = basename($_FILES["nuevaCartaMedica"]["name"]);


                    $cartaMedica = $rutaCartaMedica . "/" . $nombreArchivo;


                    if (move_uploaded_file($archivo, $cartaMedica)) {


                        // Mensaje de exito al subir el archivo


                    } else {


                        // Mensaje de error al subir el archivo


                    }


                } else {


                    // Mensaje de error al subir el archivo


                }


            }


            $certificadoManejo = "";


            if (isset($_FILES["nuevoCertificadoManejo"]["tmp_name"])) {


                if ($_FILES["nuevoCertificadoManejo"]["error"] == 0 && $_FILES["nuevoCertificadoManejo"]["size"] > 0) {


                    $archivo = $_FILES["nuevoCertificadoManejo"]["tmp_name"];


                    $nombreArchivo = basename($_FILES["nuevoCertificadoManejo"]["name"]);


                    $certificadoManejo = $rutaCertificadoManejo . "/" . $nombreArchivo;


                    if (move_uploaded_file($archivo, $certificadoManejo)) {


                        // Mensaje de exito al subir el archivo


                    } else {


                        // Mensaje de error al subir el archivo


                    }


                } else {


                    // Mensaje de error al subir el archivo


                }


            }


              $nroLicencia = "";


            if (isset($_FILES["nuevoNroLicencia"]["tmp_name"])) {


                if ($_FILES["nuevoNroLicencia"]["error"] == 0 && $_FILES["nuevoNroLicencia"]["size"] > 0) {


                    $archivo = $_FILES["nuevoNroLicencia"]["tmp_name"];


                    $nombreArchivo = basename($_FILES["nuevoNroLicencia"]["name"]);


                    $nroLicencia = $rutaNroLicencia . "/" . $nombreArchivo;


                    if (move_uploaded_file($archivo, $nroLicencia)) {


                        // Mensaje de exito al subir el archivo


                    } else {


                        // Mensaje de error al subir el archivo


                    }


                } else {


                    // Mensaje de error al subir el archivo


                }


            }


            $trabajador = new Trabajador($_POST["nuevoTrabajador"], $_POST["nuevoApellido"], $_POST["nuevoTelefono"], $_POST["nuevoCargo"], $ruta, $cartaMedica, $certificadoManejo);


            if ($this->insertar($trabajador)) {


                // Mensaje de exito al insertar el trabajador


            } else {


                // Mensaje de error al insertar el trabajador


            }


        } else {


            // Mensaje de error al verificar los datos


        }


    }
    }






	public static function ctrMostrarTrabajadores($item, $valor){

		$tabla = "trabajadores";

		$respuesta = ModeloTrabajadores::mdlMostrarTrabajadores($tabla, $item, $valor);

		return $respuesta;




	}



/*

public static function ctrMostrarTrabajadoresJSON($item, $valor){

    $tabla = "trabajadores";

    $respuesta = ModeloTrabajadores::mdlMostrarTrabajadores($tabla, $item, $valor);

    return json_encode($respuesta);

}
*/



			public function ctrActualizarTrabajador(){

			    if(isset($_POST["actualizarTrabajador"])){

			        if(preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚ ]+$/', $_POST["actualizarNombre"]) &&
			           preg_match('/^[a-zA-Z0-9]+$/', $_POST["actualizarTrabajador"])){

			            $tabla = "trabajadores";

			            $id = $_POST["idTrabajador"];

			            $fotoAnterior = $_POST["fotoAnterior"];

			            $cartaMedicaAnterior = $_POST["cartaMedicaAnterior"];

			            $certificadoManejoAnterior = $_POST["certificadoManejoAnterior"];

			            $directorio = "vistas/img/files/".$_POST["actualizarTrabajador"];

			            if(!empty($_FILES["actualizarFoto"]["tmp_name"])){

			                list($ancho, $alto) = getimagesize($_FILES["actualizarFoto"]["tmp_name"]);

			                $nuevoAncho = 500;
			                $nuevoAlto = 500;

			                if($_FILES["actualizarFoto"]["type"] == "image/jpeg"){

			                    $aleatorio = mt_rand(100,999);

			                    $ruta = "vistas/img/files/".$_POST["actualizarTrabajador"]."/".$aleatorio.".jpg";

			                    $origen = imagecreatefromjpeg($_FILES["actualizarFoto"]["tmp_name"]);

			                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			                    imagejpeg($destino, $ruta);

			                }

			                if($_FILES["actualizarFoto"]["type"] == "image/png"){

			                    $aleatorio = mt_rand(100,999);

			                    $ruta = "vistas/img/files/".$_POST["actualizarTrabajador"]."/".$aleatorio.".png";

			                    $origen = imagecreatefrompng($_FILES["actualizarFoto"]["tmp_name"]);

			                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			                    imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

			                    imagepng($destino, $ruta);

			                }

			            }else{

			                $ruta = $fotoAnterior;

			            }

			            if(!empty($_FILES["actualizarCartaMedica"]["tmp_name"])){

			                $rutaCartaMedica = "vistas/img/files/".$_POST["actualizarTrabajador"]."/cartaMedica.pdf";

			                move_uploaded_file($_FILES["actualizarCartaMedica"]["tmp_name"], $rutaCartaMedica);

			            }else{

			                $rutaCartaMedica = $cartaMedicaAnterior;

			            }

			            if(!empty($_FILES["actualizarCertificadoManejo"]["tmp_name"])){

			                $rutaCertificadoManejo = "vistas/img/files/".$_POST["actualizarTrabajador"]."/certificadoManejo.pdf";

			                move_uploaded_file($_FILES["actualizarCertificadoManejo"]["tmpname"], $rutaCertificadoManejo);

			            }else{

			                $rutaCertificadoManejo = $certificadoManejoAnterior;

			            }

			            $datos = array("id"=>$id,

			                           "nombre"=>$_POST["actualizarNombre"],

			                           "correo"=>$_POST["actualizarCorreo"],

			                           "cargo"=>$_POST["actualizarCargo"],

			                           "fechaNacimiento"=>$_POST["actualizarFechaNacimiento"],

			                           "direccion"=>$_POST["actualizarDireccion"],

			                           "foto"=>$ruta,

			                           "cartaMedica"=>$rutaCartaMedica,

			                           "certificadoManejo"=>$rutaCertificadoManejo);

			            $respuesta = ModeloTrabajadores::mdlActualizarTrabajador($tabla, $datos);

			            if($respuesta == "ok"){

			                echo '<script>

			                        swal({

			                            type: "success",
			                            title: "El trabajador ha sido actualizado correctamente",
			                            showConfirmButton: true,
			                            confirmButtonText: "Cerrar"

			                            }).then(function(result){

			                                        if (result.value){

			                                            window.location = "trabajadores";

			                                        }

			                                    });

			                            </script>';

			            }else{

			                echo '<script>

			                        swal({

			                            type: "error",
			                            title: "El trabajador no pudo ser actualizado",
			                            showConfirmButton: true,
			                            confirmButtonText: "Cerrar"

			                            }).then(function(result){

			                                    if (result.value){

			                                        window.location = "trabajadores";

			                                    }

			                                });

			                            </script>';

			            }

			        }else{

			            echo '<script>

			                    swal({

			                        type: "error",
			                        title: "Error: Los nombres y correos electrónicos no pueden estar vacíos ni contener caracteres especiales",
			                        showConfirmButton: true,
			                        confirmButtonText: "Cerrar"

			                    }).then(function(result){

			                            if (result.value){

			                                window.location = "trabajadores";

			                            }

			                        });

			                    </script>';

			        }

			    }

			}
	




	public static function ctrBorrarTrabajador(){

		if(isset($_GET["idTrabajador"])){

			$tabla = "trabajadores";
			$datos = array("id"=>$_GET["idTrabajador"]);

			$respuesta = ModeloTrabajadores::mdlBorrarTrabajador($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "El trabajador ha sido eliminado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						}).then(function(result) {
								if (result.value) {

								window.location = "trabajadores";

								}
							})

				</script>';

			}

		}
	}




/*=============================================
    DESCARGAR EXCEL
    =============================================*/

    public function ctrDescargarReporteTrabajadores(){

        if(isset($_GET["reportet"])){



            $tabla = "trabajadores";





 // Obtener el valor de búsqueda
        $searchValue = isset($_GET['search']) ? $_GET['search'] : null;
        // Obtener los datos filtrados
        $ventas = ModeloTrabajadores::mdlMostrarTrabajadores($tabla, $searchValue);














/*
        $item = isset($_GET['item']) ? $_GET['item'] : null;
        $valor = isset($_GET['valor']) ? $_GET['valor'] : null;

      
        $ventas = ModeloTrabajadores::mdlMostrarTrabajadores($tabla, $item, $valor);

*/
            















/*
                $item = null;
                $valor = null;

                $ventas = ModeloTrabajadores::mdlMostrarTrabajadores($tabla, $item, $valor); */


$tempFile = tempnam(sys_get_temp_dir(), 'excel_');




 $objPHPExcel = new PHPExcel();


$objPHPExcel->getActiveSheet()->setCellValue('U1', PHPExcel_Shared_Date::PHPToExcel(gmmktime(0, 0, 0, date('m'), date('d'), date('Y'))));
$objPHPExcel->getActiveSheet()->getStyle('U1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX15);


$objPHPExcel->getActiveSheet()->setCellValue('A3', 'ID');

$objPHPExcel->getActiveSheet()->setCellValue('B3', 'NOMBRE');

$objPHPExcel->getActiveSheet()->setCellValue('C3', 'CEDULA');

$objPHPExcel->getActiveSheet()->setCellValue('D3', 'CORREO');

$objPHPExcel->getActiveSheet()->setCellValue('E3', 'FECHA DE NACIMIENTO');

$objPHPExcel->getActiveSheet()->setCellValue('F3', 'DIRECCION');

$objPHPExcel->getActiveSheet()->setCellValue('G3', 'CARGO');

$objPHPExcel->getActiveSheet()->setCellValue('H3', 'SEGUNDA LINEA GERENCIA');

$objPHPExcel->getActiveSheet()->setCellValue('I3', 'FOTO');

$objPHPExcel->getActiveSheet()->setCellValue('J3', 'FOTO DOCUMENTO');

$objPHPExcel->getActiveSheet()->setCellValue('K3', 'FOTO CARNET');

$objPHPExcel->getActiveSheet()->setCellValue('L3', 'CARTA MEDICA');

$objPHPExcel->getActiveSheet()->setCellValue('M3', 'CERTIFICADO MANEJO');

$objPHPExcel->getActiveSheet()->setCellValue('N3', 'NRO LICENCIA');

$objPHPExcel->getActiveSheet()->setCellValue('O3', 'ESTADO');

$objPHPExcel->getActiveSheet()->setCellValue('P3', 'FECHA VENCIMIENTO DOCUMENTO');

$objPHPExcel->getActiveSheet()->setCellValue('Q3', 'FECHA VENCIMIENTO CARTA MEDICA');

$objPHPExcel->getActiveSheet()->setCellValue('R3', 'FECHA VENCIMIENTO CERTIFICADO MANEJO');

$objPHPExcel->getActiveSheet()->setCellValue('S3', 'FECHA VENCIMIENTO LICENCIA');

$objPHPExcel->getActiveSheet()->setCellValue('T3', 'TIPO NOMINA');

$objPHPExcel->getActiveSheet()->setCellValue('U3', 'CREATED AT');

$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(4, 50);



$row = 4;

$i = 1;

foreach ($ventas as $item) {

$objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $item["id"]);

    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $item["nombre"]);

    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $item["cedula"]);

    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $item["correo"]);

    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $item["fechaNacimiento"]);

    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $item["direccion"]);

    $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $item["cargo"]);

    $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $item["segundaLineaGerencia"]);

    $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $item["foto"]);

    $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $item["fotoDocumento"]);

    $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $item["fotoCarnet"]);

    $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $item["cartaMedica"]);

    $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $item["certificadoManejo"]);

    $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $item["nroLicencia"]);

    $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $item["estado"]);

    $objPHPExcel->getActiveSheet()->setCellValue('P' . $row, $item["fechaVencimientoDocumento"]);

    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $row, $item["fechaVencimientoCartaMedica"]);

    $objPHPExcel->getActiveSheet()->setCellValue('R' . $row, $item["fechaVencimientoCertificadoManejo"]);

    $objPHPExcel->getActiveSheet()->setCellValue('S' . $row, $item["fechaVencimientoLicencia"]);

    $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $item["tipoNomina"]);

    $objPHPExcel->getActiveSheet()->setCellValue('U' . $row, $item["created_at"]);
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




$objPHPExcel->getActiveSheet()->setTitle('Fuerza Laboral');



$ruta = "vistas/img/plantilla/logo-blanco-bloque.png";

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../../vistas/img/plantilla/logo-blanco-bloque.png');
$objDrawing->setHeight(36);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());





$objRichText = new PHPExcel_RichText();
$objRichText->createText('Fuerza Laboral');

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

$contraseña = 'PHPExcel';
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
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);

/*
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);



$objPHPExcel->getActiveSheet()->getStyle('D11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('D12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('D13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
$objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setShrinkToFit(true);*/





$styleThickBrownBorderOutline = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK,
            'color' => array('argb' => 'FF993300'),
        ),
    ),
);



/*

$objPHPExcel->getActiveSheet()->getStyle('A1:G2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:G2')->getFill()->getStartColor()->setARGB('FF808080');


$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray(
        array(
            'font'    => array(
                'bold'      => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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

$objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray(
        array(
            'borders' => array(
                'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        )
);



$objPHPExcel->getActiveSheet()->getStyle('B1')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
*/



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

        $objPHPExcel->getActiveSheet()->getStyle('A1:U2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

        $objPHPExcel->getActiveSheet()->getStyle('A1:U2')->getFill()->getStartColor()->setARGB('FF808080');


        // Set table header styles

        $objPHPExcel->getActiveSheet()->getStyle('A3:U3')->applyFromArray(

            array(

                'font' => array(

                    'bold' => true,

                ),

                'alignment' => array(

                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,

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

                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,

                ),

                'borders' => array(

                    'left' => array(

                        'style' => PHPExcel_Style_Border::BORDER_THIN,

                    ),

                ),

            )

        );


        $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray(

            array(

                'alignment' => array(

                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,

                ),

            )

        );


        $objPHPExcel->getActiveSheet()->getStyle('U3')->applyFromArray(

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

            ),

            'borders' => array(

                'outline' => array(

                    'style' => PHPExcel_Style_Border::BORDER_THIN,

                ),

            ),

        );


        $objPHPExcel->getActiveSheet()->getStyle('A4:U' . ($row + 1))->applyFromArray($tableStyleArray);



$objPHPExcel->getActiveSheet()->insertNewRowBefore(6, 10);
$objPHPExcel->getActiveSheet()->removeRow(6, 10);
$objPHPExcel->getActiveSheet()->insertNewColumnBefore('E', 5);
$objPHPExcel->getActiveSheet()->removeColumn('E', 5);



$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BInvoice&RPrinted on &D');
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');


$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);


$objPHPExcel->getActiveSheet()->setTitle('Trabajadores');



ob_end_clean(); 

// Generar archivo Excel

$tempFile = sys_get_temp_dir(). '/excel_'. uniqid(). '.xlsx';

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save($tempFile);



// Descargar archivo Excel

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

header('Content-Disposition: inline; filename="Reporte Trabajadores.xlsx"');

header('Content-Length: '. filesize($tempFile));

header('Expires: 0');

header('Cache-Control: must-revalidate');

header('Pragma: public');

readfile($tempFile);

exit;


}}}  



