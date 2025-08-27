<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

class Conexion {
    private static $instance = null;

    public static function conectar() {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO("mysql:host=localhost;dbname=gestion_tp", "root", "raida2028");
                self::$instance->exec("set names utf8");
            } catch (PDOException $e) {
                echo json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]);
                exit;
            }
        }
        return self::$instance;
    }
}

/**
 * Construye recursivamente el árbol a partir del nodo dado por $parentCedula
 */
function buildOrgChart($employees, $parentCedula) {
    $children = [];
    foreach ($employees as $employee) {
        if ($employee['id_administrador'] == $parentCedula) {
            $cedula = str_pad($employee['cedula'], 9, "0", STR_PAD_LEFT);
            $imageUrl = "http://ccschu14.pdvsa.com/PHOTOS/" . $cedula . ".jpg"; 

            $child = [
                'title' => 'APROBADOR: ' . htmlspecialchars($employee['nombre']) . "<br>C.I: " . htmlspecialchars($employee['cedula']) . " (01 " . htmlspecialchars($employee['tipoNomina']) . ')',
                'name' => '<img class="avatar" src="' . htmlspecialchars($imageUrl) . '" alt="Avatar" /> ' . htmlspecialchars($employee['cargo']),
                'children' => buildOrgChart($employees, $employee['cedula'])
            ];
            $children[] = $child;
        }
    }
    return $children;
}

try {
    $db = Conexion::conectar();
    $query = $db->query("SELECT * FROM trabajadores");
    $employees = $query->fetchAll(PDO::FETCH_ASSOC);

    // Buscar el nodo/s raíz (id_administrador == 0)
    $rootNodes = [];
    foreach ($employees as $emp) {
        if ($emp['id_administrador'] == 0) {
            $rootNodes[] = $emp;
        }
    }

    // Si existe un solo nodo raíz, construir el árbol a partir de él
    if (count($rootNodes) === 1) {
        $root = $rootNodes[0];
        $cedulaRoot = str_pad($root['cedula'], 9, "0", STR_PAD_LEFT);
        $imageUrlRoot = "http://ccschu14.pdvsa.com/PHOTOS/" . $cedulaRoot . ".jpg";

        $data = [
            'title' => 'APROBADOR: ' . htmlspecialchars($root['nombre']) . "<br>C.I: " . htmlspecialchars($root['cedula']) . " (01 " . htmlspecialchars($root['tipoNomina']) . ')',
            'name' => '<img class="avatar" src="' . htmlspecialchars($imageUrlRoot) . '" alt="Avatar" /> ' . htmlspecialchars($root['cargo']),
            'children' => buildOrgChart($employees, $root['cedula'])
        ];
    } elseif (count($rootNodes) > 1) {
        // Si hay múltiples nodos raíz, crear nodo ficticio raíz que los contenga
        $children = [];
        foreach ($rootNodes as $root) {
            $cedulaRoot = str_pad($root['cedula'], 9, "0", STR_PAD_LEFT);
            $imageUrlRoot = "http://ccschu14.pdvsa.com/PHOTOS/" . $cedulaRoot . ".jpg";

            $children[] = [
                'title' => 'APROBADOR: ' . htmlspecialchars($root['nombre']) . "<br>C.I: " . htmlspecialchars($root['cedula']) . " (01 " . htmlspecialchars($root['tipoNomina']) . ')',
                'name' => '<img class="avatar" src="' . htmlspecialchars($imageUrlRoot) . '" alt="Avatar" /> ' . htmlspecialchars($root['cargo']),
                'children' => buildOrgChart($employees, $root['cedula'])
            ];
        }
        $data = [
            'title' => 'Raíz',
            'name' => 'Raíz',
            'children' => $children
        ];
    } else {
        // No hay nodos raíz, devolver array vacío o mensaje
        $data = [];
    }

    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(['error' => 'Error al obtener datos: ' . $e->getMessage()]);
}
?>
