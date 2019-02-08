<?php

$server = "Servior";
$user = "Usuario" ;
$bd = "Base de datos";
$pass = "PassBD";


// $ip = $_SERVER['REMOTE_ADDR'];
$conex =mysql_connect($server,$user,$pass) or die(mysql_error());
mysql_select_db($bd,$conex)or die(mysql_error());



?>