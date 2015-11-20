<?php
@session_start();
$login=$_SESSION["login"];
$tipo=$_SESSION["tipo"];
//echo 'Usuario loguead2: '.$login;
//echo '<br>';
//echo 'Usuario Tipo: '.$tipo;
if (!isset($login)) {
	header("location: index.php"); 
}
include ("conexion.php");


include("top.php");
echo "PAGINA EN CONSTRUCCION";
?>

