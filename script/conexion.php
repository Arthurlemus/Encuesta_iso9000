<?php

$server = "acerosocotlan.mx";
// $user = "acerosocotlan_iso9000" ;
$user = "acerosoc_root" ;
$bd = "acerosocotlan_iso9000";
$pass = "Acer232Ros";
// $pass = "Aceros089";


$conex = mysql_connect($server,$user,$pass)or die ("Error: ".mysql_error());
mysql_select_db($bd) or die("Error: ".mysql_error());

?>
