<?php

error_reporting(0);

if(isset($_GET["fechaInicial"])){

    $fechaInicial = $_GET["fechaInicial"];
    $fechaFinal = $_GET["fechaFinal"];

}else{

$fechaInicial = null;
$fechaFinal = null;

}

/*$respuesta = ControladorPasajeros::ctrRangoFechasCantidades($fechaInicial, $fechaFinal);*/
$respuesta = ControladorPasajeros::ctrRangoFechasPasajeros($fechaInicial, $fechaFinal);


/*
$arrayFechas = array();
$arrayCantidades = array();
$sumaCantidadesMes = array();

foreach ($respuesta as $key => $value) {


	$fecha = substr($value["fecha_c"],0,7);


	array_push($arrayFechas, $fecha);


	$arrayCantidades = array($fecha => $value["total"]);


	foreach ($arrayCantidades as $key => $value) {
		
		$sumaCatidadesMes[$key] += $value;
	}

}


$noRepetirFechas = array_unique($arrayFechas);

*/

?>


<!--=====================================
GRÁFICO DE VENTAS
======================================-->

<!--div class="box box-solid bg-teal-gradient">
	
	<div class="box-header">
		
 		<i class="fa fa-th"></i>

  		<h3 class="box-title">Gráfico de Pasajeros</h3>

	</div>

	<div class="box-body border-radius-none nuevoGraficoVentas">

		<div class="chart" id="line-chart-ventas" style="height: 250px;"></div>

  </div>

</div-->

<!--script>
	
 var line = new Morris.Line({
    element          : 'line-chart-ventas',
    resize           : true,
    data             : [

    <?php

    if($noRepetirFechas != null){

	    foreach($noRepetirFechas as $key){

	    	echo "{ y: '".$key."', cantidad: ".$sumaCantidadesMes[$key]." },";


	    }

	    echo "{y: '".$key."', cantidad: ".$sumaCantidadesMes[$key]." }";

    }else{

       echo "{ y: '0', cantidad: '0' }";

    }

    ?>

    ],
    xkey             : 'y',
    ykeys            : ['cantidad'],
    labels           : ['cantidad'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits         : '',
    gridTextSize     : 10
  });

</script-->
<!--div class="box box-solid bg-teal-gradient">

    <div class="box-header">

        <i class="fa fa-th"></i>

        <h3 class="box-title">Gráfico de Pasajeros</h3>

    </div>

    <div class="box-body border-radius-none nuevoGraficoVentas">

        <div class="chart" id="line-chart-ventas" style="height: 250px;"></div>

    </div>

</div>

<div id="result"></div-->












<!--div class="box box-solid bg-teal-gradient">

    <div class="box-header">

        <i class="fa fa-th"></i>

        <h3 class="box-title">Gráfico de Pasajeros</h3>

    </div>

<div class="chart" id='chart_line'></div>

 </div-->






  <!--div id="chart-container"></div>



  <select id="filter-type">

    <option value="year">Year</option>

    <option value="month">Month</option>

    <option value="day">Day of the week</option>

  </select>




  <select id="filter-value"></select-->






  <!-- Contenedor para el gráfico -->


<div id="main" style="width: 800px; height: 600px;"></div>


<!-- Create a dropdown menu to select the month and year -->


<select id="month" class="barGraphStyler">

  <option value="1" selected>January</option>

  <option value="2">February</option>

  <option value="3">March</option>

  <option value="4">April</option>

  <option value="5">May</option>

  <option value="6">June</option>

  <option value="7">July</option>

  <option value="8">August</option>

  <option value="9">September</option>

  <option value="10">October</option>

  <option value="11">November</option>

  <option value="12">December</option>

</select>


<select id="year" class="barGraphStyler">

  <option value="2021">2021</option>

  <option value="2022">2022</option>

  <option value="2023" selected>2023</option>

  <option value="2024">2024</option>

</select>


<!-- Add a button to fetch the data -->


<button id="fetch-button">Fetch Data</button>




</div>

 <h1>Notificaciones en tiempo real</h1>

  <button id="btn-notificar">Notificar!</button>

  <!-- Script para cargar el gráfico -->

  <script src="https://fastly.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>
<!--script src="https://cdn.jsdelivr.net/npm/echarts@5.2.2/dist/echarts.min.js"></script-->


<style type="text/css">
 #main {

    width: 800px;

    height: 600px;

    border: 1px solid #ddd;

  }


  .barGraphStyler {

    padding: 10px;

    margin: 10px auto;

    display: inline-block;

    font-family: inherit;

    border-radius: 25px;

    width: 130px;

    cursor: pointer;

    border: 0.3px solid #ddd;

  }


  #datepicker-container {

    margin: 10px;

  }


  #datepicker {

    width: 200px;

    padding: 10px;

    border: 1px solid #ddd;

    border-radius: 25px;

  }
