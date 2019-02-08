<?php
session_start();

require("../script/conexion.php"); 

$limit = $_POST['siguientepregunta'];
$_SESSION['pin'] = "-";
// echo $limit;
// ====================================
// Validar si tiene ya una encuesta
// ====================================
if($_SESSION['conencuesta']==1)
{
	$sqlenc = mysql_query("SELECT count(cod_pregunta) as numpreguntas FROM respuestas where clave='".$_SESSION['pin']."' and cve_encuesta='".$_SESSION['cve_encuesta']."'");

	$encIniciada = mysql_fetch_assoc($sqlenc);
	$limit = $encIniciada['numpreguntas'];
	$_SESSION['conencuesta']=0;
	echo "<script>
			siguientepregunta = ".$limit."
	</script>";
}
// ====================================


$sql = mysql_query("SELECT cod_pregunta,pregunta,cve_encuesta,extra,if(grupo='-',' ',grupo)as grupo FROM preguntas where activo=1 and cve_encuesta='".$_SESSION['cve_encuesta']."' order by cve_pregunta limit ".$limit.",1");


// ==============================
// Obtiene el total de preguntas
// ==============================
$sqltotalpreguntas = mysql_query("SELECT cod_pregunta,pregunta FROM preguntas where activo=1 and cve_encuesta='".$_SESSION['cve_encuesta']."'");
$numtotalpreguntas = mysql_num_rows($sqltotalpreguntas);
$numtotalpreguntas = $numtotalpreguntas-1;
echo "<input type='hidden' value='".$numtotalpreguntas."'/>";
// ==============================



$pregunta = mysql_fetch_assoc($sql);

$conteo = $limit+1;
if($pregunta['pregunta']!="")
{


	echo "<center>".utf8_encode($pregunta['grupo'])."</center><div class='row'>
	<div class='col-xs-12'>
	<input type='hidden' value='".$pregunta['cod_pregunta']."' id='codigopregunta' />
	<input type='hidden' value='".$pregunta['cve_encuesta']."' id='codigoencuesta' />
	<input type='hidden' value='".$_SESSION['pin']."' id='pinencuesta' />
	<h4 class='well'><b>{$conteo}. ".utf8_encode($pregunta['pregunta'])."</b></h4>
	</div>";


	$sqlopciones = mysql_query("SELECT cve_opciones,po.cod_pregunta,opcion,imagen,tipo,tipoimg FROM preguntas_opciones po INNER JOIN preguntas p ON p.cod_pregunta=po.cod_pregunta WHERE po.activo =1 and po.cod_pregunta='".$pregunta['cod_pregunta']."' and cve_encuesta='".$pregunta['cve_encuesta']."'");





    echo "<div class='col-xs-12' style='padding-left:13%;'>";
    

	while($d = mysql_fetch_assoc($sqlopciones))
	{
		
		if($d['tipo']=="radio")
			{
				$tamanio=2;
				$input_opcion = "<input type='".$d['tipo']."' name='respuesta' value='".utf8_encode($d['opcion'])."' id='respuesta' onclick=''/>";
				// $input_opcion = "<label id='caritas'><input type='".$d['tipo']."' name='respuesta".$i."' value='".$d['opcion']."' id='respuesta".$i."' onclick='".$onclick."'/><img src='css/img/".$d['imagen'].$d['tipoimg']."' width='45%'/></label>";

			}else if($d['tipo'] == "text"){
				$tamanio=12;
				$input_opcion = "<input type='".$d['tipo']."' name='respuesta' value='' id='respuesta'  class='form-control' placeholder='".utf8_encode($d['imagen'])."'  maxlength='199'/>";
			}

	echo "<div class='col-md-".$tamanio."' style='padding:0;border-radius:0 0 7px 7px;background:#7ED6FE'>";
		echo "
		    <span for='respuesta' style='background:#0F3A7A;color:white;display:block;width:100%;text-align:center'><b>".utf8_encode($d['opcion'])."</b></span>";
		echo "<p style='text-align:center'>".$input_opcion."</p>";
	echo "</div>";
	}

echo "</div>";

// =======================================
// Pregunas Extras Adicionales
// =======================================
echo "<input type='hidden' value='".$pregunta['extra']."' id='extra' />";

if($pregunta['extra']==1)
{	
   echo "<div class='col-xs-12' style='margin-top:2%;'>
		
	    	<div class='col-md-4'>
		    	<label for='why'>¿Por qué?</label>
			    <input type='text' value='' class='form-control' id='why' placeholder='-'/>
		    </div>

		    <div class='col-md-4'>
			  <label for='example'>Da ejemplos o casos concretos</label>
			  <input type='text' value='' class='form-control' id='example' placeholder='-'/>
		    </div>";

   echo "</div>";
}
// =======================================


// ============================
// Mini Loading por pregunta
// ============================
echo "<div class='overlay' style='text-align:center;position:absolute;left:47%;top:45%;' id='mini_loading'>
		<i class='fa fa-refresh fa-spin' style='font-size: 50px;'></i>
	</div>";
// ============================


// ============================
// Boton de Siguiente
// ============================
echo "<div class='col-xs-12' style='margin-top:4%;text-align:center' id='btn_siguiente' >
	<button class='btn btn-success' onclick='pregunta_siguiente();'>Siguiente</button>
	</div>";
// ============================


// ============================
// Barra de Progreso
// ============================
	echo "<div class='col-xs-12' style='margin-top:4%' >
	<progress value='0' max='100' id='progressbar'></progress><span class='valorbarra'><b>0%</b></span>
	</div>
	<span style='float:right;margin:0:padding:0 5px'>FO-VE-03 Rev.0</span>
	</div>";
// ============================

}else{
	echo "<div class='row'>
	   <div class='col-xs-12'>
	      <h2 style='text-align:center'><b>¡Gracias por su tiempo!</h2>
	      <p style='text-align:center;font-size:20px'>Encuesta finalizada</p>
	      <img src='css/img/final2.png' style='display:block;margin:0 auto;width:30%;cursor:pointer' onclick='encuesta_finalizada();'/>
	   </div>
	</div>";

	$EncCompleta = mysql_query("UPDATE claves SET estatus='TERMINADA' WHERE pin='".$_SESSION['pin']."' and cve_encuesta='".$_SESSION['cve_encuesta']."'",$conex)or die(mysql_error());
}


