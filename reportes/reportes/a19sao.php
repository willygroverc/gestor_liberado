<?php
//$data="<chart caption='ORDENES DE TRABAJO' shownames='1' showvalues='1' decimals='0' numberPrefix='Dias '>";
////desde aqui
//==========ORDENES DE TRABAJO==========================-
	
$sql9 = "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA'";
$rs19 = mysql_db_query($db,$sql9,$link);
$numAsig = 0;
while ($tmp = mysql_fetch_array($rs19))  {			
	$total[$numAsig] = $tmp[id_orden];
	$numAsig++;
}

//NUMERO TOTAL DE ORDENES

	$sql = "SELECT COUNT(id_orden) AS numtot FROM ordenes WHERE cod_usr<>'SISTEMA'";
	$row = mysql_fetch_array(mysql_db_query($db,$sql,$link));
//NUMERO DE ORDENES ASIGNADAS  

	$sql1 = "SELECT DISTINCT(asignacion.id_orden), MAX(asignacion.id_asig) FROM ordenes, asignacion 
	WHERE ordenes.id_orden=asignacion.id_orden AND ordenes.cod_usr<>'SISTEMA' GROUP BY asignacion.id_orden";
	$row1[asig] = mysql_num_rows(mysql_db_query($db,$sql1,$link));

//NUMERO DE ORDENES CON SOLUCION  
	$solu=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql4 = "SELECT id_orden FROM solucion WHERE id_orden='$total[$i]'";  //=============HERE VIC
		$row4 = mysql_fetch_array(mysql_db_query($db,$sql4,$link));
		if ($row4[id_orden]==$total[$i]) {
		$solu++;}
	}
	$row4[solu]=$solu;		
	
//NUMERO DE ORDENES SIN SOLUCION
	$nosolu=$row1[asig]-$row4[solu];
//ENVIO DE DATOS
	$dat1=$row4[solu];
	$dat2=$nosolu;
//hasta aqui
/*$data.="<set label='Con Solucion' value='$dat1'/><set label='Sin Solucion' value='$dat2'/>";
$data.="</chart>";*/
$prom=$dat2;
?>