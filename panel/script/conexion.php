<?php

$server = "acerosocotlan.mx";
$user = "acerosoc_root" ;
$bd = "acerosoc_acerosocotlan_iso9000";
$pass = "Acer0cotlan232";



// $ip = $_SERVER['REMOTE_ADDR'];
$conex =mysql_connect($server,$user,$pass) or die(mysql_error());
mysql_select_db($bd,$conex)or die(mysql_error());



?>