</style>







<script type="text/javascript">
 $(function() {

    $("#datepicker").datepicker({

      dateFormat: "yy-mm-dd",

      changeMonth: true,

      changeYear: true,

      onSelect: function(dateText, inst) {

        var startDate = $(this).datepicker("getDate");

        var endDate = $(this).datepicker("getDate");

        // Update the chart with the selected date range

        updateChart(startDate, endDate);

      }

    });

  });


  var chartDom = document.getElementById('main');

  var myChart = echarts.init(chartDom, 'dark');


  var option = {

    title: {

      text: 'Daily Passengers by Unit'

    },

    legend: {},

    tooltip: {

      trigger: 'axis',

      showContent: false

    },

    dataset: {

      source: []

    },

    xAxis: {

      type: 'category',

      axisLabel: {

        interval: 0,

        rotate: 45

      }

    },

    yAxis: {

      gridIndex: 0

    },

    grid: {

      top: '55%'

    },

    series: [

      {

        type: 'line',

        smooth: true,

        seriesLayoutBy: 'row',

        emphasis: {

          focus: 'series'

        }

      },

      {

        type: 'pie',

        id: 'pie',

        radius: '30%',

        center: ['50%', '25%'],

        emphasis: {

          focus: 'self'

        }

      }

    ]

  };


  myChart.on('updateAxisPointer', function(event) {

    const xAxisInfo = event.axesInfo[0];

    if (xAxisInfo) {

      const dimension = xAxisInfo.value + 1;

      myChart.setOption({

        series: {

          id: 'pie',

          label: {

            formatter: '{b}: {@[' + dimension + ']} ({d}%)'

          },

         encode: {

            value: dimension,

            tooltip: dimension

          }

        }

      });

    }

  });


  var monthSelect = document.getElementById('month');

  var yearSelect = document.getElementById('year');

  var fetchButton = document.getElementById('fetch-button');


  fetchButton.addEventListener('click', function() {

    var month = monthSelect.value;

    var year = yearSelect.value;


    // Update the chart with the selected month and year

    updateChart(new Date(year, month - 1, 1), new Date(year, month, 0));

  });


  function updateChart(startDate, endDate) {

    var startYear = startDate.getFullYear();

    var startMonth = startDate.getMonth() + 1;

    var startDay = startDate.getDate();

    var endYear = endDate.getFullYear();

    var endMonth = endDate.getMonth() + 1;

    var endDay = endDate.getDate();


    var month = startMonth;

    var year = startYear;

    var data = [];


    while (year <= endYear || (year === endYear && month <= endMonth)) {

      var daysInMonth = new Date(year, month, 0).getDate();

      for (var day = 1; day <= daysInMonth; day++) {

        var date = new Date(year, month - 1, day);

        if (date >= startDate && date <= endDate) {

          data.push({

            nroUnidad: 'Unit ' + Math.floor(Math.random() * 10),

            Monday: Math.floor(Math.random() * 100),

            Tuesday: Math.floor(Math.random() * 100),

            Wednesday: Math.floor(Math.random() * 100),

            Thursday: Math.floor(Math.random() * 100),

            Friday: Math.floor(Math.random() * 100),

            Saturday: Math.floor(Math.random() * 100),

            Sunday: Math.floor(Math.random() * 100)

          });

        }

      }

      if (month < 12) {

        month++;

      } else {

        month = 1;

        year++;

      }

    }


    var formattedData = [];

    data.forEach(item => {

      formattedData.push({

        name: item.nroUnidad,

        value: [

          item.Monday,

          item.Tuesday,

          item.Wednesday,

          item.Thursday,

          item.Friday,

          item.Saturday,

          item.Sunday

        ]

      });

    });


    option.dataset.source = formattedData;

    option.series[0].data = formattedData; // Update the line chart data

    option.series[1].data = formattedData; // Update the pie chart data


    // Update the chart

    myChart.setOption(option);

  }

