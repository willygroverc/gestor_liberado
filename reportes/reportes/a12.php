<?php
$data="<chart caption='SOLUCION A TIEMPO' shownames='1' showvalues='1' decimals='0' numberPrefix='Dias '>";
////desde aqui
/* NUEVA TABLA SOLUCION A TIEMPO
	DESDE fecha estimada de solucion  HASTA solucion - fecha sistema*/
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
		$tiempo_sol2="SELECT to_days(fecha_sol) - to_days(b.fechaestsol_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.fechaestsol_asig=a.fecha_sol AND b.id_asig=$tiempo_sol1[id_asig] $sql_alt";
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
	$dat1=$i;
/* DESDE fecha estimada de solucion  HASTA solucion - fecha introducida */
	$i=0;
	$sol1_sum=0;
	$max1=0;
	$min1=0;
	$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
	$res1=mysql_db_query($db,$tiempo_sol1,$link);
	$num_cols1=mysql_num_rows($res1);
	while($tiempo_sol1=mysql_fetch_array($res1))
	{
		$tiempo_sol2="SELECT to_days(fecha_sol_e) - to_days(b.fechaestsol_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.fechaestsol_asig=a.fecha_sol_e AND b.id_asig=$tiempo_sol1[id_asig] $sql_alt";
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
	$dat2=$i;
	
	///hasta aqui
$data.="<set label='Solucion: Fecha del Sistema' value='$dat1'/><set label='Solucion: Fecha Introducida' value='$dat2'/>";
$data.="</chart>";
?>
<head>
   <script language="JavaScript" src="Charts/FusionCharts.js"></script>
</head>
<body bgcolor="#ffffff">
   <div id="chartdiv" align="center">The chart will appear within this DIV. This text will be replaced by the chart.</div>
   <script type="text/javascript">
      var myChart = new FusionCharts("Charts/Column3D.swf", "myChartId", "600", "300", "0", "0");
      myChart.setDataXML("<?php=$data?>");
      myChart.render("chartdiv");
   </script>
</body>
