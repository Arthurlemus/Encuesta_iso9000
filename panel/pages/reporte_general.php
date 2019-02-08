<?php
include("../script/conexion.php");

$inicio = $_POST['inicio'];
$fin = $_POST['fin'];
$suc = $_POST['suc'];
$donde = "";
$donde2 = "";

if($suc != "TODAS")
{
  $donde = " and sucursal='".$suc."' ";
   $donde2 = "WHERE sucursal='".$suc."'";
}


$sql = mysql_query("SELECT cod_pregunta as numpregunta,(SELECT pregunta FROM preguntas WHERE cod_pregunta=er.cod_pregunta)as pregunta,opcion,sucursal,fecharespuesta,horarespuesta,why,example
 FROM respuestas er WHERE fecharespuesta between '".$inicio."' and '".$fin."' ".$donde." order by sucursal,cve_respuesta,fecharespuesta",$conex)or die(mysql_error());

// echo "SELECT cod_pregunta as numpregunta,(SELECT pregunta FROM preguntas WHERE cod_pregunta=er.cod_pregunta)as pregunta,opcion,sucursal,factura,origen,fecharespuesta,horarespuesta
//  FROM respuestas er WHERE fecharespuesta between '".$inicio."' and '".$fin."' ".$donde." order by sucursal,numpregunta,fecharespuesta";


$num = mysql_num_rows($sql);


// =================================
// Sacar el total de Encuestas
// =================================
$sqlt = mysql_query("SELECT sum(total) as total FROM (SELECT sucursal,count(cod_pregunta) as total FROM respuestas ".$donde2."  group by sucursal order by sucursal,cod_pregunta) as tabla",$conex)or die(mysql_error());

$tEnc = mysql_fetch_assoc($sqlt);
$totEnc = round(($tEnc['total']/26));
// =================================


?>
<!-- Main row -->
<div class="row">
  <div class="col-md-12 alert alert-info" style="text-align:center;color: black;">
 <span class=""><b>Total de Encuestas: <span id="totalito"></span></b></span>
 </div>
</div>

  <section  style="overflow: scroll">
   <?php
   if($num>0)
   {
    echo "<button class='btn btn-success' onclick='descargarExcel();'>Exportar a Excel</button>

    <table class='table table-hover table-bordered'  id='tabla_general'>
    <thead>
    <tr style='background:#348EB8;color:white;'>
    <th align='center'>No.</th>
    <th align='center'>Fecha</th>
    <th align='center'>Num.Pregunta</th>
    <th align='center'>Pregunta</th>
    <th align='center'>Respuesta</th>
    <th align='center'>Sucursal</th>
    <th align='center'>¿Porque?</th>
    <th align='center'>Ejemplo</th>
    </tr>
    </thead>
    <tbody>";

    $folio = 1;
    while($d = mysql_fetch_assoc($sql))
    { 
      echo "<tr>
      <td align='center'>".$folio."</td>
      <td align='center'>".$d['fecharespuesta']."</td>
      <td align='center'>Pregunta #".str_replace('P','',$d['numpregunta'])."</td>
      <td align='center'>".utf8_encode($d['pregunta'])."</td>
      <td align='center'>".utf8_encode($d['opcion'])."</td>
      <td align='center'>".utf8_encode($d['sucursal'])."</td>
      <td align='center'>".utf8_encode($d['why'])."</td>
      <td align='center'>".utf8_encode($d['example'])."</td>";
      
      // if($d['evidencia']!="-.-")
      // {
        
      // echo "<td align='center'><a href='../evidencias/".$d['evidencia']."' target='_blank'><span class='glyphicon glyphicon-eye-open'></span></a></td>";

      // }else{
        
      // echo "<td align='center'><a href='#'><span class='glyphicon glyphicon-remove'></span></a></td>";
      // }

      echo "</tr>";
      

      $folio+=1;
    }
    echo "</tbody>
    </table>";

  }else{
    echo "<tr><td colspan='8'>Sin Registros de <b>".$inicio."</b> hasta <b>".$fin."</b></td></tr>";
  }
  ?>



</section>
<!-- </div> -->

<!-- page script -->
<?php
echo "<script>";
echo "$('#totalito').html(".$totEnc.");" ;
echo "</script>";
?>
<script>
  $(function () {
    $('#tabla_general').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": true
    });
  });
</script>


