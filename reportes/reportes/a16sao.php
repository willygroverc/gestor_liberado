<?php
//$data="<chart caption='ORDENES DE TRABAJO' shownames='1' showvalues='1' decimals='0' numberPrefix='Dias '>";
////desde aqui
//NUMERO TOTAL DE ORDENES

	$sql = "SELECT COUNT(id_orden) AS numtot FROM ordenes WHERE cod_usr<>'SISTEMA'";
	$row = mysql_fetch_array(mysql_db_query($db,$sql,$link));

//NUMERO DE ORDENES ASIGNADAS  

	$sql1 = "SELECT DISTINCT(asignacion.id_orden), MAX(asignacion.id_asig) FROM ordenes, asignacion 
	WHERE ordenes.id_orden=asignacion.id_orden AND ordenes.cod_usr<>'SISTEMA' GROUP BY asignacion.id_orden";
	$row1[asig] = mysql_num_rows(mysql_db_query($db,$sql1,$link));
//NUMERO DE ORDENES NO ASIGNADAS
	$noasig=$row[numtot]-$row1[asig];
	$dat1=$row1[asig];
	$dat2=$noasig;
//hasta aqui
$prom=$dat2;
?>