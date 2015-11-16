<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
	$NombRespAp=_clean($NombRespAp);
	$NomUsRespAp=_clean($NomUsRespAp);
	$ComCambAp=_clean($ComCambAp);
	$observ1=_clean($observ1);
	$observ2=_clean($observ2);
	$observ3=_clean($observ3);
	$fecha_imp=_clean($fecha_imp);
	$fecha_resp=_clean($fecha_resp);
	$fecha_cab=_clean($fecha_cab);
	
	$NombRespAp=SanitizeString($NombRespAp);
	$NomUsRespAp=SanitizeString($NomUsRespAp);
	$ComCambAp=SanitizeString($ComCambAp);
	$observ1=SanitizeString($observ1);
	$observ2=SanitizeString($observ2);
	$observ3=SanitizeString($observ3);
	$fecha_imp=SanitizeString($fecha_imp);
	$fecha_resp=SanitizeString($fecha_resp);
	$fecha_cab=SanitizeString($fecha_cab);
	
	$NombRespAp=normaliza($NombRespAp);
	$NomUsRespAp=normaliza($NomUsRespAp);
	$ComCambAp=normaliza($ComCambAp);
	$observ1=normaliza($observ1);
	$observ2=normaliza($observ2);
	$observ3=normaliza($observ3);
	$fecha_imp=normaliza($fecha_imp);
	$fecha_resp=normaliza($fecha_resp);
	$fecha_cab=normaliza($fecha_cab);

	//ajax.send("RealizFicha="+RealizFicha.value+"marca="+marca.value+"&AdicUSI1="+AdicUSI1.value+"&Modelo1="+Modelo.value+"&CodActFijo1="+CodActFijo1.value+"&NumSerie1="+NumSerie.value+"&FechAlta="+FechAlta.value+"&GarantDe="+GarantDe.value+"&GarantAl="+GarantAl.value);
	$sql = "INSERT INTO aprobus (NombRespAp,FechRespAp,NomUsRespAp,FechUsRespAp,ComCambAp,FechComAp,OrdAyuda,estado,observ1,observ2,observ3) ".
  "VALUES ('$NombRespAp','$fecha_imp','$NomUsRespAp','$fecha_resp','$ComCambAp','$fecha_cab','$var1','0','$observ1','$observ2','$observ3')";

	if (mysql_query($sql))
			echo 0; 
		else
			echo -1;

?>