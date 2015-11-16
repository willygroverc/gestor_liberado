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

//NUMERO DE ORDENES CON SEGUIMIENTO ++++++++++++++++++++++++   fecha_se////===============SEGUI
		$seg=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql="SELECT * FROM seguimiento WHERE id_orden='$total[$i]' ORDER BY id_seg DESC";
			$rsTmp0 = mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp0[id_orden]==$total[$i]) {
			$seg++;}
		}
		$row3[seg]=$seg;	

//MUMERO DE ORDENES SIN SEGUIMIENTO ++++++++++++++++++++++++
	$noseg=$row[numtot]-$row3[seg];
//ENVIO DE DATOS
	$dat1=$row3[seg];
	$dat2=$noseg;
//hasta aqui
//$data.="<set label='Con Seguimiento' value='$dat1'/><set label='Sin Seguimiento' value='$dat2'/>";
$prom=$dat2;
//$data.="</chart>";
?>