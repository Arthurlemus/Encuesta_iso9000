<?php


$server = "Servior";
$user = "Usuario" ;
$bd = "Base de datos";
$pass = "PassBD";



$conex = mysql_connect($server,$user,$pass)or die ("Error: ".mysql_error());
mysql_select_db($bd) or die("Error: ".mysql_error());

?>
