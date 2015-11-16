<?php
//$data="<chart caption='ORDENES DE TRABAJO' shownames='1' showvalues='1' decimals='0' numberPrefix='Dias '>";
////desde aqui

//NUMERO TOTAL DE ORDENES
include('../../conexion.php');
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
//		$row6[cost]=$numCost;

//Complejidad, criticidad, prioridad
$rs=mysql_db_query($db,$sql,$link);
$nivel[complejidad][1]=0;
$nivel[complejidad][2]=0;
$nivel[complejidad][3]=0;
for ($i=0; $i<$numAsig; $i++) 
{
	$sql="SELECT nivel_asig, criticidad_asig, prioridad_asig FROM asignacion WHERE id_orden='$total[$i]' ORDER BY id_asig DESC limit 1";
	$tmpNivel = mysql_fetch_array(mysql_db_query($db,$sql,$link));
	$nivel[complejidad][$tmpNivel[nivel_asig]]++;
}
$nivel[total]=$nivel[complejidad][1]+$nivel[complejidad][2]+$nivel[complejidad][3];
if ($nivel[total]>0) {
	$nivel[complejidad][4]=round($nivel[complejidad][1]*100/$nivel[total]);
	$nivel[complejidad][5]=round($nivel[complejidad][2]*100/$nivel[total]);
	$nivel[complejidad][6]=round($nivel[complejidad][3]*100/$nivel[total]);
}
else {
	$nivel[complejidad][4]=0;
	$nivel[complejidad][5]=0;
	$nivel[complejidad][6]=0;
	}

//ENVIO DE DATOS
		
$dat1 = $nivel[complejidad][3];
$dat2 = $nivel[complejidad][2];
$dat3 = $nivel[complejidad][1];
//hasta aqui
/*$data.="<set label='Complejidad Alta' value='$dat1'/><set label='Complejidad Media' value='$dat2'/><set label='Complejidad Baja' value='$dat3'/>";
$data.="</chart>";*/
$prom=$dat1;
echo $prom;
?>