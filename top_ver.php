<?php
//date_default_timezone_set('America/Caracas');
@session_start();
$login=$_SESSION["login"];
$tipo=$_SESSION["tipo"];
if (!isset($login)) {
	header("location: index.php"); 
}
include ("conexion.php");
/*$host="localhost";
$user="root";
$pass="";
$db="ordenes_de_trabajo";
$link = mysql_connect($host,$user,$pass) or die ("Error durante la conexion a la base de datos"); 
*/
?>