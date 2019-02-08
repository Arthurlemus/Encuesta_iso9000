<?php
include("../script/conexion.php");

$cve_encuesta = $_POST['cve_encuesta'];
$suc = $_POST['suc'];
$dondesuc = "";

if($suc != "TODAS")
{
 $dondesuc = " and sucursal='".$suc."' ";
 $donde2 = "WHERE sucursal='".$suc."'";
}

$sql = mysql_query("SELECT c.cve_encuesta,pin,sucursal,fecha,ultimoacceso,estatus FROM claves c
 INNER JOIN encuesta e ON e.cve_encuesta=c.cve_encuesta and e.activo=1 WHERE c.activo in(1,0) and e.cve_encuesta='".$cve_encuesta."' ".$dondesuc."  order by sucursal",$conex)or die(mysql_error());


$num = mysql_num_rows($sql);

echo $num;

// =================================
// Sacar el total de Encuestas
// =================================
$sqlt = mysql_query("SELECT sum(total) as total FROM (SELECT sucursal,count(cod_pregunta) as total FROM respuestas ".$donde2."  group by sucursal order by sucursal,cod_pregunta) as tabla",$conex)or die(mysql_error());

$tEnc = mysql_fetch_assoc($sqlt);
$totEnc = round(($tEnc['total']/29));
// =================================


?>
<!-- Main row -->
<div class="row">
 
  <div class="col-md-12 alert alert-info" style="text-align:center;color: black;">
   <span class=""><b>Total de Encuestas: <span id="totalito"></span></b></span>
 </div>

</div>

 <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-frown-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">INCOMPLETAS</span>
              <span class="info-box-number" id="incompletas" style="font-size: 35px;text-align: center;">0</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-play-circle"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">INICIADAS</span>
              <span class="info-box-number" id="iniciadas" style="font-size: 35px;text-align: center;">0</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-thumbs-up"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TERMINADAS</span>
              <span class="info-box-number" id="completas" style="font-size: 35px;text-align: center;">0</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

             <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-thumbs-down"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">BAJAS</span>
              <span class="info-box-number" id="bajas" style="font-size: 35px;text-align: center;">0</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
   
      </div>
      <!-- /.row -->




<section  style="overflow: scroll">
 <?php
 if($num>0)
 {
  echo "<button class='btn btn-success' onclick='descargarExcel();'>Exportar a Excel</button>

  <table class='table table-hover table-bordered'  id='tabla_general'>
  <thead>
  <tr style='background:#348EB8;color:white;'>
  <th align='center'>No.</th>
  <th align='center'>Encuesta</th>
  <th align='center'>Clave</th>
  <th align='center'>Sucursal</th>
  <th align='center'>Status</th>
  <th align='center'>Ultimo Acceso</th>
  </tr>
  </thead>
  <tbody>";

  $folio = 1;
  
  $iniciadas = 0;
  $completas = 0;
  $incompletas = 0;
  $bajas = 0;

  while($d = mysql_fetch_assoc($sql))
  { 
    $colorrow = "";
    if($d['estatus']=="TERMINADA"){$colorrow="#FFBB7D";$completas+=1;}else if($d['estatus']=="INCOMPLETA"){$colorrow="#F9984C";$incompletas+=1;}else if($d['estatus']=="INICIADA"){$colorrow="#0075AD";$iniciadas+=1;}else if($d['estatus']=="BAJA"){$colorrow="#E74744";$bajas+=1;}

    echo "<tr bgcolor='".$colorrow."'>
    <td align='center'>".$folio."</td>
    <td align='center'>".$d['cve_encuesta']."</td>
    <td align='center'>".$d['pin']."</td>
    <td align='center'>".utf8_encode($d['sucursal'])."</td>
    <td align='center'>".utf8_encode($d['estatus'])."</td>
    <td align='center'>".$d['ultimoacceso']."</td>";

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
  echo "<tr><td colspan='8'>Sin Registros en la Encuesta: <b>".$cve_encuesta."</b></td></tr>";
}
?>



</section>
<!-- </div> -->

<!-- page script -->
<?php
echo "<script>";
echo "$('#totalito').html(".$totEnc.");" ;
echo "$('#iniciadas').html(".$iniciadas.");" ;
echo "$('#completas').html(".$completas.");" ;
echo "$('#incompletas').html(".$incompletas.");" ;
echo "$('#bajas').html(".$bajas.");" ;
echo "</script>";
?>
<script>
  $(function () {
    $('#tabla_general').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": true
    });
  });
</script>


