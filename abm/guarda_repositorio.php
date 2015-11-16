<?php 
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
	
	$observaciones=SanitizeString($observaciones);
	$nomb_rrevision=SanitizeString($nomb_rrevision);
	$nomb_rauditoria=SanitizeString($nomb_rauditoria);
	$fecha_rr=SanitizeString($fecha_rr);
	$fecha_ra=SanitizeString($fecha_ra);
	$id_orden=SanitizeString($id_orden);
	
	$observaciones=normaliza($observaciones);
	$nomb_rrevision=normaliza($nomb_rrevision);
	$nomb_rauditoria=normaliza($nomb_rauditoria);
	$fecha_rr=normaliza($fecha_rr);
	$fecha_ra=normaliza($fecha_ra);
	$id_orden=normaliza($id_orden);
	$sql="INSERT INTO revision (id_orden,observaciones,nomb_rrevision,nomb_rauditoria,fecha_rr,fecha_ra) VALUES ('$id_orden','$observaciones','$nomb_rrevision','$nomb_rauditoria','$fecha_rr','$fecha_ra')";
	if (mysql_query($sql))
			echo 0; // Insercion correcta
		else
			echo -1;

?>