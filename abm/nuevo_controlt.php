<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
	$temperatura=_clean($temperatura);
	$fecha_ctrl=_clean($fecha_ctrl);
	$hr=_clean($hr);
	$nombresp=_clean($nombresp);
	$observ=_clean($observ);
	$a2=_clean($a2);
	$var1=_clean($var1);
	$a=_clean($a);
	
	$temperatura=SanitizeString($temperatura);
	$fecha_ctrl=SanitizeString($fecha_ctrl);
	$hr=SanitizeString($hr);
	$nombresp=SanitizeString($nombresp);
	$observ=SanitizeString($observ);
	$a2=SanitizeString($a2);
	$var1=SanitizeString($var1);
	$a=SanitizeString($a);
	
	$temperatura=normaliza($temperatura);
	$fecha_ctrl=normaliza($fecha_ctrl);
	$hr=normaliza($hr);
	$nombresp=normaliza($nombresp);
	$observ=normaliza($observ);
	$a2=normaliza($a2);
	$var1=normaliza($var1);
	$a=normaliza($a);
	$hora=$a;
	$sql="UPDATE controltemp SET numero='$a2',hora='$hora',fecha='$fecha_ctrl',temperatura='$temperatura',hr='$hr',nombresp='$nombresp',observ='$observ'".
	"WHERE numero='$var1'";
	if (mysql_query($sql))
			echo 0; // Insercion correcta
		else
			echo $sql;

?>