</script>


<script type="text/javascript">
  // Solicitar permiso para mostrar notificaciones

    Notification.requestPermission(function(status) {

      if (status === "granted") {

        console.log("Permiso concedido para mostrar notificaciones");

      } else {

        console.log("Permiso denegado para mostrar notificaciones");

      }

    });


    // Crear notificación cuando se hace clic en el botón

    document.getElementById("btn-notificar").addEventListener("click", function() {

      if (window.Notification && Notification.permission === "granted") {

        var n = new Notification("Hola, mundo!", {

          tag: "mi-notificacion",

          body: "Este es el cuerpo de la notificación",

          icon: "icono.png"

        });


        // Agregar eventos a la notificación

        n.addEventListener("show", function() {

          console.log("Notificación mostrada!");

        });


        n.addEventListener("click", function() {

          console.log("Notificación clickeada!");

        });


        n.addEventListener("close", function() {

          console.log("Notificación cerrada!");

        });

      }

    });
</script>

<script>

  document.getElementById("btn-notificar").addEventListener("click", function() {

    Notification.requestPermission(function(status) {

      if (status === "granted") {

        console.log("Permiso concedido para mostrar notificaciones");

      } else {

        console.log("Permiso denegado para mostrar notificaciones");

      }

    });

  });

</script>
<!--script type="text/javascript">
    $.ajax({

    url: 'modelos/script.php',

    type: 'GET',

    data: {

        fechaInicial: '...',

        fechaFinal: '...'

    },

    success: function(response) {

        $('#result').html(response);

    },

    error: function(jqXHR, textStatus, errorThrown) {

        console.error('Error:', textStatus, errorThrown);

    }

});
</script-->


    
    <!--script>
      Morris.Line({
        element: 'chart_line',
        data: [
          { year: '1958', nb: 1 },
          { year: '1962', nb: 2 },
          { year: '1970', nb: 3 },
          { year: '1994', nb: 4 },
          { year: '2002', nb: 5 }
        ],
        xkey: 'year',
        ykeys: ['nb'],
        labels: ['Editions Wins'],



        resize: true,
             lineColors: ['#efefef'],

        lineWidth: 2,

        hideHover: 'auto',

        gridTextColor: '#fff',

        gridStrokeWidth: 0.4,

        pointSize: 4,

        pointStrokeColors: ['#efefef'],

        gridLineColor: '#efefef',

        gridTextFamily: 'Open Sans',

        gridTextSize: 10
      });
    </script-->


<!--script>
var jsonData = <?php echo json_encode($data); ?>;
var line = new Morris.Line({

        element: 'line-chart-ventas',

        resize: true,

        data: jsonData,

        xkey: 'y',

        ykeys: ['cantidad'],

        labels: ['Pasajeros'],

        lineColors: ['#efefef'],

        lineWidth: 2,

        hideHover: 'auto',

        gridTextColor: '#fff',

        gridStrokeWidth: 0.4,

        pointSize: 4,

        pointStrokeColors: ['#efefef'],

        gridLineColor: '#efefef',

        gridTextFamily: 'Open Sans',

        gridTextSize: 10

    });

</script-->