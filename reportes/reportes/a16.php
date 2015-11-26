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
//NUMERO DE ORDENES ASIGNADAS  
$sql1 = "SELECT DISTINCT(asignacion.id_orden), MAX(asignacion.id_asig) FROM ordenes, asignacion 
WHERE ordenes.id_orden=asignacion.id_orden AND ordenes.cod_usr<>'SISTEMA' $sql_alt GROUP BY asignacion.id_orden";
$row1['asig'] = mysql_num_rows(mysql_db_query($db,$sql1,$link));
//NUMERO DE ORDENES NO ASIGNADAS
$noasig=$row['numtot']-$row1['asig'];
$dat1=$row1['asig'];
$dat2=$noasig;
//hasta aqui
$data.="<set label='Asignadas' value='$dat1'/><set label='No Asignadas' value='$dat2'/>";
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
      myChart.setDataXML("<?php echo $data;?>");
      myChart.render("chartdiv");
   </script>
</body>
