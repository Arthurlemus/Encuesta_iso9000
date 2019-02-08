<?php
date_default_timezone_set("Mexico/General");
include("conexion.php");

$codigo = $_POST['codigo']; // Codigo de la pregunta
$codigoencuesta = $_POST['codigoencuesta']; // Codigo de la encuesta
$respuesta = $_POST['respuesta'];
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

if($codigo!="" && $respuesta!="" && $sucursal!="" && $origen!="" && $codigoencuesta!="")
{


mysql_query("START TRANSACTION;");
mysql_query("BEGIN;");


$insertar = mysql_query("INSERT INTO respuestas(cve_encuesta,clave,cod_pregunta,opcion,sucursal,factura,fecharespuesta,horarespuesta,origen,ip,why,example)VALUES ('".$codigoencuesta."','".$pin."','".$codigo."','".utf8_encode($respuesta)."','".$sucursal."','".$factura."',date(now()),date_add(time(now()),INTERVAL -1 HOUR),'".$origen."','".$ip."','".$why."','".$example."')");


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