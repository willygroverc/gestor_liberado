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
//NUMERO DE ORDENES CON COSTO
		$numCost=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql = "SELECT DISTINCT(id_orden) FROM costo WHERE id_orden='$total[$i]'";
			$rsTmp4=mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp4[id_orden]==$total[$i]){
			$numCost++;}
		}
		$row6[cost]=$numCost;


//NUMERO DE ORDENES SIN COSTO
$nocost=$row[numtot]-$row6[cost];

//ENVIO DE DATOS
	$dat1 = $row6[cost];
	$dat2 = $nocost;
//hasta aqui
/*$data.="<set label='Con Costo' value='$dat1'/><set label='Sin Costo' value='$dat2'/>";
$data.="</chart>";*/
$prom=$dat2;
?>