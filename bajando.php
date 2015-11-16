<?php
	session_start();
	include ("conexion.php");
	//include ("funciones.inc.php");
	$sql02="SELECT * FROM users WHERE login_usr='$login'";
	$result02=mysql_db_query($db,$sql02,$link);
	$row02=mysql_fetch_array($result02);
	$nombre_usr=$row02[nom_usr]." ".$row02[apa_usr]." ".$row02[ama_usr];
	$path  = $_SESSION["path"];
	//$id_mod = XCampoc($id_arch,"datos_archivos","id_arch","id_mod",$link);	
	$sql = "SELECT id_mod FROM datos_archivos WHERE id_arch='$id_arch'";
	$res = mysql_db_query($db,$sql,$link);
	$row = mysql_fetch_array($res);
	$id_mod = $row[id_mod];
	//$nom_mod = XCampoc($id_mod,"modulo","id_mod","nombre_mod",$link);
	$sql = "SELECT id_mod, nombre_mod FROM modulo WHERE id_mod='$id_mod'";
	$res = mysql_db_query($db,$sql,$link);
	$row = mysql_fetch_array($res);
	$nom_mod = $row[nombre_mod];			
	$path_a_tu_doc = $path."/".$nom_mod;
	$enlace = $path_a_tu_doc."/".$arch; 	
	$fecha_hoy=date("Y-m-d");
	$hora_hoy=date("H:i:s");
	header ("Content-Disposition: attachment; filename=".$arch."\n\n"); 
	header ("Content-Type: application/octet-stream");
	header ("Content-Length: ".filesize($enlace));
	readfile($enlace);
	$sql01 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch)".
   	         "VALUES ('$fecha_hoy','$hora_hoy','descargado_ctrabajo','$nombre_usr','$nom_mod','$arch')";
	$rst01 = mysql_db_query($db,$sql01,$link);
?>
	