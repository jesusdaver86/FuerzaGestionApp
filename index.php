<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/trabajadores.controlador.php";
require_once "controladores/operadores.controlador.php";
require_once "controladores/origenes.controlador.php";
require_once "controladores/destinos.controlador.php";
require_once "controladores/marcas.controlador.php";
require_once "controladores/unidades.controlador.php";

require_once "controladores/pasajeros.controlador.php";
/*require_once "controladores/ventas.controlador.php";*/

require_once "modelos/usuarios.modelo.php";
require_once "modelos/trabajadores.modelo.php";
require_once "modelos/operadores.modelo.php";
require_once "modelos/origenes.modelo.php";
require_once "modelos/destinos.modelo.php";
require_once "modelos/marcas.modelo.php";
require_once "modelos/unidades.modelo.php";


require_once "modelos/pasajeros.modelo.php";
/*require_once "modelos/ventas.modelo.php";*/
require_once "extensiones/vendor/autoload.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();