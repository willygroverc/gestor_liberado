<?php
if(isset($DA) && isset($MA)){
if (strlen($DA) == 1){ $DA = "0".$DA; }
if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
	$fecha1 = $AA."-".$MA."-".$DA;   
if (strlen($DE) == 1){ $DE = "0".$DE; }
if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fecha2 = $AE."-".$ME."-".$DE; 
}

if(isset($fecha1) && isset($fecha2)) $sql_alt=" AND fecha BETWEEN '$fecha1' AND '$fecha2'";
else $sql_alt="";

$data="<chart caption='ORDENES DE TRABAJO' shownames='1' showvalues='1' decimals='0' numberPrefix='Ordenes '>";
////desde aqui

//NUMERO TOTAL DE ORDENES

	$sql = "SELECT COUNT(id_orden) AS numtot FROM ordenes WHERE cod_usr<>'SISTEMA' $sql_alt";
	$row = mysql_fetch_array(mysql_db_query($db,$sql,$link));
//==========ORDENES DE TRABAJO==========================-
	
		$sql9 = "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' $sql_alt";
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
///hasta aqui
$data.="<set label='Con Conformidad' value='$dat1'/><set label='Sin Conformidad' value='$dat2'/>";
$data.="</chart>";
$prom=$dat2;
?>
<head>
   <script language="JavaScript" src="Charts/FusionCharts.js"></script>
</head>
<body bgcolor="#ffffff">
   <div id="chartdiv" align="center">The chart will appear within this DIV. This text will be replaced by the chart.</div>
   <script type="text/javascript">
      var myChart = new FusionCharts("Charts/Pie3D.swf", "myChartId", "600", "300", "0", "0");
      myChart.setDataXML("<?php=$data?>");
      myChart.render("chartdiv");
   </script>
</body>
