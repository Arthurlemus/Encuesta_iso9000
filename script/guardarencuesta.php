<?php
date_default_timezone_set("Mexico/General");
include("conexion.php");


// &extra="+extra+"&why="+why+"&example="+example,

$p1 = $_POST['P1']; $p2 = $_POST['P2'];$p3 = $_POST['P3']; $p4 = $_POST['P4'];
$p5 = $_POST['P5']; $p6 = $_POST['P6'];$p7 = $_POST['P7']; $p8 = $_POST['P8'];
$p9 = $_POST['P9'];$p10 = $_POST['P10'];$p11 = $_POST['P11'];


$codigoencuesta = $_POST['codigoencuesta']; // Codigo de la encuesta

$company = $_POST['company'];
$who = $_POST['who'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];


if($_POST['P11']==""){$_POST['P11']="-";}
if($telephone==""){$telephone="-";}


// $codigo = $_POST['codigo']; // Codigo de la pregunta
// $respuesta = $_POST['respuesta'];
$sucursal = $_POST['sucursal'];
$origen = $_POST['origen'];
$factura = $_POST['factura'];
$pin = $_POST['pin'];
$ip = $_SERVER['REMOTE_ADDR'];

$extra = $_POST['extra'];
$why = $_POST['why']; // Pregunta 1 adicional
$example = $_POST['example']; // Pregunta 2 adicional

$good = true;
$mjs = "";

// if($codigo!="" && $respuesta!="" && $sucursal!="" && $origen!="" && $codigoencuesta!="")
if($sucursal!="" && $origen!="" && $codigoencuesta!="")
{

mysql_query("START TRANSACTION;");
mysql_query("BEGIN;");

$values="";

for ($i=1;$i<=11;$i++)
{
	$op = "P".$i;
	if($values==""){
		$values = "('{$codigoencuesta}','{$pin}','P{$i}','".utf8_decode($_POST[$op])."','{$sucursal}','{$factura}',date(now()),date_add(time(now()),INTERVAL -1 HOUR),'{$origen}','{$ip}','{$why}','{$example}','".utf8_decode($company)."','".utf8_decode($who)."','{$telephone}','{$email}')";
	}else{
		$values = $values. ",('{$codigoencuesta}','{$pin}','P{$i}','".utf8_decode($_POST[$op])."','{$sucursal}','{$factura}',date(now()),date_add(time(now()),INTERVAL -1 HOUR),'{$origen}','{$ip}','{$why}','{$example}','".utf8_decode($company)."','".utf8_decode($who)."','{$telephone}','{$email}')";
		
	}
}

$insertar = mysql_query("INSERT INTO respuestas(cve_encuesta,clave,cod_pregunta,opcion,sucursal,factura,fecharespuesta,horarespuesta,origen,ip,why,example,empresa,quienrealiza,telefono,correo)VALUES {$values}");

// $msj = $values;
// $msj = mysql_error();
if($insertar!=1)
{
	mysql_query("ROLLBACK");
	$good = false;
	$msj = "Error, Intente Nuevamente";
}



}else{
	$good = false;
	$msj = "Error, Datos incompletos";
}


if($good == true)
{
	mysql_query("COMMIT");
	$msj =  "correcto";
	echo $msj;

}else{

	echo $msj;
}


?>