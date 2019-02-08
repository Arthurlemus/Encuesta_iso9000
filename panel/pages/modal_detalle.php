<?php
include("../script/conexion.php");

$grafico = $_POST['grafico'];

$inicio = $_POST['inicio'];
$fin = $_POST['fin'];


// ======================================
// Consultas para el Detalle del grafico
// ======================================
if($grafico == 1)
{

	$sql = "SELECT fecha,quejasucursal,tipo,nombre as reporto,puesto,quejafecha,perjuicio,correo,telefono FROM gao_denuncia WHERE fecha between '".$inicio."' and '".$fin."'  order by quejasucursal";

	$query = mysql_query($sql,$conex)or die(mysql_error());

	$encabezados = "<tr style='background:#00A663'>
			<th>Sucursal</th>
			<th>Reporto</th>
			<th>Suceso</th>
			<th>Perjuicio</th>
			<th>Correo</th>
			<th>Telefono</th>
		</tr>";

	$detalle = ""	;

	while($d = mysql_fetch_assoc($query))
	{
			$detalle = $detalle."<tr>
			<td>".$d['quejasucursal']."</td><td>".$d['reporto']."</td>
		    <td>".$d['quejafecha']."</td><td>".utf8_encode($d['perjuicio'])."</td>
			<td>".$d['correo']."</td><td>".$d['telefono']."</td>
		</tr>";
	}


}else if($grafico ==2)
{
	$sql = "SELECT perjuicio,nombre as reporto,quejasucursal,quejanombre as implicado,quejafecha as suceso  FROM gao_denuncia  WHERE fecha between '".$inicio."' and '".$fin."'  order by perjuicio";

	$query = mysql_query($sql,$conex)or die(mysql_error());

	$encabezados = "<tr style='background:#00A663'>
			<th>Perjuicio</th>
			<th>Reporto</th>
			<th>S.Implicada</th>
			<th>P.Implicada</th>
			<th>F.Suceso</th>
		</tr>";

	$detalle = ""	;

	while($d = mysql_fetch_assoc($query))
	{
			$detalle = $detalle."<tr>
			<td>".utf8_encode($d['perjuicio'])."</td><td>".$d['reporto']."</td>
		    <td>".$d['quejasucursal']."</td><td>".$d['implicado']."</td>
			<td>".$d['suceso']."</td>
		</tr>";
	}

}else if($grafico == 3)
{
	$sql = "SELECT quejapuesto,nombre as reporto,quejafecha as suceso,descripcion FROM gao_denuncia WHERE fecha between '".$inicio."' and '".$fin."' order by quejapuesto ";

	$query = mysql_query($sql,$conex)or die(mysql_error());

	$encabezados = "<tr style='background:#00A663'>
			<th>P.Implicado</th>
			<th>Reporto</th>
			<th>F.Suceso</th>
			<th>Motivo</th>
		</tr>";

	$detalle = ""	;

	while($d = mysql_fetch_assoc($query))
	{
			$detalle = $detalle."<tr>
			<td>".utf8_encode($d['quejapuesto'])."</td><td>".$d['reporto']."</td>
		    <td>".$d['suceso']."</td><td>".utf8_encode($d['descripcion'])."</td>
		</tr>";
	}
}


echo "<table class='table table-hover table-bordered table-responsive' width='100%'>
	<thead>".$encabezados."</thead>
	<tbody style='background:#D0D0D0'>".$detalle."</tbody>
</table>";

?>
