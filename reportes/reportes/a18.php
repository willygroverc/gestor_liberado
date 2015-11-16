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
//==========ORDENES DE TRABAJO==========================-
	
		$sql9 = "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' $sql_alt";
		$rs19 = mysql_db_query($db,$sql9,$link);
		$numAsig = 0;
		while ($tmp = mysql_fetch_array($rs19))  {			
				$total[$numAsig] = $tmp[id_orden];
				$numAsig++;
		}
//NUMERO TOTAL DE ORDENES

	$sql = "SELECT COUNT(id_orden) AS numtot FROM ordenes WHERE cod_usr<>'SISTEMA' $sql_alt";
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
$data.="<set label='Con Seguimiento' value='$dat1'/><set label='Sin Seguimiento' value='$dat2'/>";
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
