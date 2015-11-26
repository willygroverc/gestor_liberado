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
				$total[$numAsig] = $tmp['id_orden'];
				$numAsig++;
		}
//NUMERO DE ORDNES CON CONFORMIDAD DEL CLIENTE 
	$numConf=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
		$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
		if ($rsTmp3['id_orden']==$total[$i]){
		$numConf++;}
	}
	$row5['conf']=$numConf;
	
//NUMERO DE ORDENES ANIDADAS
		$anid = 0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql = "SELECT id_orden FROM ordenes WHERE id_orden='$total[$i]' AND  id_anidacion <>'0'";
			$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
			if ($rsTmp3['id_orden']==$total[$i]){
			$anid++;}
		}
		$rowa['anid']=$anid;
		
//NUMERO DE ORDENES NO ANIDADAS
		$noanid=$row5['conf']-$anid;
		
//ENVIO DE DATOS
	$dat1 = $rowa['anid'];
	$dat2 = $noanid;
///hasta aqui
$data.="<set label='Anidadas' value='$dat1'/><set label='Sin Anidar' value='$dat2'/>";
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
