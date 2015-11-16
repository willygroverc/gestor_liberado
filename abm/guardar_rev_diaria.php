<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
	
	$descripcion=SanitizeString($descripcion);
	$fecha_inicio=SanitizeString($fecha_inicio);
	$hora_inicio=SanitizeString($hora_inicio);
	$fecha_final=SanitizeString($fecha_final);
	$hora_final=SanitizeString($hora_final);
	$elegido=SanitizeString($elegido);
	$observ=SanitizeString($observ);
	$id_orden=SanitizeString($id_orden);
	
	$descripcion=normaliza($descripcion);
	$fecha_inicio=normaliza($fecha_inicio);
	$hora_inicio=normaliza($hora_inicio);
	$fecha_final=normaliza($fecha_final);
	$hora_final=normaliza($hora_final);
	$elegido=normaliza($elegido);
	$observ=normaliza($observ);
	$id_orden=normaliza($id_orden);
	$sql2 = "SELECT MAX(numero) AS num FROM detaller WHERE id_orden='$id_orden'";
  	$result2=mysql_query($sql2);
  	$row2=mysql_fetch_array($result2);
	$numer=$row2['num']+1;
	$sql="INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ,Fecha_ini,Hora_ini,Fecha_fin,Hora_fin,Fecha_reg,Hora_reg) ".
		   "VALUES ('$id_orden','$numer','$descripcion','$elegido','$observ','$fecha_inicio','$hora_inicio','$fecha_final','$hora_final','".date("Y-m-d")."','".date("H:i:s")."')";
	if (mysql_query($sql))
			echo 0; // Insercion correcta
		else
			echo -1;

?>