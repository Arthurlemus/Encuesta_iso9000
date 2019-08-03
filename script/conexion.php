<?php

$server = "acerosocotlan.mx";
$user = "acerosoc_root" ;
$bd = "acerosoc_acerosocotlan_iso9000";
$pass = "Acer0cotlan232";


$conex = mysql_connect($server,$user,$pass)or die ("Error: ".mysql_error());
mysql_select_db($bd) or die("Error: ".mysql_error());

?>
