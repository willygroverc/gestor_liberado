<?php
$data="<chart caption='Tiempo de Ejecución de Ordenes desde la Solucion en Fecha Introducida' shownames='1' showvalues='0' decimals='0' numberPrefix='Dias '>";
$data.="<categories><category label='Solución - Fecha del Sistema'/><category label='Conformidad'/></categories>";


/* ULTIMA TABLA 
	DESDE solucion fecha introducida HASTA solucion- fecha sistema */ 
////////////////////////////////////////////////
		  if(isset($fecha1) && $fecha2)
			{
				$sql_alt=" AND b.fecha_asig BETWEEN '$fecha1' AND '$fecha2'";
			}
				else
			{
				$sql_alt="";

			}
////////////////////////////////////////////////
	$i=0;
	$sol1_sum=0;
	$max1=0;
	$min1=0;
	$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
	$res1=mysql_db_query($db,$tiempo_sol1,$link);
	$num_cols1=mysql_num_rows($res1);
	while($tiempo_sol1=mysql_fetch_array($res1))
	{
		$tiempo_sol2="SELECT to_days(c.fecha_sol) - to_days(c.fecha_sol_e) AS num FROM solucion c, asignacion b WHERE b.id_asig=$tiempo_sol1[id_asig] AND c.id_orden=$tiempo_sol1[id_orden] $sql_alt";
		$res2=mysql_db_query($db,$tiempo_sol2,$link);
		$tiempo_sol2=mysql_fetch_array($res2);
		if($tiempo_sol2)
		{
			if($i==0)
			{
				$max1=$tiempo_sol2[num];
				$min1=$tiempo_sol2[num];
			}
			else
			{
				if($tiempo_sol2[num]>$max1){$max1=$tiempo_sol2[num];}
				if($tiempo_sol2[num]<$min1){$min1=$tiempo_sol2[num];}
			}
			$i++;
			$sol1_sum+=$tiempo_sol2[num];
		}
	}
	if($i==0) $prom1=0;
	else $prom1=number_format(round($sol1_sum/$i,2),2);
		$dat16_a=$min1;
		$dat16_z=$max1;
		$dat16_m=$prom1;
/* DESDE solucin fecha introducida HASTA conformidad */ 
	$i=0;
	$sol1_sum=0;
	$max1=0;
	$min1=0;
	$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
	$res1=mysql_db_query($db,$tiempo_sol1,$link);
	$num_cols1=mysql_num_rows($res1);
	while($tiempo_sol1=mysql_fetch_array($res1))
	{
		$tiempo_sol2="SELECT to_days(a.fecha_conf) - to_days(c.fecha_sol_e) AS num FROM solucion c, conformidad a, asignacion b WHERE c.id_orden=a.id_orden AND b.id_asig=$tiempo_sol1[id_asig] AND c.id_orden=$tiempo_sol1[id_orden] $sql_alt";
		$res2=mysql_db_query($db,$tiempo_sol2,$link);
		$tiempo_sol2=mysql_fetch_array($res2);
		if($tiempo_sol2)
		{
			if($i==0)
			{
				$max1=$tiempo_sol2[num];
				$min1=$tiempo_sol2[num];
			}
			else
			{
				if($tiempo_sol2[num]>$max1){$max1=$tiempo_sol2[num];}
				if($tiempo_sol2[num]<$min1){$min1=$tiempo_sol2[num];}
			}
			$i++;
			$sol1_sum+=$tiempo_sol2[num];
		}
	}
	if($i==0) $prom1=0;
	else $prom1=number_format(round($sol1_sum/$i,2),2);
		$dat17_a=$min1;
		$dat17_z=$max1;
		$dat17_m=$prom1;
		
$data.="<dataset seriesName='Minimo' color='AFD8F8' showValues='0'>";
$data.="<set label='Minimo (Dias)' value='$dat16_a' /><set label='Minimo (Dias)' value='$dat17_a' />";
$data.="</dataset><dataset seriesName='Maximo' color='F6BD0F' showValues='0'>";
$data.="<set label='Maximo (Dias)' value='$dat16_z' /><set label='Maximo (Dias)' value='$dat17_z' />";
$data.="</dataset><dataset seriesName='Promedio' color='8BBA00' showValues='0'>";
$data.="<set label='Promedio (Dias)' value='$dat16_m' /><set label='Promedio (Dias)' value='$dat17_m' />";
$data.="</dataset></chart>";
?>
<head>
   <script language="JavaScript" src="Charts/FusionCharts.js"></script>
</head>

<body bgcolor="#ffffff">

   <div id="chartdiv" align="center">The chart will appear within this DIV. This text will be replaced by the chart.</div>
   <script type="text/javascript">
      var myChart = new FusionCharts("Charts/MSColumn3D.swf", "myChartId", "600", "300", "0", "0");
      myChart.setDataXML("<?php=$data?>");
      myChart.render("chartdiv");
   </script>

</body>
