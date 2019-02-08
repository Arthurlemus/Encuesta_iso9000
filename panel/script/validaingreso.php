<?php
session_start();
include("../script/conexion.php");

$usuario = $_POST['usuario'];
$clave = md5($_POST['clave']);
 
$busca_usuario = mysql_query("SELECT nombre,usuario,clave,correo,area,ultimoacceso FROM usuarios_panel WHERE usuario='".$usuario."' and clave='".$clave."' and activo=1 ",$conex) or die(mysql_error());

$user = mysql_fetch_assoc($busca_usuario);

if(isset($user['usuario']))
{
	if($user['clave'] == $clave)
	{
		// if(isset($_SESSION['usuario']))
		// {
		// 	if($_SESSION['usuario']){session_unset($_SESSION['usuario']);}
		// 	if($_SESSION['nombre']){session_unset($_SESSION['nombre']);}
		// 	if($_SESSION['area']){session_unset($_SESSION['area']);}
		// 	if($_SESSION['correo']){session_unset($_SESSION['correo']);}


		// }else{
		// 	$_SESSION['usuario'] = $user['usuario'];
		// 	$_SESSION['nombre'] = $user['nombre'];
		// 	$_SESSION['area'] = $user['area'];
		// 	$_SESSION['correo'] = $user['correo'];


		// }
			$ip = $_SERVER['REMOTE_ADDR'];

			$update = mysql_query("UPDATE usuarios_panel SET ultimoacceso=now() WHERE usuario='".$user['usuario']."'");

			echo "encontrado|".$user['usuario']."|".$user['nombre']."|".$user['correo']."|".$user['area'];

			$historial = mysql_query("INSERT INTO historial_panel (pin,fecha,hora,ip)VALUES ('".$user['usuario']."',date(now()),time(now()),'".$ip."')");

	}else{
		echo "Contraseña Incorrecta|";
	}

}else{
	echo "Datos de Acceso Incorrectos|";
}

?>