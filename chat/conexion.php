<?php
$host="127.0.0.1";
$user="root";
$pass="toor";
$db="gestor_edv_ori";
$link = mysql_connect($host,$user,$pass) or die ("Error durante la conexion a la base de datos"); 
mysql_select_db($db,$link);
?>
