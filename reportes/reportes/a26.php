<?php
if(isset($DA) && isset($MA)){
if (strlen($DA) == 1){ $DA = "0".$DA; }
if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
	$fecha1 = $AA."-".$MA."-".$DA;   
if (strlen($DE) == 1){ $DE = "0".$DE; }
if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fecha2 = $AE."-".$ME."-".$DE; 
}
error_reporting(0);
if(isset($fecha1) && isset($fecha2)) $sql_alt=" AND fecha BETWEEN '$fecha1' AND '$fecha2'";
else $sql_alt="";

$data="<chart caption='ORDENES DE TRABAJO' shownames='1' showvalues='1' decimals='1'>";
////desde aqui

//NUMERO TOTAL DE ORDENES

	$sql = "SELECT COUNT(id_orden) AS numtot FROM ordenes WHERE cod_usr<>'SISTEMA' $sql_alt";
	$row = mysql_fetch_array(mysql_db_query($db,$sql,$link));
//==========ORDENES DE TRABAJO==========================-
	
		$sql9 = "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' $sql_alt";
		$rs19 = mysql_db_query($db,$sql9,$link);
		$numAsig = 0;
		while ($tmp = mysql_fetch_array($rs19))  {			
				$total[$numAsig] = $tmp['id_orden'];
				$numAsig++;
		}
//NUMERO DE ORDENES CON COSTO
		$numCost=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql = "SELECT DISTINCT(id_orden) FROM costo WHERE id_orden='$total[$i]'";
			$rsTmp4=mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp4['id_orden']==$total[$i]){
			$numCost++;}
		}
		$row6['cost']=$numCost;

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
if (isset($nivel["total"]) && $nivel["total"]>0) {
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
		
	$dat1 = $nivel['prioridad'][1];
	$dat2 = $nivel['prioridad'][2];
	$dat3 = $nivel['prioridad'][3];
///hasta aqui
$data.="<set label='Prioridad Alta' value='$dat1'/><set label='Prioridad Media' value='$dat2'/><set label='Prioridad Baja' value='$dat3'/>";
$data.="</chart>";
$prom=$dat1;
?>
<head>
   <script language="JavaScript" src="Charts/FusionCharts.js"></script>
</head>
<body bgcolor="#ffffff">
   <div id="chartdiv" align="center">The chart will appear within this DIV. This text will be replaced by the chart.</div>
   <script type="text/javascript">
      var myChart = new FusionCharts("Charts/Pie3D.swf", "myChartId", "600", "300", "0", "0");
      myChart.setDataXML("<?php echo $data;?>");
      myChart.render("chartdiv");
   </script>
</body>
