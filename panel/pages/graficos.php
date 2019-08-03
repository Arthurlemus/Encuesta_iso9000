 <script>
 function labelFormatter(label, series) {
  return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
  + label
  + "<br>"
  + Math.round(series.percent) + "%</div>";
}
</script>

<!-- Main row -->
<div class="row">
<div class="col-md-6 alert alert-info" style="text-align:center;color: black;">
<span ><b>Total de Encuestas: <span id="totalito"></span></b></span>
</div>
<div class="col-md-6 alert alert-info" style="text-align:center;color: black;">
<span ><b>Indice de Satisfaccion: <span id="totsatis"></span></b></span>
</div>
</div>


<div class="row">

<section class="col-sm-6">
<!-- <div id="totalitov" class="text-center mdl-badge" ></div> -->
<div id="P1"></div>
</section>

<section class="col-sm-6">
<div id="P2"></div>
</section>
</div>

<hr>

<div class="row">
<section class="col-sm-6">
<div id="P3"></div>
</section>

<section class="col-sm-6">
<div id="P4"></div>
</section>
</div>
<hr>

<div class="row">
<section class="col-sm-6">
<div id="P5"></div>
</section>

<section class="col-sm-6">
<div id="P6"></div>
</section>
</div>
<hr>

<div class="row">
<section class="col-sm-6">
<div id="P7"></div>
</section>

<section class="col-sm-6">
<div id="P8"></div>
</section>
</div>
<hr>

<div class="row">
<section class="col-sm-6">
<div id="P9"></div>
</section>

<section class="col-sm-6">
<div id="P10"></div>
</section>
</div>
<hr>


<?php
include("../script/conexion.php");

$inicio = $_POST['inicio'];
$fin = $_POST['fin'];
$suc = $_POST['suc'];
$donde = "";
$donde2 = "";

$ponderacionxEncuesta=45; // Pondetracion Maxima por encuesta segun las preguntas

if($suc != "TODAS")
{
  $donde = " and empresa='".$suc."' ";
  $donde2 = "and empresa='".$suc."'";
}

// =================================
// Sacar el total de Encuestas
// =================================

$sqlt = mysql_query("SELECT sum(total) as total FROM (SELECT any_value(sucursal) as sucursal,count(cod_pregunta) as total,empresa FROM respuestas WHERE fecharespuesta between '{$inicio}' and '{$fin}'  ".$donde2."  group by empresa order by empresa,total) as tabla",$conex)or die(mysql_error());
$tEnc = mysql_fetch_assoc($sqlt);
$totEnc = round(($tEnc['total']/11));

// =================================
// Lista de Preguntas
// =================================
$sqllista =mysql_query("SELECT pregunta FROM preguntas where activo=1") ;
$lista = [];
while($d = mysql_fetch_assoc($sqllista)){
  $lista[] = utf8_encode($d['pregunta']);
}

// ===============================
// Indice de Satisfaccion General
// ===============================
$ponderacionMaxima = round($ponderacionxEncuesta*$totEnc); // Ponderacion Maxima por total de Encuestas
$satisfaccion = 0;$totSatis = 0;
$sqlmax = mysql_query("SELECT opcion,cantidad,ponderacion,(cantidad*ponderacion) as satisfaccion
FROM(SELECT opcion,count(opcion)as cantidad
,(SELECT ponderacion FROM preguntas_opciones WHERE opcion=r.opcion limit 1)as ponderacion
FROM respuestas r where cod_pregunta not in('P1','P11') and fecharespuesta between '{$inicio}' and '{$fin}' {$donde} group by opcion) tabla");
$numsatis = mysql_num_rows($sqlmax);
if($numsatis>0){
  while($s = mysql_fetch_assoc($sqlmax)){
      $totSatis = ($totSatis+$s['satisfaccion']);
  }
  $satisfaccion = round(($totSatis/$ponderacionMaxima)*100,2);
}

// ===============================
// Variables de Resultados
// ===============================
$datosP1 = "";$datosP2 = "";$datosP3 = "";
$datosP4 = "";$datosP5= "";$datosP6 = "";
$datosP7 = "";$datosP8 = "";$datosP9 = "";
$datosP10 = "";$datosP11 = "";$datosP12 = "";
$datosP13 = "";$datosP14 = "";$datosP15 = "";
$datosP16 = "";$datosP17 = "";$datosP18 = "";
$datosP19 = "";$datosP20 = "";
// ===============================

// echo "SELECT opcion,count(opcion)as cantidad FROM respuestas where cod_pregunta='P1' ".$donde." group by opcion";
// ===============================
// Armado de Graficos
// ===============================
for($i=1;$i<=10;$i++)
{
  
  
  $numpregunta = "numP".$i;
  $sqlpregunta = "sqlP".$i;
  $datospregunta = "datosP".$i;
  
  // ===============================
  // Consultas para Graficos
  // ===============================
  $$sqlpregunta = mysql_query("SELECT opcion,count(opcion)as cantidad FROM respuestas where cod_pregunta='P{$i}' ".$donde." and fecharespuesta between '{$inicio}' and '{$fin}' group by opcion ",$conex) or die(mysql_error());
  // echo "SELECT opcion,count(opcion)as cantidad FROM respuestas where cod_pregunta='P{$i}' ".$donde." and fecharespuesta between '{$inicio}' and '{$fin}' group by opcion";
  // ===============================
  // Conteo de Filas
  // ===============================
  $$numpregunta = mysql_num_rows($$sqlpregunta);
  // ===============================
  
  if($$numpregunta>0)
  {
    while($g = mysql_fetch_assoc($$sqlpregunta))
    {
      if($$datospregunta=="")
      {
        $$datospregunta ="{ name: '".utf8_encode($g['opcion'])." (".$g['cantidad'].")', y: ".$g['cantidad']." }"; 
      }else{
        $$datospregunta = $$datospregunta.",{ name: '".utf8_encode($g['opcion'])." (".$g['cantidad'].")', y: ".$g['cantidad']." }"; 
      }
    }
  }else{
    $$datospregunta = "{name: 'Sin Datos', y: 0}";
  }
}



echo "<script>";


for($ga=0;$ga<=9;$ga++)
{
  $p = $ga+1;
  $datospregunta = "datosP".$p;
  $id = "P".$p;
  
  echo "Highcharts.chart('".$id."', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: '".$p.".- ".$lista[$ga]."'
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
      data: [".$$datospregunta."]
    }]
  });";
}



echo "$('#totalito').html(".$totEnc.");" ;
echo "$('#totsatis').html('".$satisfaccion." %');" ;
echo "</script>";

?>


<div class="modal fade" tabindex="-1" role="dialog" id="detalle_grafico">
<div class="modal-dialog" role="document">
<div class="modal-content" style="overflow: scroll;">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title"><!-- titulo del Modal --></h4>
</div>
<div class="modal-body" style="width: 100%" > 
<!-- Contenido del Modal -->
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


