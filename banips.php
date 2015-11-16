<?php
include("conexion.php");//Incluimos nuestro archivo para conectar con la base de datos.
$ipaban = getenv("REMOTE_ADDR");
print $ipaban;
$sql="INSERT INTO banip (ip) VALUES ('$ipaban')";
mysql_db_query($db,$sql,$link);
?>