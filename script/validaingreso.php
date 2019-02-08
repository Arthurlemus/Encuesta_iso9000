<?php
session_start();
include("conexion.php");

$pin = $_POST['pin'];

$busca_pin = mysql_query("SELECT pin,nombre,sucursal,estatus,c.cve_encuesta,descripcion FROM claves c INNER JOIN encuesta e ON e.cve_encuesta=c.cve_encuesta and e.activo=1
	WHERE pin='".$pin."' and c.activo=1 and estatus in('INCOMPLETA','INICIADA')",$conex) or die(mysql_error());

$pines = mysql_fetch_assoc($busca_pin);

if(isset($pines['pin']))
{

	if(isset($_SESSION['pin']))
	{
		if($_SESSION['pin']){session_unset($_SESSION['pin']);}
		if($_SESSION['nombre']){session_unset($_SESSION['nombre']);}
		if($_SESSION['sucursal']){session_unset($_SESSION['sucursal']);}
		if($_SESSION['cve_encuesta']){session_unset($_SESSION['cve_encuesta']);}
		if($_SESSION['siguiente']){session_unset($_SESSION['siguiente']);}
		if($_SESSION['conencuesta']){session_unset($_SESSION['conencuesta']);}
		echo "backhome|";

	}else{
		$_SESSION['pin'] = $pines['pin'];
		$_SESSION['nombre'] = $pines['nombre'];
		$_SESSION['sucursal'] = $pines['sucursal'];
		$_SESSION['cve_encuesta'] = $pines['cve_encuesta'];
		$_SESSION['siguiente'] = 0;
		$_SESSION['conencuesta'] = 0; // Si ya tiene encuesta realizada
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	$update = mysql_query("UPDATE claves SET ultimoacceso=date_add(now(),INTERVAL -1 HOUR) WHERE pin='".$pines['pin']."'");

	if($pines['estatus']=="INCOMPLETA")
	{
		$update2 = mysql_query("UPDATE claves SET estatus='INICIADA' WHERE pin='".$pines['pin']."'");

	}else{

		$_SESSION['conencuesta']=1; // Ya tiene encuesta
	}

			// $historial = mysql_query("INSERT INTO enc_historial (pin,fecha,hora,ip)VALUES ('".$pines['pin']."',date(now()),date_add(time(now()),INTERVAL -1 HOUR),'".$ip."')");

	echo "encontrado|".$pines['pin']."|".$pines['nombre']."|".$pines['sucursal']."|".$pines['cve_encuesta'];


}else{

	$busca_pin = mysql_query("SELECT pin,nombre,sucursal,estatus,c.cve_encuesta,descripcion FROM claves c INNER JOIN encuesta e ON e.cve_encuesta=c.cve_encuesta and e.activo=1
	WHERE pin='".$pin."' and c.activo=1 and estatus = 'TERMINADA'",$conex) or die(mysql_error());
	
	$num = mysql_num_rows($busca_pin);
	
	if($num>0){echo "Encuesta Completa, Gracias|";}else{echo "Clave Incorrecta o Inactiva|";}
	
	if($_SESSION['pin']){session_unset($_SESSION['pin']);}
	if($_SESSION['nombre']){session_unset($_SESSION['nombre']);}
	if($_SESSION['sucursal']){session_unset($_SESSION['sucursal']);}
	if($_SESSION['cve_encuesta']){session_unset($_SESSION['cve_encuesta']);}
	if($_SESSION['siguiente']){session_unset($_SESSION['siguiente']);}
	if($_SESSION['conencuesta']){session_unset($_SESSION['conencuesta']);}
}

?>