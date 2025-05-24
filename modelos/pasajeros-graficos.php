<?php
// Your PHP code to handle the request and generate the response

$daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
$currentDay = date('w');

// Assuming you have a function to execute the SQL query
$result = queryDatabase("SELECT DATE(fecha) as fecha, COUNT(*) as cantidad FROM pasajeros WHERE fecha >= CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 1) DAY AND fecha < CURDATE() - INTERVAL (DAYOFWEEK(CURDATE()) - 1) DAY + INTERVAL 7 DAY GROUP BY fecha ORDER BY fecha");

$data = array();

foreach ($result as $row) {
    $dayName = $daysOfWeek[($row['fecha']->format('w') + 6) % 7];
    $data[] = array('y' => $dayName, 'cantidad' => $row['cantidad']);
}

for ($i = $currentDay; $i < 7; $i++) {
    $dayName = $daysOfWeek[$i];
    $data[] = array('y' => $dayName, 'cantidad' => 0);
}
for ($i = 0; $i < $currentDay; $i++) {
    $dayName = $daysOfWeek[$i];
    $data[] = array('y' => $dayName, 'cantidad' => 0);
}

$jsonData = json_encode($data);

// Send the JSON data as the response
echo $jsonData;