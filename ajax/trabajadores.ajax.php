<?php
$host = 'localhost';
$db   = 'heavkfwj_gestion_tp';
$user = 'heavkfwj_root';
$pass = Raida2028.';
$charset = 'utf8mb4';
// Crear un DSN (Data Source Name) para la conexión a la base de datos
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
// Opciones de PDO
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
// Crear una nueva instancia de PDO
$pdo = new PDO($dsn, $user, $pass, $opt);

// Inicializar mensajes de error
$error_nombre = '';
$error_cedula = '';
$error_correo = '';
$error_fechaNacimiento = '';
$error_direccion = '';
$error_cargo = '';
$error_foto = '';
$error_fotoDocumento = '';
$error_fotoCarnet = '';
$error_cartaMedica = '';
$error_certificadoManejo = '';
$error_nroLicencia = '';

// Obtener datos del usuario desde la solicitud
$nombre = $_POST['nombre'];
$cedula = $_POST['cedula'];
$correo = $_POST['correo'];
$fechaNacimiento = $_POST['fechaNacimiento'];
$direccion = $_POST['direccion'];
$cargo = $_POST['cargo'];
// Validar datos del usuario
if (empty($nombre)) {
    $error_nombre = 'El nombre es obligatorio';
}

if (empty($cedula)) {
    $error_cedula = 'La cedula es obligatoria';
}

