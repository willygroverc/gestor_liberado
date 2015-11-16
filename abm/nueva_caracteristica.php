<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
	$Capacid=_clean($_POST['Capacid']);
	$Veloc=_clean($_POST['Veloc']);
	$Marca=_clean($_POST['Marca']);
	$ModSerie=_clean($_POST['ModSerie']);
	$Adicio=_clean($_POST['Adicio']);
	$variable2=_clean($_POST['variable2']);
	
	$Capacid=SanitizeString($Capacid);
	$Veloc=SanitizeString($Veloc);
	$Marca=SanitizeString($Marca);
	$ModSerie=SanitizeString($ModSerie);
	$Adicio=SanitizeString($Adicio);
	$variable2=SanitizeString($variable2);
	
	$Capacid=normaliza($Capacid);
	$Veloc=normaliza($Veloc);
	$Marca=normaliza($Marca);
	$ModSerie=normaliza($ModSerie);
	$Adicio=normaliza($Adicio);
	$variable2=normaliza($variable2);

	//ajax.send("RealizFicha="+RealizFicha.value+"marca="+marca.value+"&AdicUSI1="+AdicUSI1.value+"&Modelo1="+Modelo.value+"&CodActFijo1="+CodActFijo1.value+"&NumSerie1="+NumSerie.value+"&FechAlta="+FechAlta.value+"&GarantDe="+GarantDe.value+"&GarantAl="+GarantAl.value);
	$sql_max = "SELECT MAX(IdFicha) AS num FROM datfichatec";
	$result_m=mysql_query($sql_max);
	$row_m=mysql_fetch_array($result_m);
	$sql="INSERT INTO ".
	"caracfichtec (IdFicha,Accesorio,Capacid,Veloc,Marca,ModSerie,Adicio,fecha,idTabla_2) ".
	"VALUES ('$row_m[num]','otros','$Capacid','$Veloc','$Marca','$ModSerie','$Adicio','".date('Y-m-d')."','0')";
	if (mysql_query($sql))
			echo 0; 
		else
			echo -1;

?>