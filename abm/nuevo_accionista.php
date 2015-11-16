<?php
@session_start();
require ('../conexion.php');
require_once('../funciones.php');

	$nom_acc1=_clean($_POST['nom_acc']);
	$fecha_acc1=_clean($_POST['fecha_acc']);
	$nac_acc1=_clean($_POST['nac_acc']);
	$dom_acc1=_clean($_POST['dom_acc']);
	$tel_acc1=_clean($_POST['tel_acc']);
	$estado11=_clean($_POST['estado1']);
	
	$nom_acc=SanitizeString($nom_acc1);
	$fecha_acc=SanitizeString($fecha_acc1);
	$nac_acc=SanitizeString($nac_acc1);
	$dom_acc=SanitizeString($dom_acc1);
	$tel_acc=SanitizeString($tel_acc1);
	$estado=SanitizeString($estado11);
		
	$sql_AC="INSERT INTO `accionistas`(`nom_acc`, `fecha_acc`, `nac_acc`, `dom_acc`, `tel_acc`, `fec_acc`, `estado`) VALUES ('$nom_acc', '$fecha_acc','$nac_acc','$dom_acc','$tel_acc','".date("Y-m-d")." ".date("H:i:s")."','$estado')";
	//$sql_AC="INSERT INTO `accionistas`(`id_acc`, `nom_acc`, `fecha_acc`, `nac_acc`, `dom_acc`, `tel_acc`, `fec_acc`, `estado`) VALUES ('','abc','2012-01-01','100','av.asas','12312323','2012-01-01','estado')";
	if (mysql_query($sql_AC))
			echo 0; 
		else
			echo -1;

?>