if (empty($correo)) {

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

// Crear un directorio para los archivos del usuario
$directory = '../vistas/img/files/'. $cedula;

$directorio = 'vistas/img/files/'. $cedula;
$fotoDirectorio = $directorio. '/foto';
$fotoDocumentoDirectorio = $directorio. '/fotoDocumento';
$fotoCarnetDirectorio = $directorio. '/fotoCarnet';
$cartaMedicaDirectorio = $directorio. '/cartaMedica';
$certificadoManejoDirectorio = $directorio. '/certificadoManejo';
$nroLicenciaDirectorio = $directorio. '/nroLicencia';

if (!file_exists($directory)) {
    mkdir($directory, 0755, true);
}


$fotoDirectory = $directory. '/foto';
if (!file_exists($fotoDirectory)) {
    mkdir($fotoDirectory, 0755, true);
}

$fotoDocumentoDirectory = $directory. '/fotoDocumento';
if (!file_exists($fotoDocumentoDirectory)) {
    mkdir($fotoDocumentoDirectory, 0755, true);
}

$fotoCarnetDirectory = $directory. '/fotoCarnet';
if (!file_exists($fotoCarnetDirectory)) {
    mkdir($fotoCarnetDirectory, 0755, true);
}

$cartaMedicaDirectory = $directory. '/cartaMedica';
if (!file_exists($cartaMedicaDirectory)) {
    mkdir($cartaMedicaDirectory, 0755, true);
}

$certificadoManejoDirectory = $directory. '/certificadoManejo';
if (!file_exists($certificadoManejoDirectory)) {
    mkdir($certificadoManejoDirectory, 0755, true);
}

$nroLicenciaDirectory = $directory. '/nroLicencia';
if (!file_exists($nroLicenciaDirectory)) {
    mkdir($nroLicenciaDirectory, 0755, true);
}

// Manejar subidas de archivos
if (isset($_FILES['foto'])) {
    $foto = $_FILES['foto'];
    if (empty($foto['name'])) {
        $error_foto = 'La foto es obligatoria';
    } else {
        $fotoName = basename($foto['name']);
        $fotoPath = $fotoDirectory. '/'. $fotoName;
        $fotoRuta = $fotoDirectorio. '/'. $fotoName;
        move_uploaded_file($foto['tmp_name'], $fotoPath);
    }
} else {
    $error_foto = 'La foto es obligatoria';
}

// Manejar otras subidas de archivos..
if (isset($_FILES['fotoDocumento'])) {
    $fotoDocumento = $_FILES['fotoDocumento'];
    if (empty($fotoDocumento['name'])) {
        $error_fotoDocumento = 'La foto Documento es obligatoria';
    } else {
        $fotoDocumentoName = basename($fotoDocumento['name']);
        $fotoDocumentoPath = $fotoDocumentoDirectory. '/'. $fotoDocumentoName;
        $fotoDocumentoRuta = $fotoDocumentoDirectorio. '/'. $fotoDocumentoName;
        move_uploaded_file($fotoDocumento['tmp_name'], $fotoDocumentoPath);
    }
} else {
    $error_fotoDocumento = 'La foto Documento es obligatoria';
}

if (isset($_FILES['fotoCarnet'])) {
    $fotoCarnet = $_FILES['fotoCarnet'];
    if (empty($fotoCarnet['name'])) {
        $error_fotoCarnet = 'La foto Carnet es obligatoria';
    } else {
        $fotoCarnetName = basename($fotoCarnet['name']);
        $fotoCarnetPath = $fotoCarnetDirectory. '/'. $fotoCarnetName;
        $fotoCarnetRuta = $fotoCarnetDirectorio. '/'. $fotoCarnetName;
        move_uploaded_file($fotoCarnet['tmp_name'], $fotoCarnetPath);
    }
} else {
    $error_fotoCarnet = 'La foto Carnet es obligatoria';
}

if (isset($_FILES['cartaMedica'])) {
    $cartaMedica = $_FILES['cartaMedica'];
    if (empty($cartaMedica['name'])) {
        $error_cartaMedica = 'La carta médica es obligatoria';
    } else {
        $cartaMedicaName = basename($cartaMedica['name']);
        $cartaMedicaPath = $cartaMedicaDirectory. '/'. $cartaMedicaName;
        $cartaMedicaRuta = $cartaMedicaDirectorio. '/'. $cartaMedicaName;
        move_uploaded_file($cartaMedica['tmp_name'], $cartaMedicaPath);
    }
} else {
    $error_cartaMedica = 'La carta médica es obligatoria';
}

if (isset($_FILES['certificadoManejo'])) {
    $certificadoManejo = $_FILES['certificadoManejo'];
    if (empty($certificadoManejo['name'])) {
        $error_certificadoManejo = 'El certificado de manejo es obligatorio';
    } else {
        $certificadoManejoName = basename($certificadoManejo['name']);
        $certificadoManejoPath = $certificadoManejoDirectory. '/'. $certificadoManejoName;
        $certificadoManejoRuta = $certificadoManejoDirectorio. '/'. $certificadoManejoName;
        move_uploaded_file($certificadoManejo['tmp_name'], $certificadoManejoPath);
    }
} else {
    $error_certificadoManejo = 'El certificado de manejo es obligatorio';
}

if (isset($_FILES['nroLicencia'])) {
    $nroLicencia = $_FILES['nroLicencia'];
    if (empty($nroLicencia['name'])) {
       $error_nroLicencia = 'La licencia es obligatoria';
    } else {
        $nroLicenciaName = basename($nroLicencia['name']);
        $nroLicenciaPath = $nroLicenciaDirectory. '/'. $nroLicenciaName;
        $nroLicenciaRuta = $nroLicenciaDirectorio. '/'. $nroLicenciaName;
        move_uploaded_file($nroLicencia['tmp_name'], $nroLicenciaPath);
    }
} else {
    $error_nroLicencia = 'La licencia es obligatoria';
}

$fechaVencimientoDocumento = isset($_POST["fechaVencimientoDocumento"]) ? $_POST["fechaVencimientoDocumento"] : '';
$fechaVencimientoCartaMedica = isset($_POST["fechaVencimientoCartaMedica"]) ? $_POST["fechaVencimientoCartaMedica"] : '';
$fechaVencimientoCertificadoManejo = isset($_POST["fechaVencimientoCertificadoManejo"]) ? $_POST["fechaVencimientoCertificadoManejo"] : '';
$fechaVencimientoLicencia = isset($_POST["fechaVencimientoLicencia"]) ? $_POST["fechaVencimientoLicencia"] : '';

// Insertar datos en la base de datos si no hay errores
if (empty($error_nombre) && empty($error_cedula) && empty($error_correo) && empty($error_fechaNacimiento) && empty($error_direccion) && empty($error_cargo) && empty($error_foto) && empty($error_fotoDocumento) && empty($error_fotoCarnet) && empty($error_cartaMedica) && empty($error_certificadoManejo) && empty($error_nroLicencia)) {
    $sql= "INSERT INTO trabajadores (nombre, cedula, correo, fechaNacimiento, direccion, cargo, foto, fotoDocumento, fechaVencimientoDocumento, fotoCarnet, fechaVencimientoCartaMedica, cartaMedica, fechaVencimientoCertificadoManejo, certificadoManejo, fechaVencimientoLicencia, nroLicencia) VALUES (:nombre, :cedula, :correo, :fechaNacimiento, :direccion, :cargo, :foto, :fotoDocumento, :fechaVencimientoDocumento, :fotoCarnet, :fechaVencimientoCartaMedica, :cartaMedica, :fechaVencimientoCertificadoManejo, :certificadoManejo, :fechaVencimientoLicencia, :nroLicencia)";
    $stmt = $pdo->prepare($sql);
// Enlazar parámetros a la sentencia SQL
    $stmt->bindParam(':foto', $fotoRuta);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':cargo', $cargo);
    $stmt->bindParam(':fotoCarnet', $fotoCarnetRuta);
    $stmt->bindParam(':fechaVencimientoDocumento', $fechaVencimientoDocumento);
    $stmt->bindParam(':fotoDocumento', $fotoDocumentoRuta);
    $stmt->bindParam(':fechaVencimientoCartaMedica', $fechaVencimientoCartaMedica);
    $stmt->bindParam(':cartaMedica', $cartaMedicaRuta);
    $stmt->bindParam(':fechaVencimientoCertificadoManejo', $fechaVencimientoCertificadoManejo);
    $stmt->bindParam(':certificadoManejo', $certificadoManejoRuta);
    $stmt->bindParam(':fechaVencimientoLicencia', $fechaVencimientoLicencia);
    $stmt->bindParam(':nroLicencia', $nroLicenciaRuta);
    $stmt->execute();


    $idTrabajador = $pdo->lastInsertId();

    echo "Usuario insertado exitosamente.";
} else {            
// Mostrar mensajes de error
    echo '<div class="error">';
    echo '<p>' . $error_nombre . '</p>';
    echo '<p>' . $error_cedula . '</p>';
    echo '<p>' . $error_correo . '</p>';
    echo '<p>' . $error_fechaNacimiento . '</p>';
    echo '<p>' . $error_direccion . '</p>';
    echo '<p>' . $error_cargo . '</p>';
    echo '<p>' . $error_foto . '</p>';
    echo '<p>' . $error_fotoDocumento . '</p>';
    echo '<p>' . $error_fotoCarnet . '</p>';
    echo '<p>' . $error_cartaMedica . '</p>';
    echo '<p>' . $error_certificadoManejo . '</p>';
    echo '<p>' . $error_nroLicencia . '</p>';
    echo '</div>';
}

