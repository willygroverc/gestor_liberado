<?php

//$data="<chart caption='ORDENES DE TRABAJO' shownames='1' showvalues='1' decimals='1'>";
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

//prioridad, prioridad, prioridad
$rs=mysql_db_query($db,$sql,$link);
	$nivel["prioridad"][1]=0;
	$nivel["prioridad"][2]=0;
	$nivel["prioridad"][3]=0;
for ($i=0; $i<$numAsig; $i++) 
{
	$sql="SELECT nivel_asig, prioridad_asig, prioridad_asig FROM asignacion WHERE id_orden='$total[$i]' ORDER BY id_asig DESC limit 1";
	$tmpNivel = mysql_fetch_array(mysql_db_query($db,$sql,$link));
	$nivel["prioridad"][$tmpNivel["prioridad_asig"]]++;
}
if ($nivel["total"]>0) {
	$nivel["prioridad"][4]=round($nivel["prioridad"][1]*100/$nivel["total"]);
	$nivel["prioridad"][5]=round($nivel["prioridad"][2]*100/$nivel["total"]);
	$nivel["prioridad"][6]=round($nivel["prioridad"][3]*100/$nivel["total"]);
}
else {
	$nivel["prioridad"][4]=0;
	$nivel["prioridad"][5]=0;
	$nivel["prioridad"][6]=0;
	}

//ENVIO DE DATOS
		
	$dat1 = $nivel[prioridad][1];
	$dat2 = $nivel[prioridad][2];
	$dat3 = $nivel[prioridad][3];
//hasta aqui
/*$data.="<set label='Prioridad Alta' value='$dat1'/><set label='Prioridad Media' value='$dat2'/><set label='Prioridad Baja' value='$dat3'/>";
$data.="</chart>";*/
$prom=$dat1;
?>