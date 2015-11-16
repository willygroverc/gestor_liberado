<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
	$fecplanif=_clean($fecplanif);
	$fecelab=_clean($fecelab);
	$objprue=_clean($objprue);
	$tipcontin=_clean($tipcontin);
	$condicion=_clean($condicion);
	$fecrelac=_clean($fecrelac);
	$varios=_clean($varios);
	$rechard=_clean($rechard);
	$recsoft=_clean($recsoft);
	$recresp=_clean($recresp);
	$facilidad=_clean($facilidad);
	$costo=_clean($costo);
	$moneda=_clean($moneda);
	$jefeus=_clean($jefeus);
	$var1=_clean($var1);
	$var2=_clean($var2);
	
	$fecplanif=SanitizeString($fecplanif);
	$fecelab=SanitizeString($fecelab);
	$objprue=SanitizeString($objprue);
	$tipcontin=SanitizeString($tipcontin);
	$condicion=SanitizeString($condicion);
	$fecrelac=SanitizeString($fecrelac);
	$varios=SanitizeString($varios);
	$rechard=SanitizeString($rechard);
	$recsoft=SanitizeString($recsoft);
	$recresp=SanitizeString($recresp);
	$facilidad=SanitizeString($facilidad);
	$costo=SanitizeString($costo);
	$moneda=SanitizeString($moneda);
	$jefeus=SanitizeString($jefeus);
	$var1=SanitizeString($var1);
	$var2=SanitizeString($var2);
	
	$fecplanif=normaliza($fecplanif);
	$fecelab=normaliza($fecelab);
	$objprue=normaliza($objprue);
	$tipcontin=normaliza($tipcontin);
	$condicion=normaliza($condicion);
	$fecrelac=normaliza($fecrelac);
	$varios=normaliza($varios);
	$rechard=normaliza($rechard);
	$recsoft=normaliza($recsoft);
	$recresp=normaliza($recresp);
	$facilidad=normaliza($facilidad);
	$costo=normaliza($costo);
	$moneda=normaliza($moneda);
	$jefeus=normaliza($jefeus);
	$var1=normaliza($var1);
	$var2=normaliza($var2);
	$sql="INSERT INTO planprueba (fecplanif,fecelab,objprue,tipcontin,condicion,fecrelac,varios,rechard,recsoft,recresp,facilidad,costo,moneda,jefeus,jefeapc,ordayuda)".
	"VALUES ('$fecplanif','$fecelab','$objprue','$tipcontin','$condicion','$fecrelac','$varios','$rechard','$recsoft','$recresp','$facilidad','$costo','$moneda','$jefeus','-','$var1')";
	if (mysql_query($sql))
			echo 0; // Insercion correcta
		else
			echo -1;

?>