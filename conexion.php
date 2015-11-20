<?php
$host="localhost";
$user="root";
$pass="";
//$db="base_ordenes";
$db="base_ordenes_2";
$link = mysql_connect($host,$user,$pass) or die ("Error durante la conexion a la base de datos"); 
mysql_select_db($db,$link);
date_default_timezone_set("America/La_Paz");
?>
