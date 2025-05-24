<?php

$item = null;
$valor = null;
$orden = "id";

$unidades = ControladorUnidades::ctrMostrarUnidades($item, $valor, $orden);

 ?>


<div class="box box-primary">

  <div class="box-header with-border">

    <h3 class="box-title">Unidades agregadas recientemente</h3>

    <div class="box-tools pull-right">

      <button type="button" class="btn btn-box-tool" data-widget="collapse">

        <i class="fa fa-minus"></i>

      </button>

      <button type="button" class="btn btn-box-tool" data-widget="remove">

        <i class="fa fa-times"></i>

      </button>

    </div>

  </div>
  
  <div class="box-body">

    <ul class="products-list product-list-in-box">

    <?php

    for($i = 0; $i < 10; $i++){

      echo '<li class="item">

        <div class="product-img">

          <img src="'.$unidades[$i]["imagen"].'" alt="Unidad Image">

        </div>

        <div class="product-info">

          <a href="" class="product-title">

            '.$unidades[$i]["descripcion"].'

            <span class="label label-warning pull-right">$'.$unidades[$i]["precio_venta"].'</span>

          </a>
    
       </div>

      </li>';

    }

    ?>

    </ul>

  </div>

  <div class="box-footer text-center">

    <a href="unidades" class="uppercase">Ver todas las unidades</a>
  
  </div>

</div>
