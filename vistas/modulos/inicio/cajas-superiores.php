<?php

$item = null;
$valor = null;
$orden = "id";

/*$ventas = ControladorVentas::ctrSumaTotalVentas();*/

$operadores = ControladorOperadores::ctrMostrarOperadores($item, $valor);
$totaloperadores = count($operadores);

$marcas = ControladorMarcas::ctrMostrarMarcas($item, $valor);
$totalmarcas = count($marcas);

$pasajeros = ControladorPasajeros::ctrMostrarPasajeros($item, $valor);
$totalPasajeros = count($pasajeros);

$unidades = ControladorUnidades::ctrMostrarUnidades($item, $valor, $orden);
$totalUnidades = count($unidades);

?>



<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3><?php echo number_format($totalPasajeros); ?></h3>
      <!--h3>$<?php echo number_format($totalUnidadesComprados); ?></h3-->

      <p>Número de pasajeros</p>
    
    </div>
    
    <div class="icon">
      
      <!--i class="ion ion-people-sharp"></i-->
    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><circle cx="152" cy="184" r="72" fill="currentColor"/><path fill="currentColor" d="M234 296c-28.16-14.3-59.24-20-82-20c-44.58 0-136 27.34-136 82v42h150v-16.07c0-19 8-38.05 22-53.93c11.17-12.68 26.81-24.45 46-34"/><path fill="currentColor" d="M340 288c-52.07 0-156 32.16-156 96v48h312v-48c0-63.84-103.93-96-156-96"/><circle cx="340" cy="168" r="88" fill="currentColor"/></svg>
    </div>
    
    <a href="pasajeros" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-green">
    
    <div class="inner">
    
      <h3><?php echo number_format($totalmarcas); ?></h3>

      <p>Marcas</p>
    
    </div>
    
    <div class="icon">
    
      <i class="ion ion-clipboard"></i>
    
    </div>
    
    <a href="marcas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-yellow">
    
    <div class="inner">
    
      <h3><?php echo number_format($totaloperadores); ?></h3>

      <p>Operadores</p>
  
    </div>
    
    <div class="icon">
    
      <i class="ion ion-person-add"></i>
    
    </div>
    
    <a href="operadores" class="small-box-footer">

      Más info <i class="fa fa-arrow-circle-right"></i>

    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-red">
  
    <div class="inner">
    
      <h3><?php echo number_format($totalUnidades); ?></h3>

      <p>Flota</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-android-bus"></i>
    
    </div>
    
    <a href="unidades" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>