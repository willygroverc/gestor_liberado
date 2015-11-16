<?php
@session_start();
$login=$_SESSION["login"];
require ('../conexion.php');
require_once('../funciones.php');

	$serie_ac1=_clean($_POST['serie_ac']);
	$val_nom1=_clean($_POST['val_nom']);
	$fecha_acc1=_clean($_POST['fecha_acc']);
	$accion_tit1=_clean($_POST['accion_tit']);
	$valor1=_clean($_POST['valor']);
	
	$serie_ac=SanitizeString($serie_ac1);
	$val_nom=SanitizeString($val_nom1);
	$fecha_acc=SanitizeString($fecha_acc1);
	$accion_tit=SanitizeString($accion_tit1);
	$valor=SanitizeString($valor1);
	$num="23";
	//$sql="INSERT INTO acciones (serie_ac,valor_ac,fecas_ac,num_ac,id_acc,id_ac,class_ac) VALUES ('','$serie_ac','$val_nom','$fecha_acc','$accion_tit','$num','$valor')";
	$sql="INSERT INTO acciones (serie_ac,valor_ac,fecas_ac,num_ac,id_acc,id_ac,class_ac) VALUES ('12','12','2012-01-01','12','$num','1','100')";
	if (mysql_query($sql)) {
			$sql=str_replace("'","´",$sql);
			$sql_log="INSERT INTO accion_log (date_log, acc_log, usr_log, ip_log) VALUES ('".date("Y-m-d")." ".date("H:m:s")."', '$sql', '$login','".$_SERVER['REMOTE_ADDR']."')";
			if (mysql_query($sql_log))
				echo 0;
			else
				echo -1;
	}

?>