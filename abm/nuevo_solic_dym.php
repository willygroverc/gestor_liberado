<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
	$var1=_clean($var1);
	$fecha_rec=_clean($fecha_rec);
	$horas=_clean($horas);
	$Viabilidad=_clean($Viabilidad);
	$Tiempo=_clean($Tiempo);
	$Tiempo1=_clean($Tiempo1);
	$Costo10=_clean($Costo10);
	$Costo11=_clean($Costo11);
	$Costo20=_clean($Costo20);
	$Costo21=_clean($Costo21);
	$Prioridad=_clean($Prioridad);
	$fecha_ent=_clean($fecha_ent);
	$Aceptac=_clean($Aceptac);
	$fecha_asig=_clean($fecha_asig);
	
	$var1=SanitizeString($var1);
	$fecha_rec=SanitizeString($fecha_rec);
	$horas=SanitizeString($horas);
	$Viabilidad=SanitizeString($Viabilidad);
	$Tiempo=SanitizeString($Tiempo);
	$Tiempo1=SanitizeString($Tiempo1);
	$Costo10=SanitizeString($Costo10);
	$Costo11=SanitizeString($Costo11);
	$Costo20=SanitizeString($Costo20);
	$Costo21=SanitizeString($Costo21);
	$Prioridad=SanitizeString($Prioridad);
	$fecha_ent=SanitizeString($fecha_ent);
	$Aceptac=SanitizeString($Aceptac);
	$fecha_asig=SanitizeString($fecha_asig);

	//ajax.send("RealizFicha="+RealizFicha.value+"marca="+marca.value+"&AdicUSI1="+AdicUSI1.value+"&Modelo1="+Modelo.value+"&CodActFijo1="+CodActFijo1.value+"&NumSerie1="+NumSerie.value+"&FechAlta="+FechAlta.value+"&GarantDe="+GarantDe.value+"&GarantAl="+GarantAl.value);
	$sql = "INSERT INTO solicitud (OrdAyuda,Fecha,Hora,AsignA,Viabilidad,Tiempo,Tiempo1,CostoI,MonedaI,CostoII,MonedaII,Prioridad,FechEstEnt,Aceptac,FechAcep) VALUES "."
	('$var1','$fecha_rec','$horas','$AsignA','$Viabilidad','$Tiempo','$Tiempo1','$Costo10','$Costo11','$Costo20','$Costo21','$Prioridad','$fecha_ent','$Aceptac','$fecha_asig')";
	if (mysql_query($sql))
			echo 0; 
		else
			echo $sql;

?>