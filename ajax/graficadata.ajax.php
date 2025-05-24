<?php
$conn = mysqli_connect("localhost", "root", "raida2028", "gestion_tp");

// Verificar la conexión
if (!$conn) {
    die("Error de conexión: ". mysqli_connect_error());
}

// Recibir los parámetros enviados por la solicitud AJAX
$type = $_GET['type'];
$value = $_GET['value'];

// Consulta SQL para obtener los datos
$query = "SELECT nroUnidad, 
                 SUM(CASE WHEN DAYNAME(fecha_c) = 'Monday' THEN 1 ELSE 0 END) AS Monday, 
                 SUM(CASE WHEN DAYNAME(fecha_c) = 'Tuesday' THEN 1 ELSE 0 END) AS Tuesday, 
                 SUM(CASE WHEN DAYNAME(fecha_c) = 'Wednesday' THEN 1 ELSE 0 END) AS Wednesday, 
                 SUM(CASE WHEN DAYNAME(fecha_c) = 'Thursday' THEN 1 ELSE 0 END) AS Thursday, 
                 SUM(CASE WHEN DAYNAME(fecha_c) = 'Friday' THEN 1 ELSE 0 END) AS Friday, 
                 SUM(CASE WHEN DAYNAME(fecha_c) = 'Saturday' THEN 1 ELSE 0 END) AS Saturday, 
                 SUM(CASE WHEN DAYNAME(fecha_c) = 'Sunday' THEN 1 ELSE 0 END) AS Sunday 
          FROM pasajeros 
          WHERE YEAR(fecha_c) =? AND MONTH(fecha_c) =? 
          GROUP BY nroUnidad 
          ORDER BY nroUnidad";

// Preparar la consulta
$stmt = mysqli_prepare($conn, $query);

// Bind parameters
mysqli_stmt_bind_param($stmt, "ii", $type, $value);

// Ejecutar la consulta
mysqli_stmt_execute($stmt);

// Recoger los resultados
$result = mysqli_stmt_get_result($stmt);

// Crear un array para almacenar los datos
$data = array();

// Recorrer los resultados y agregarlos al array
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'nroUnidad' => $row['nroUnidad'],
        'days' => array( 
        'Monday' => $row['Monday'],
        'Tuesday' => $row['Tuesday'],
        'Wednesday' => $row['Wednesday'],
        'Thursday' => $row['Thursday'],
        'Friday' => $row['Friday'],
        'Saturday' => $row['Saturday'],
        'Sunday' => $row['Sunday']
    )
    );
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);

// Devolver los datos en formato JSON
echo json_encode($data);
?>