?>




<style>
progress {
	background-color: #f3f3f3;
	border: 0;
	width: 80%;
	height: 18px;
	border-radius: 9px;
	margin: 5px auto;
	display: block;
}
progress::-webkit-progress-bar {
	background-color: #f3f3f3;
	border-radius: 9px;
	margin: 0 auto;
}
progress::-webkit-progress-value {
	background: #cdeb8e;
	background: -moz-linear-gradient(top,  #cdeb8e 0%, #a5c956 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#cdeb8e), color-stop(100%,#a5c956));
	background: -webkit-linear-gradient(top,  #cdeb8e 0%,#a5c956 100%);
	background: -o-linear-gradient(top,  #cdeb8e 0%,#a5c956 100%);
	background: -ms-linear-gradient(top,  #cdeb8e 0%,#a5c956 100%);
	background: linear-gradient(to bottom,  #cdeb8e 0%,#a5c956 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cdeb8e', endColorstr='#a5c956',GradientType=0 );
	border-radius: 9px;
}
progress::-moz-progress-bar {
	background: #cdeb8e;
	background: -moz-linear-gradient(top,  #cdeb8e 0%, #a5c956 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#cdeb8e), color-stop(100%,#a5c956));
	background: -webkit-linear-gradient(top,  #cdeb8e 0%,#a5c956 100%);
	background: -o-linear-gradient(top,  #cdeb8e 0%,#a5c956 100%);
	background: -ms-linear-gradient(top,  #cdeb8e 0%,#a5c956 100%);
	background: linear-gradient(to bottom,  #cdeb8e 0%,#a5c956 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cdeb8e', endColorstr='#a5c956',GradientType=0 );
	border-radius: 9px;
	margin: 0 auto;
}
.valorbarra
{
	padding: 0px 5px;
	line-height: 20px;
	margin: 0 auto;
	font-size: .8em;
	/*color: #555;*/
	color: blue;
	height: 18px;
	display: block;
	text-align: center;
}

</style>


<script>
	var numpreguntas = "<?php echo $numtotalpreguntas; ?>";
	var porcentaje = Math.round(siguientepregunta*100/numpreguntas);
	$("progress").val(porcentaje);
	$(".valorbarra").html("<b>"+ porcentaje +" %</b>");
</script>