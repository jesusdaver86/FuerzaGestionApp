<?php

// It's crucial to include the necessary controller and model files.
// The exact paths might depend on your project's autoloading or include structure.
// Assuming direct relative paths from the 'ajax' directory for now.
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php"; // Though controller usually handles model includes.
// If an autoloader is set up (e.g., via composer), these require_once might not be needed
// or might be different.

// Call the controller method responsible for handling DataTables requests.
ControladorUsuarios::ctrFiltrarUsuarios();

?>
