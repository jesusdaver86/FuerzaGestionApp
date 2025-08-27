<?php

$item = null;
$valor = null;

$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
$pasajeros = ControladorPasajeros::ctrMostrarPasajeros($item, $valor);

$arrayPasajeros = array();
$arraylistaPasajeros = array();

foreach ($ventas as $key => $valueVentas) {
  
  foreach ($pasajeros as $key => $valuePasajeros) {
    
      if($valuePasajeros["id"] == $valueVentas["id_pasajero"]){

        #Capturamos los Pasajeros en un array
        array_push($arrayPasajeros, $valuePasajeros["nombre"]);

        #Capturamos las nombres y los valores netos en un mismo array
        $arraylistaPasajeros = array($valuePasajeros["nombre"] => $valueVentas["neto"]);

        #Sumamos los netos de cada pasajero
        foreach ($arraylistaPasajeros as $key => $value) {
          
          $sumaTotalPasajeros[$key] += $value;
        
        }

      }   
  }

}

#Evitamos repetir nombre
$noRepetirNombres = array_unique($arrayPasajeros);

?>

<!--=====================================
VENDEDORES
======================================-->

<div class="box box-primary">
	
	<div class="box-header with-border">
    
    	<h3 class="box-title">Compradores</h3>
  
  	</div>

  	<div class="box-body">
  		
		<div class="chart-responsive">
			
			<div class="chart" id="bar-chart2" style="height: 300px;"></div>

		</div>

  	</div>

</div>

<script>
	
//BAR CHART
var bar = new Morris.Bar({
  element: 'bar-chart2',
  resize: true,
  data: [
     <?php
    
    foreach($noRepetirNombres as $value){

      echo "{y: '".$value."', a: '".$sumaTotalPasajeros[$value]."'},";

    }

  ?>
  ],
  barColors: ['#f6a'],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['ventas'],
  preUnits: '$',
  hideHover: 'auto'
});


</script>