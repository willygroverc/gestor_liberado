<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
	$codigo=_clean($codigo);
	$fecha_ctrl=_clean($fecha_ctrl);
	$contenido=_clean($contenido);
	$observ=_clean($observ);
	
	$codigo=SanitizeString($codigo);
	$fecha_ctrl=SanitizeString($fecha_ctrl);
	$contenido=SanitizeString($contenido);
	$observ=SanitizeString($observ);
	
	$codigo=normaliza($codigo);
	$fecha_ctrl=normaliza($fecha_ctrl);
	$contenido=normaliza($contenido);
	$observ=normaliza($observ);
	$sql="UPDATE ubicacionresp SET codigo='$codigo',fecha='$fecha_ctrl',contenido='$contenido',ubi_sistema='$Sistema',ubi_negocio='$Negocio',ubi_SE1='$SE1',ubi_SE2='$SE2'".
		" ,observ='$observ' WHERE codub='$var1'";
	if (mysql_query($sql))
			echo 0; // Insercion correcta
		else
			echo $sql;

?>