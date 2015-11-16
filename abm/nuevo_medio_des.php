<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');

        $var1=$_POST['var1'];
	$fecha_ant=$_POST['fecha_ant'];
	
        
	$var1=_clean($var1);
	$fecha_ant=_clean($fecha_ant);

	$var1=SanitizeString($var1);
	$fecha_ant=SanitizeString($fecha_ant);
	
	$var1=normaliza($var1);
	$fecha_ant=normaliza($fecha_ant);
	
	
		$sql = "UPDATE controlinvent SET FechaDestruc='$fecha_ant' WHERE Codigo='$var1'";
		if (mysql_query($sql))
		{		echo 0; }
			else 
			{	echo -1; }
	

?>