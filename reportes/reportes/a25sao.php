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

//Criticidad, criticidad, prioridad
$rs=mysql_db_query($db,$sql,$link);
	$nivel["criticidad"][1]=0;
	$nivel["criticidad"][2]=0;
	$nivel["criticidad"][3]=0;
for ($i=0; $i<$numAsig; $i++) 
{
	$sql="SELECT nivel_asig, criticidad_asig, prioridad_asig FROM asignacion WHERE id_orden='$total[$i]' ORDER BY id_asig DESC limit 1";
	$tmpNivel = mysql_fetch_array(mysql_db_query($db,$sql,$link));
	$nivel["criticidad"][$tmpNivel["criticidad_asig"]]++;
}
if ($nivel["total"]>0) {
	$nivel["criticidad"][4]=round($nivel["criticidad"][1]*100/$nivel["total"]);
	$nivel["criticidad"][5]=round($nivel["criticidad"][2]*100/$nivel["total"]);
	$nivel["criticidad"][6]=round($nivel["criticidad"][3]*100/$nivel["total"]);
}
else {
	$nivel["criticidad"][4]=0;
	$nivel["criticidad"][5]=0;
	$nivel["criticidad"][6]=0;
	}

//ENVIO DE DATOS
		
	$dat1 = $nivel[criticidad][1];
	$dat2 = $nivel[criticidad][2];
	$dat3 = $nivel[criticidad][3];
//hasta aqui
/*$data.="<set label='Criticidad Alta' value='$dat1'/><set label='Criticidad Media' value='$dat2'/><set label='Criticidad Baja' value='$dat3'/>";
$data.="</chart>";*/
$prom=$dat1;
?>