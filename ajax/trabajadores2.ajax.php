<?php
// Connect to the database
$host = 'localhost';
$db   = 'gestion_tp';
$user = 'root';
$pass = 'raida2028';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

// Initialize error messages
$error_nombre = '';
$error_cedula = '';
$error_correo = '';
$error_fechaNacimiento = '';
$error_direccion = '';
$error_cargo = '';
$error_foto = '';
$error_fotoCarnet = '';
$error_cartaMedica = '';
$error_certificadoManejo = '';
$error_nroLicencia = '';

// Get the user data from the request
$nombre = $_POST['nombre'];
$cedula = $_POST['cedula'];
$correo = $_POST['correo'];
$fechaNacimiento = $_POST['fechaNacimiento'];
$direccion = $_POST['direccion'];
$cargo = $_POST['cargo'];
$foto = $_FILES['foto'];
$fotoCarnet = $_FILES['fotoCarnet'];
$cartaMedica = $_FILES['cartaMedica'];
$certificadoManejo = $_FILES['certificadoManejo'];
$nroLicencia = $_FILES['nroLicencia'];

// Create the directory if it doesn't exist
$directory = '../vistas/img/trabajadores/' . $correo;
//En BD
$directorio = 'vistas/img/trabajadores/' . $correo;
$fotoDirectorio = $directorio . '/foto';
$fotoCarnetDirectorio = $directorio . '/fotoCarnet';
$cartaMedicaDirectorio = $directorio . '/cartaMedica';
$certificadoManejoDirectorio = $directorio . '/certificadoManejo';
$nroLicenciaDirectorio = $directorio . '/nroLicencia';


if (!file_exists($directory)) {

    mkdir($directory, 0755, true);

}


// Create directories for the files

$fotoDirectory = $directory . '/foto';

if (!file_exists($fotoDirectory)) {

    mkdir($fotoDirectory, 0755, true);

}

$fotoCarnetDirectory = $directory . '/fotoCarnet';

if (!file_exists($fotoCarnetDirectory)) {

    mkdir($fotoCarnetDirectory, 0755, true);

}


$cartaMedicaDirectory = $directory . '/cartaMedica';

if (!file_exists($cartaMedicaDirectory)) {

    mkdir($cartaMedicaDirectory, 0755, true);

}


$certificadoManejoDirectory = $directory . '/certificadoManejo';

if (!file_exists($certificadoManejoDirectory)) {

    mkdir($certificadoManejoDirectory, 0755, true);

}

$nroLicenciaDirectory = $directory . '/nroLicencia';

if (!file_exists($nroLicenciaDirectory)) {

    mkdir($nroLicenciaDirectory, 0755, true);

}


// Check if the input is valid
if (empty($nombre)) {
    $error_nombre = 'El nombre es obligatorio';
}

if (empty($cedula)) {
    $error_cedula = 'La cedula es obligatoria';
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $error_correo = 'El correo electrónico es inválido';
}


if (empty($fechaNacimiento)) {
    $error_fechaNacimiento = 'La fecha de nacimiento es obligatoria';
}

if (empty($direccion)) {
    $error_direccion = 'La dirección es obligatoria';
}

if (empty($cargo)) {
    $error_cargo = 'El cargo es obligatorio';
}

// Validate and upload the files
if (empty($error_foto)) {
    if (!is_uploaded_file($foto['tmp_name']) || $foto['error'] != 0) {
        $error_foto = 'La foto es obligatoria';
    } else {
        $fotoName = basename($foto['name']);

        $fotoPath = $fotoDirectory . '/' . $fotoName;
        $fotoRuta = $fotoDirectorio . '/' . $fotoName;
 
        move_uploaded_file($foto['tmp_name'], $fotoPath);
    }
}

if (empty($error_fotoCarnet)) {
    if (!is_uploaded_file($fotoCarnet['tmp_name']) || $fotoCarnet['error'] != 0) {
        $error_fotoCarnet = 'La foto Carnet es obligatoria';
    } else {
        $fotoName = basename($foto['name']);

        $fotoPath = $fotoCarnetDirectory . '/' . $fotoCarnetName;
        $fotoRuta = $fotoCarnetDirectorio . '/' . $fotoCarnetName;
 
        move_uploaded_file($fotoCarnet['tmp_name'], $fotoCarnetPath);
    }
}

