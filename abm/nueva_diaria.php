<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
	$FechaProceso=$_POST['FechaProceso'];
	$Actividad=$_POST['Actividad'];
	$Observaciones=$_POST['Observaciones'];
	$HoraDe=$_POST['HoraDe'];
	$HoraA=$_POST['HoraA'];
	$lista=$_POST['lista'];
	
	$FechaProceso=SanitizeString($FechaProceso);
	$Actividad=SanitizeString($Actividad);
	$Observaciones=SanitizeString($Observaciones);
	$HoraDe=SanitizeString($HoraDe);
	$nro_coHoraArre=SanitizeString($HoraA);
	$lista=SanitizeString($lista);
	
	$FechaProceso=normaliza($FechaProceso);
	$Actividad=normaliza($Actividad);
	$Observaciones=normaliza($Observaciones);
	$HoraDe=normaliza($HoraDe);
	$nro_coHoraArre=normaliza($HoraA);
	$lista=normaliza($lista);
	$sql="INSERT INTO ".
		"progtareasdiaria (Actividad, HoraDe, HoraA, FechaDe, Observaciones,d_asig) ".
		"VALUES ('$Actividad','$HoraDe','$HoraA','$FechaProceso','$Observaciones','$lista')";
	if (mysql_query($sql))
			echo 0; // Insercion correcta
		else
			echo -1;

?>