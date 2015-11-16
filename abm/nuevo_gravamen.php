<?php
@session_start();
require ('../conexion.php');
require_once('../funciones.php');
	$observaciones1=_clean($_POST['observaciones']);
	$id_acciones1=_clean($_POST['id_acciones']);
	$radio=_clean($_POST['radio']);
	
	$observaciones=SanitizeString($observaciones1);
	$id_acciones=SanitizeString($id_acciones1);
	$sql="INSERT INTO gravamenes(`id_acciones`, `login`, `fecha`, grav,`observaciones`) VALUES ('$id_acciones', '$login','".date("Y-m-d")." ".date("H:i:s")."','$radio','$observaciones')";
	if (mysql_query($sql))
	{
		if($radio==1)
		{	$sql_ac="UPDATE acciones SET estado='1' WHERE id_acciones='$id_acciones'";	}
		else
		{	$sql_ac="UPDATE acciones SET estado='2' WHERE id_acciones='$id_acciones'";	}
			if(mysql_query($sql_ac))
			{	echo 0; 	}
	}
	else
		echo $sql;

?>