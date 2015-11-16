<?php
//$data="<chart caption='ORDENES DE TRABAJO' shownames='1' showvalues='1' decimals='0' numberPrefix='Dias '>";
////desde aqui

//NUMERO TOTAL DE ORDENES

	$sql = "SELECT COUNT(id_orden) AS numtot FROM ordenes WHERE cod_usr<>'SISTEMA'";
	$row = mysql_fetch_array(mysql_db_query($db,$sql,$link));
//==========ORDENES DE TRABAJO==========================-
	
		$sql9 = "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA'";
		$rs19 = mysql_db_query($db,$sql9,$link);
		$numAsig = 0;
		while ($tmp = mysql_fetch_array($rs19))  {			
				$total[$numAsig] = $tmp[id_orden];
				$numAsig++;
		}

//NUMERO DE ORDENES CON SOLUCION  
	$solu=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql4 = "SELECT id_orden FROM solucion WHERE id_orden='$total[$i]'";  //=============HERE VIC
		$row4 = mysql_fetch_array(mysql_db_query($db,$sql4,$link));
		if ($row4[id_orden]==$total[$i]) {
		$solu++;}
	}
	$row4[solu]=$solu;
//NUMERO DE ORDNES CON CONFORMIDAD DEL CLIENTE 
	$numConf=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
		$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
		if ($rsTmp3[id_orden]==$total[$i]){
		$numConf++;}
	}
	$row5[conf]=$numConf;
		
//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
	$noconf=$row4[solu]-$row5[conf];
//ENVIO DE DATOS
	$dat1 = $row5[conf];
	$dat2 = $noconf;
//hasta aqui
//$data.="<set label='Con Conformidad' value='$dat1'/><set label='Sin Conformidad' value='$dat2'/>";
//$data.="</chart>";
$prom=$dat2;
?>