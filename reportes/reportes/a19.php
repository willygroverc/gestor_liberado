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
//NUMERO DE ORDENES ASIGNADAS  

	$sql1 = "SELECT DISTINCT(asignacion.id_orden), MAX(asignacion.id_asig) FROM ordenes, asignacion 
	WHERE ordenes.id_orden=asignacion.id_orden AND ordenes.cod_usr<>'SISTEMA' $sql_alt GROUP BY asignacion.id_orden";
	$row1[asig] = mysql_num_rows(mysql_db_query($db,$sql1,$link));

//NUMERO DE ORDENES CON SOLUCION  
	$solu=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql4 = "SELECT id_orden FROM solucion WHERE id_orden='$total[$i]'";  //=============HERE VIC
		$row4 = mysql_fetch_array(mysql_db_query($db,$sql4,$link));
		if ($row4[id_orden]==$total[$i]) {
		$solu++;}
	}
	$row4[solu]=$solu;		
	
//NUMERO DE ORDENES SIN SOLUCION
	$nosolu=$row1[asig]-$row4[solu];
//ENVIO DE DATOS
	$dat1=$row4[solu];
	$dat2=$nosolu;
//hasta aqui
$data.="<set label='Con Solucion' value='$dat1'/><set label='Sin Solucion' value='$dat2'/>";
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
