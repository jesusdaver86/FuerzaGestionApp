<?php
require_once "../controladores/trabajadores.controlador.php";

require_once "../modelos/trabajadores.modelo.php";


$trabajadors = ControladorTrabajadores::ctrMostrarTrabajadores(null, null);


echo json_encode($trabajadors);

?>