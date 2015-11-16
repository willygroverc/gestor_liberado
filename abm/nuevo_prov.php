<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
	$NombProv1=_clean($_POST['NombProv']);
	$DirecProv1=_clean($_POST['DirecProv']);
	$Fono1Prov1=_clean($_POST['Fono1Prov']);
	$Fono2Prov1=_clean($_POST['Fono2Prov']);
	$EmailProv1=_clean($_POST['EmailProv']);
	$EncProv1=_clean($_POST['EncProv']);
	$ObsProv1=_clean($_POST['ObsProv']);
	$nivelRiesgo=_clean($_POST['nivelRiesgo']);
	$descRiesgo=_clean($_POST['descRiesgo']);
	$nivelCalidad=_clean($_POST['nivelCalidad']);
	$descCalidad=_clean($_POST['descCalidad']);
	$servicio1=_clean($_POST['servicio1']);
	$servicio2=_clean($_POST['servicio2']);
	
	
	$NombProv=SanitizeString($NombProv1);
	$DirecProv=SanitizeString($DirecProv1);
	$Fono1Prov=SanitizeString($Fono1Prov1);
	$Fono2Prov=SanitizeString($Fono2Prov1);
	$EmailProv=SanitizeString($EmailProv1);
	$EncProv=SanitizeString($EncProv1);
	$ObsProv=SanitizeString($ObsProv1);
	$nivelRiesgo=SanitizeString($nivelRiesgo);
	$descRiesgo=SanitizeString($descRiesgo);
	$nivelCalidad=SanitizeString($nivelCalidad);
	$descCalidad=SanitizeString($descCalidad);
	$servicio1=SanitizeString($servicio1);
	$servicio2=SanitizeString($servicio2);
	
	
	$NombProv=normaliza($NombProv1);
	$DirecProv=normaliza($DirecProv1);
	$Fono1Prov=normaliza($Fono1Prov1);
	$Fono2Prov=normaliza($Fono2Prov1);
	$EmailProv=normaliza($EmailProv1);
	$EncProv=normaliza($EncProv1);
	$ObsProv=normaliza($ObsProv1);
	$nivelRiesgo=normaliza($nivelRiesgo);
	$descRiesgo=normaliza($descRiesgo);
	$nivelCalidad=normaliza($nivelCalidad);
	$descCalidad=normaliza($descCalidad);
	$sql = "INSERT INTO proveedor (NombProv,DirecProv,Fono1Prov,Fono2Prov,EmailProv,EncProv,ObsProv,nivelRiesgo,descRiesgo,nivelCalidad,descCalidad,nivel1,nivel2) VALUES ('$NombProv','$DirecProv','$Fono1Prov','$Fono2Prov','$EmailProv','$EncProv','$ObsProv','$nivelRiesgo','$descRiesgo','$nivelCalidad','$descCalidad','$servicio1','$servicio2')";
  //$result=mysql_query($sql);
	if (mysql_query($sql))
			echo 0; // Insercion correcta
		else
			echo -1;

?>