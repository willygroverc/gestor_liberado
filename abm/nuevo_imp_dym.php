<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
	$NomCordCamb=_clean($NomCordCamb);
	$NomUsConf=_clean($NomUsConf);
	$fecha_cam=_clean($fecha_cam);
	$fecha_solic=_clean($fecha_solic);
	$var1=_clean($var1);
	$ResuCordConf=_clean($ResuCordConf);
	$ResuUsConf=_clean($ResuUsConf);
	$observ1=_clean($observ1);
	$observ2=_clean($observ2);
	
	$NomCordCamb=SanitizeString($NomCordCamb);
	$NomUsConf=SanitizeString($NomUsConf);
	$fecha_cam=SanitizeString($fecha_cam);
	$fecha_solic=SanitizeString($fecha_solic);
	$var1=SanitizeString($var1);
	$ResuCordConf=SanitizeString($ResuCordConf);
	$ResuUsConf=SanitizeString($ResuUsConf);
	$observ1=SanitizeString($observ1);
	$observ2=SanitizeString($observ2);

	//ajax.send("RealizFicha="+RealizFicha.value+"marca="+marca.value+"&AdicUSI1="+AdicUSI1.value+"&Modelo1="+Modelo.value+"&CodActFijo1="+CodActFijo1.value+"&NumSerie1="+NumSerie.value+"&FechAlta="+FechAlta.value+"&GarantDe="+GarantDe.value+"&GarantAl="+GarantAl.value);
	$sql_sol = "SELECT id_orden FROM solucion WHERE id_orden='$var1'";
    $result_sol=mysql_query($sql_sol);
    $fila_sol=mysql_fetch_array($result_sol);
	if(!empty($fila_sol['id_orden']))	{
		$sql = "INSERT INTO implantus (NomCordCamb,FechCordConf,ResuCordConf,NomUsConf,FechUsConf,ResuUsConf,OrdAyuda,observ1,observ2) ".
		"VALUES ('$NomCordCamb','$fecha_cam','$ResuCordConf','$NomUsConf','$fecha_solic','$ResuUsConf','$var1','$observ1','$observ2')";
		if (mysql_query($sql))
		{		echo 0; }
			else 
			{	echo -1; }
	} else	
	{	echo -2;	}

?>