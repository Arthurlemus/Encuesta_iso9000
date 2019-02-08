

<div class="mdl-js-grid mdl-grid">
  <!-- ======================================= -->
  <!-- Primera Grafica -->
  <!-- ======================================= -->
  <section class="mdl-cell mdl-cell--6-col">
      <div id="totalitov" class="text-center mdl-badge" >Total: <b>0</b></div>
   <div id="grafico_vendedor"></div>
</section>

  <section class="mdl-cell mdl-cell--6-col">
   <div id="totalitoc" class="text-center mdl-badge" >Total: <b>0</b></div>
   <div id="grafico_chofer"></div>
</section>
</div>
<hr>
<div class="mdl-js-grid mdl-grid">
  <section class="mdl-cell mdl-cell--6-col">
       <div id="totalitom" class="text-center mdl-badge" >Total: <b>0</b></div>
   <div id="grafico_material"></div>
</section>

  <section class="mdl-cell mdl-cell--6-col">
       <div id="totalitot" class="text-center mdl-badge" >Total: <b>0</b></div>
   <div id="grafico_tiempo"></div>
</section>

</div>

<div class="mdl-js-grid mdl-grid">
<section class="mdl-cell mdl-cell--6-col">
       <div id="totalitoap" class="text-center mdl-badge" >Total: <b>0</b></div>
   <div id="grafico_aplicacion"></div>
</section>
</div>

<hr>
<!-- Mini Cuadritos -->
<!-- <div class="row">
    
    <div class="col-sm">
      <div class="card" style="background:lightblue;">
      <h5 class="card-title text-center">Total de Pedidos</h5>
        <div class="card-body text-center" id="tpedidos">0</div>
      </div>
    </div>

    <div class="col-sm">
      <div class="card" style="background:lightgreen;">
      <h5 class="card-title text-center">Completos</h5>
        <div class="card-body text-center" id="tcompletos">0</div>
      </div>
    </div>

</div> -->

<!-- Detalle en tabla -->
<!-- <div class="row">
    <div class="col-sm">
            <table class="table" id="tablevendedor">
                <thead>
                    <tr>
                        <th>Vendedor</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                   <tr>
                       <td>Gabriel</td>
                       <td>50</td>
                   </tr>
                   <tr>
                       <td>Marco</td>
                       <td>125</td>
                   </tr>
                   <tr>
                       <td>Martha</td>
                       <td>45</td>
                   </tr>
                   <tr>
                       <td>Miguel</td>
                       <td>78</td>
                   </tr>
                   <tr>
                       <td>Francisco</td>
                       <td>89</td>
                   </tr>
                  Contenido desde webservice
                </tbody>
            </table>
    </div>
</div> -->


<?php
require_once("../script/clases.php");
$directorio = new Urls;

$inicio = $_POST["inicio"];
$fin = $_POST["fin"];

$graficoV = "";
$graficoC = "";
$graficoM = "";
$graficoT = "";
$graficoAP = "";

$urlV = $directorio->graficoencuesta("vendedor", $inicio,$fin);
$urlC = $directorio->graficoencuesta("chofer", $inicio,$fin);
$urlM = $directorio->graficoencuesta("material", $inicio,$fin);
$urlT = $directorio->graficoencuesta("tiempo", $inicio,$fin);
$urlAP = $directorio->graficoencuesta("aplicacion", $inicio,$fin);

// ─────────────────────────────────────────────────────────────────────────
//   :::::: I N D I C A D O R V T A S : :  :   :    :     :        :          :
// ────────────────────────────────────────────────────────────────────────────
$urlvtasTotal = $directorio->indicadorvtas($inicio,$fin,'total');
$vtasTotal = json_decode($urlvtasTotal);// Total de pedidos Incompletos o completos
$urlvtasDetalle = $directorio->indicadorvtas($inicio,$fin,'detalle');
 $vtasDetalle = json_decode($urlvtasDetalle); // Detalle de que vendedores los hicieron completos


// ─── - ──────────────────────────────────────────────────────────────────────────

    

$vendedor =  json_decode($urlV);
$chofer =  json_decode($urlC);
$material =  json_decode($urlM);
$tiempo =  json_decode($urlT);
$aplicacion =  json_decode($urlAP);
$rows = "";// Para guardar el detalle de la tabla

if(isset($vtasDetalle)){
    foreach($vtasDetalle as $num => $detalle){
        // $rows = $rows."<tr><td>{$detalle->vendedor}</td><td>{$detalle->cantidad}</td></tr>";
        $rows = "<tr><td>-</td><td>-</td></tr>";
    }
}else{
    $rows = "<tr><td>-</td><td>-</td></tr>";
}


$totalV = 0;
$totalC = 0;
$totalM = 0;
$totalT = 0;
$totalAP = 0;

foreach ($vendedor as $num => $vend) {
    $graficoV = $graficoV."{ name: '".$vend->respuesta."', y: ".$vend->conteo." },";
      $totalV = $totalV+$vend->conteo;
}

foreach ($chofer as $num => $chof) {
    $graficoC = $graficoC."{ name: '".$chof->respuesta."', y: ".$chof->conteo." },";
    $totalC = $totalC+$chof->conteo;
}

foreach ($material as $num => $mat) {
    $graficoM = $graficoM."{ name: '".$mat->respuesta."', y: ".$mat->conteo." },";
      $totalM = $totalM+$mat->conteo;
}

foreach ($tiempo as $num => $tiem) {
    $graficoT = $graficoT."{ name: '".$tiem->respuesta."', y: ".$tiem->conteo." },";
      $totalT = $totalT+$tiem->conteo;
}


foreach ($aplicacion as $num => $aplic){
    $graficoAP = $graficoAP."{ name: '".$aplic->respuesta."', y: ".$aplic->conteo." },";
    $totalAP = $totalAP+$aplic->conteo;
}


echo "<script>";

echo "Highcharts.chart('grafico_vendedor', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Servicio del Vendedor'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            }
        }
    },
    series: [{
        name: ' ',
        data: [".substr($graficoV,0,-1)."]
    }]
});";


echo "Highcharts.chart('grafico_chofer', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Servicio del Chofer'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            }
        }
    },
    series: [{
        name: ' ',
        data: [".substr($graficoC,0,-1)."]
    }]
});";


echo "Highcharts.chart('grafico_material', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Satisfacción del Material'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            }
        }
    },
    series: [{
        name: ' ',
        data: [".substr($graficoM,0,-1)."]
    }]
});";


echo "Highcharts.chart('grafico_tiempo', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Tiempo de Entrega'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            }
        }
    },
    series: [{
        name: ' ',
        data: [".substr($graficoT,0,-1)."]
    }]
});";



echo "Highcharts.chart('grafico_aplicacion', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Calificación de la Aplicación'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            }
        }
    },
    series: [{
        name: ' ',
        data: [".substr($graficoAP,0,-1)."]
    }]
});";



echo "$('#totalitov b').html(".$totalV.");";
echo "$('#totalitoc b').html(".$totalC.");";
echo "$('#totalitom b').html(".$totalM.");";
echo "$('#totalitot b').html(".$totalT.");";
echo "$('#totalitoap b').html(".$totalAP.");";
echo "$('#tpedidos').html(".$vtasTotal[0]->totalpedidos.");";
echo "$('#tcompletos').html(".$vtasTotal[0]->completos.");";
// echo "$('#tablavendedor').html(".$rows.");";

echo "</script>";
?>