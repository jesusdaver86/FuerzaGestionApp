<?php

require_once '../modelos/conexion.php';
require '../vendor/autoload.php'; // Incluye el autoload de Composer para PhpSpreadsheet

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PhpOffice\PhpSpreadsheet\IOFactory;

$db = Conexion::conectar();
if (!$db) {
    echo json_encode(['message' => 'Error: No se pudo conectar a la base de datos.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file'];

        // Verificar si el archivo es un XLS, XLSX o CSV
        $allowedExtensions = ['xls', 'xlsx', 'csv'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo json_encode(['message' => 'Error: Formato de archivo no permitido.']);
            exit;
        }

        // Cargar el archivo usando PhpSpreadsheet
        try {
            $spreadsheet = IOFactory::load($file['tmp_name']);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(); // Convertir la hoja a un array

            // Truncar la tabla para eliminar datos existentes
            $stmt = $db->prepare("TRUNCATE TABLE trabajadores");
            $stmt->execute();

            // Preparar la consulta de inserción
            $insertStmt = $db->prepare("INSERT INTO trabajadores (
                `cedula`, 
                `nombre`, 
                `cargo`, 
                `tipoNomina`, 
                `correo`, 
                `fechaNacimiento`, 
                `estatusDeCondicion`, 
                `segundaLineaGerencia`, 
                `instalacion_edificio`, 
                `localidad_trabajo`, 
                `telefono`, 
                `id_administrador`, 
                `direccion`, 
                `municipioDeVivienda`, 
                `entregaDeBeneficio`, 
                `foto`, 
                `fotoDocumento`, 
                `fotoCarnet`, 
                `cartaMedica`, 
                `certificadoManejo`, 
                `nroLicencia`, 
                `fechaVencimientoDocumento`, 
                `fechaVencimientoCartaMedica`, 
                `fechaVencimientoCertificadoManejo`, 
                `fechaVencimientoLicencia`, 
                `estado`, 
                `fechaVencimientoCertificadoFlotaLiviana`, 
                `fechaVencimientoCertificadoFlotaPesada`, 
                `certificadoFlotaLiviana`, 
                `certificadoFlotaPesada` 
            ) VALUES (
                ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
            )");

            // Iterar sobre los datos y ejecutar la inserción
            foreach ($data as $index => $row) {
                // Saltar la primera fila (encabezados)
                if ($index === 0) {
                    continue;
                }

                // Omitir filas vacías
                if (empty(array_filter($row))) {
                    continue; // Salta la fila si está vacía
                }

                // Aceptamos 30 columnas
                if (count($row) === 30) {
                    // Convertir la fecha de nacimiento al formato correcto
                    $fechaNacimiento = DateTime::createFromFormat('d/m/Y', $row[5]);
                    if ($fechaNacimiento) {
                        $row[5] = $fechaNacimiento->format('Y-m-d');
                    } else {
                        echo json_encode(['message' => 'Error: Fecha de nacimiento no válida en la línea ' . ($index + 1)]);
                        exit;
                    }

                    // Convertir las fechas de vencimiento al formato correcto
                    $fechasVencimientoIndices = [
                        21, // fechaVencimientoDocumento
                        22, // fechaVencimientoCartaMedica
                        23, // fechaVencimientoCertificadoManejo
                        24, // fechaVencimientoLicencia
                        26, // fechaVencimientoCertificadoFlotaLiviana
                        27  // fechaVencimientoCertificadoFlotaPesada
                    ];

                    foreach ($fechasVencimientoIndices as $fechaIndex) {
                        // Verificar si la celda está vacía
                        if (empty($row[$fechaIndex])) {
                            $row [$fechaIndex] = null; // O puedes decidir omitir la fecha
                            continue; // Salta la conversión si está vacía
                        }

                        $fechaVencimiento = DateTime::createFromFormat('d/m/Y', $row[$fechaIndex]);
                        if ($fechaVencimiento) {
                            $row[$fechaIndex] = $fechaVencimiento->format('Y-m-d');
                        } else {
                            echo json_encode(['message' => 'Error: Fecha de vencimiento no válida en la línea ' . ($index + 1) . ' para el valor: ' . $row[$fechaIndex]]);
                            exit;
                        }
                    }

                    // Ejecutar la inserción
                    if (!$insertStmt->execute($row)) {
                        echo json_encode(['message' => 'Error al insertar datos: ' . implode(", ", $insertStmt->errorInfo())]);
                        exit;
                    }
                } else {
                    echo json_encode(['message' => 'Error: Se esperaban 30 columnas en la línea ' . ($index + 1)]);
                    exit;
                }
            }

            echo json_encode(['message' => 'Datos importados correctamente.']);
        } catch (Exception $e) {
            echo json_encode(['message' => 'Error al cargar el archivo: ' . $e->getMessage()]);
            exit;
        }
    } else {
        echo json_encode(['message' => 'Error: No se ha subido ningún archivo.']);
        exit;
    }
} else {
    echo json_encode(['message' => 'Error: Método de solicitud no permitido.']);
    exit;
}
?>