<?php
header('Access-Control-Allow-Origin: *');
header('Referrer-Policy', 'no-referrer-when-downgrade');
header('X-Content-Type-Options', 'nosniff');
header('X-XSS-Protection', '1; mode=block');
header('X-Frame-Options', 'DENY');
header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
header('Content-Security-Policy', "style-src 'self'");
/*
<>
Copyright (C) <2021>  
<Jesus D. Rivero C.>
<riverojdu@pdvsa.com>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
 any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


$server = "localhost";
$user = "heavkfwj_root";
$pass = Raida2028.";
$bd = "heavkfwj_gestion_tp";

//Creamos la conexión
$conexion = mysqli_connect($server, $user, $pass,$bd) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");

//generamos la consulta
/*$sql = "SELECT * FROM tbregistro WHERE ptoSuministro = 'LAGUNILLAS'";*/
$sql = "SELECT * FROM unidades"; 
mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($conexion, $sql)) die();

/*$pasajeros = array(); //creamos un array


while($row = mysqli_fetch_array($result)) 
{ 
    $id=$row['id'];
    $combustible=$row['combustible'];
    $gciaSuministro=$row['gciaSuministro'];
    $ptoSuministro=$row['ptoSuministro'];
    $cedula=$row['cedula'];
    $unidOpera=$row['unidOpera'];
    $nombre=$row['nombre'];
    $litros=$row['litros'];
    $kilometros=$row['kilometros'];                                                 
    $fecha_rec=$row['fecha_rec'];
    $orgUsuario=$row['orgUsuario'];
    
    
    

    $pasajeros[] = array('id'=> $id, 'combustible'=> $combustible, 'gciaSuministro'=> $gciaSuministro, 'ptoSuministro'=> $ptoSuministro, 'cedula'=> $cedula, 'unidOpera'=> $unidOpera, 'nombre'=> $nombre,
                        'litros'=> $litros, 'kilometros'=> $kilometros, 'fecha_rec'=> $fecha_rec, 'orgUsuario'=> $orgUsuario);

}*/
    
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  


$data   = [];
foreach ($result as $key => $value) {
    $InfoData=[]; 
    foreach ($value as $key1 => $value1) {
        $InfoData[$key1] = $value1;
    }
    $data[] = $InfoData;
}

$pasajeros = [
    "data"   => $data   
];


//Creamos el JSON
$json_string = json_encode($pasajeros);
echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'pasajeros.json';
file_put_contents($file, $json_string);
*/
    

?>