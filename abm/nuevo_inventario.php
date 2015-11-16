<?php
@session_start();
require ("../conexion.php");
require_once('../funciones.php');
        $codigo_usu=$_POST['codigo_usu'];
	$tipo_medio=$_POST['tipo_medio'];
	$tipo_dato=$_POST['tipo_dato'];
	$nro_cds=$_POST['nro_cds'];
	$nro_corre=$_POST['nro_corre'];
	$Observ=$_POST['Observ'];
        $Codigo=$_POST['Codigo'];
                
	$codigo_usu=_clean($codigo_usu);
	$tipo_medio=_clean($tipo_medio);
	$tipo_dato=_clean($tipo_dato);
	$nro_cds=_clean($nro_cds);
	$nro_corre=_clean($nro_corre);
	$Observ=_clean($Observ);
	
	$codigo_usu=normaliza($codigo_usu);
	$tipo_medio=normaliza($tipo_medio);
	$tipo_dato=normaliza($tipo_dato);
	$nro_cds=normaliza($nro_cds);
	$nro_corre=normaliza($nro_corre);
	$Observ=normaliza($Observ);
	$sql="UPDATE controlinvent SET Observ='$Observ',codigo_usu='$codigo_usu',tipo_medio='$tipo_medio',tipo_dato='$tipo_dato',".
		  "nro_cds='$nro_cds',nro_corre='$nro_corre' WHERE Codigo='$Codigo'";
	if (mysql_query($sql))
			echo 0; // Insercion correcta
		else
			echo $sql;

?>