if (empty($error_cartaMedica)) {
    if (!is_uploaded_file($cartaMedica['tmp_name'])|| $cartaMedica['error'] != 0) {
        $error_cartaMedica = 'La carta médica es obligatoria';
    } else {
        $cartaMedicaName = basename($cartaMedica['name']);
     
        $cartaMedicaPath = $cartaMedicaDirectory . '/' . $cartaMedicaName;
        $cartaMedicaRuta = $cartaMedicaDirectorio . '/' . $cartaMedicaName;
     
        move_uploaded_file($cartaMedica['tmp_name'], $cartaMedicaPath);
    }
}

if (empty($error_certificadoManejo)) {
    if (!is_uploaded_file($certificadoManejo['tmp_name']) || $certificadoManejo['error'] != 0) {
        $error_certificadoManejo = 'El certificado de manejo es obligatorio';
    } else {
        $certificadoManejoName = basename($certificadoManejo['name']);

        $certificadoManejoPath = $certificadoManejoDirectory . '/' . $certificadoManejoName;
        $certificadoManejoRuta = $certificadoManejoDirectorio . '/' . $certificadoManejoName;
   
        move_uploaded_file($certificadoManejo['tmp_name'], $certificadoManejoPath);
    }
}

if (empty($error_nroLicencia)) {
    if (!is_uploaded_file($nroLicencia['tmp_name']) || $nroLicencia['error'] != 0) {
        $error_nroLicencia = 'La licencia es obligatoria';
    } else {
        $nroLicenciaName = basename($nroLicencia['name']);

        $nroLicenciaPath = $nroLicenciaDirectory . '/' . $nroLicenciaName;
        $nroLicenciaRuta = $nroLicenciaDirectorio . '/' . $nroLicenciaName;
   
        move_uploaded_file($nroLicencia['tmp_name'], $nroLicenciaPath);
    }
}

$fechaVencimientoCartaMedica = $_POST["fechaVencimientoCartaMedica"];

$fechaVencimientoCertificadoManejo = $_POST["fechaVencimientoCertificadoManejo"];

$fechaVencimientoLicencia = $_POST["fechaVencimientoLicencia"];

// If there are no errors, insert the user into the database
if (empty($error_nombre)&& empty($error_cedula) && empty($error_correo) && empty($error_fechaNacimiento) && empty($error_direccion)  && empty($error_cargo) && empty($error_foto) && empty($error_fotoCarnet) && empty($error_cartaMedica) && empty($error_certificadoManejo) && empty($error_nroLicencia)) {
    $sql = "INSERT INTO trabajadores (nombre, cedula, correo, fechaNacimiento, direccion, cargo, foto, fotoCarnet, fechaVencimientoCartaMedica, cartaMedica, fechaVencimientoCertificadoManejo, certificadoManejo, fechaVencimientoLicencia, nroLicencia) VALUES (:foto, :fotoCarnet, :nombre, :cedula, :correo, :fechaNacimiento, :direccion, :cargo, :fechaVencimientoCartaMedica, :cartaMedica, :fechaVencimientoCertificadoManejo, :certificadoManejo, :fechaVencimientoLicencia, :nroLicencia)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':foto', $fotoRuta);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':cargo', $cargo);

    $stmt->bindParam(':fotoCarnet', $fotoCarnetRuta);


    $stmt->bindParam(':fechaVencimientoCartaMedica', $fechaVencimientoCartaMedica);
    $stmt->bindParam(':cartaMedica', $cartaMedicaRuta);
    
    $stmt->bindParam(':fechaVencimientoCertificadoManejo', $fechaVencimientoCertificadoManejo);
    $stmt->bindParam(':certificadoManejo', $certificadoManejoRuta);

    $stmt->bindParam(':fechaVencimientoLicencia', $fechaVencimientoLicencia);
    $stmt->bindParam(':nroLicencia', $nroLicenciaRuta);
    $stmt->execute();

    // Get the ID of the new user
    $idTrabajador = $pdo->lastInsertId();

    // Return a success message
    echo "Usuario insertado exitosamente.";
} else {
    // Display the error messages
    echo '<div class="error">';
    echo '<p>' . $error_nombre . '</p>';
    echo '<p>' . $error_cedula . '</p>';
    echo '<p>' . $error_correo . '</p>';
    echo '<p>' . $error_fechaNacimiento . '</p>';
    echo '<p>' . $error_direccion . '</p>';
    echo '<p>' . $error_cargo . '</p>';
    echo '<p>' . $error_foto . '</p>';
    echo '<p>' . $error_fotoCarnet . '</p>';
    echo '<p>' . $error_cartaMedica . '</p>';
    echo '<p>' . $error_certificadoManejo . '</p>';
    echo '<p>' . $error_nroLicencia . '</p>';
    echo '</div>';
}