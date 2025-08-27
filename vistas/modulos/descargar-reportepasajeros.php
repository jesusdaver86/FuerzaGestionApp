<?php
require_once "../../controladores/unidades.controlador.php";
require_once "../../modelos/unidades.modelo.php";
require_once "../../controladores/operadores.controlador.php";
require_once "../../modelos/operadores.modelo.php";
require_once "../../controladores/origenes.controlador.php";
require_once "../../modelos/origenes.modelo.php";
require_once "../../controladores/destinos.controlador.php";
require_once "../../modelos/destinos.modelo.php";
require_once "../../controladores/pasajeros.controlador.php";
require_once "../../modelos/pasajeros.modelo.php";
require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";
/** Include PHPExcel */
require_once "../../node_modules/PHPExcel/Classes/PHPExcel.php";

require_once "../../node_modules/PHPExcel/Classes/PHPExcel/IOFactory.php";

$reportep = new ControladorPasajeros();
$reportep -> ctrDescargarReportePasajeros();