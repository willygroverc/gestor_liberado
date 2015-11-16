<?php
include ("conexion.php");
session_start();
$login = $_SESSION["login"];
$sql02="SELECT * FROM users WHERE login_usr='$login'";
$result02=mysql_db_query($db,$sql02,$link);
$row02=mysql_fetch_array($result02);
$nombre_usr=$row02[nom_usr]." ".$row02[apa_usr]." ".$row02[ama_usr];
$path_replica=$_SESSION["path_replica"];
$fecha_hoy=date("Y-m-d");
$hora_hoy=date("H:i:s");
$sql2="SELECT MAX(id_arch) as id_arch FROM datos_archivos,modulo WHERE datos_archivos.id_arch='$id' AND datos_archivos.id_mod=modulo.id_mod";
$res2=mysql_db_query($db,$sql2,$link);
$row2=mysql_fetch_array($res2);
$sql="SELECT * FROM datos_archivos,modulo WHERE id_arch='$row2[id_arch]' AND datos_archivos.id_mod=modulo.id_mod";
$res=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($res);

$enlace = $path_replica."/".$row[nombre_mod]."/".$row[nombre_arch]; 
header ("Content-Disposition: attachment; filename=".$row[nombre_arch]."\n\n"); 
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);
$sql01 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch)".
         "VALUES ('$fecha_hoy','$hora_hoy','descargado_replica','$nombre_usr','$row[nombre_mod]','$row[nombre_arch]')";
$rst01 = mysql_db_query($db,$sql01,$link);
?>
