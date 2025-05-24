<?php
class Conexion {
  public static function conectar() {
    $link = new PDO("mysql:host=localhost;dbname=gestion_tp", "root", "raida2028");
    $link->exec("set names utf8");
    return $link;
  }
}

$db = Conexion::conectar();

function buildOrgChart($employees, $parentId = 0) {
  $children = array();
  foreach ($employees as $employee) {
    if ($employee['id_administrador'] == $parentId) {
      $children[] = array(
        'name' => $employee['nombre'],
        'cargo' => $employee['cargo'],
        'children' => buildOrgChart($employees, $employee['id_administrador'])
      );
    }
  }
  return $children;
}

// Get all employees
$query = $db->query("SELECT * FROM trabajadores");
$employees = $query->fetchAll();

// Build the org chart data structure
$data = array(
  'name' => 'Organigrama',
  'children' => buildOrgChart($employees)
);

// Output the data structure in JSON format
echo json_encode($data);
?>