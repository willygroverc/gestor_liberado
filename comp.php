<?php
include("conexion.php"); 	
$sql="SELECT * FROM controlinvent WHERE codigo_usu='$codigo'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);
if($row){echo "existe";}
else{echo "nuevo";}
?>