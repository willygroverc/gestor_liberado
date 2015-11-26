<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
if(isset($_REQUEST['codigo'])) $codigo=$_REQUEST['codigo']; else $codigo="";
if(isset($_REQUEST['fecha_ctrl'])) $fecha_ctrl=$_REQUEST['fecha_ctrl']; else $fecha_ctrl="";
if(isset($_REQUEST['contenido'])) $contenido=$_REQUEST['contenido']; else $contenido="";
if(isset($_REQUEST['observ'])) $observ=$_REQUEST['observ']; else $observ="";
if(isset($_REQUEST['Sistema'])) $Sistema=$_REQUEST['Sistema']; else $Sistema="";
if(isset($_REQUEST['Negocio'])) $Negocio=$_REQUEST['Negocio']; else $Negocio="";
if(isset($_REQUEST['SE1'])) $SE1=$_REQUEST['SE1']; else $SE1="";
if(isset($_REQUEST['SE2'])) $SE2=$_REQUEST['SE2']; else $SE2="";
if(isset($_REQUEST['var1'])) $var1=$_REQUEST['var1']; else $var1="";

	$codigo=_clean($codigo);
	$fecha_ctrl=_clean($fecha_ctrl);
	$contenido=_clean($contenido);
	$observ=_clean($observ);
	
	$codigo=SanitizeString($codigo);
	$fecha_ctrl=SanitizeString($fecha_ctrl);
	$contenido=SanitizeString($contenido);
	$observ=SanitizeString($observ);
	
	$codigo=normaliza($codigo);
	$fecha_ctrl=normaliza($fecha_ctrl);
	$contenido=normaliza($contenido);
	$observ=normaliza($observ);
	$sql="UPDATE ubicacionresp SET codigo='$codigo',fecha='$fecha_ctrl',contenido='$contenido',ubi_sistema='$Sistema',ubi_negocio='$Negocio',ubi_SE1='$SE1',ubi_SE2='$SE2'".
		" ,observ='$observ' WHERE codub='$var1'";
	if (mysql_query($sql))
			echo 0; // Insercion correcta
		else
			echo $sql;

?>