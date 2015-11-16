<?php
if(isset($DA) && isset($MA)){
if (strlen($DA) == 1){ $DA = "0".$DA; }
if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
	$fecha1 = $AA."-".$MA."-".$DA;   
if (strlen($DE) == 1){ $DE = "0".$DE; }
if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fecha2 = $AE."-".$ME."-".$DE; 
}

if(isset($fecha1) && isset($fecha2)) $sql_alt=" AND fecha_conf BETWEEN '$fecha1' AND '$fecha2'";
if($val_area!=0) $sql_alt.=" AND b.area=$val_area";


$data="<chart caption='Calidad de la Atencion (Porcentual)' shownames='1' showvalues='1' decimals='0' numberPrefix='Ordenes '>";
////desde aqui
//==========ORDENES DE TRABAJO==========================-
$sql="SELECT count(*) as num FROM conformidad WHERE calidaten_conf = 1 $sql_alt";
$rs = mysql_db_query($db,$sql,$link);
$tmp = mysql_fetch_array($rs);
$data.="<set label='Malo' value='$tmp[num]'/>";

$sql="SELECT count(*) as num FROM conformidad WHERE calidaten_conf = 2 $sql_alt";
$rs = mysql_db_query($db,$sql,$link);
$tmp = mysql_fetch_array($rs);
$data.="<set label='Bueno' value='$tmp[num]'/>";

$sql="SELECT count(*) as num FROM conformidad WHERE calidaten_conf = 3 $sql_alt";
$rs = mysql_db_query($db,$sql,$link);
$tmp = mysql_fetch_array($rs);
$data.="<set label='Excelente' value='$tmp[num]'/>";
			

//hasta aqui

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
