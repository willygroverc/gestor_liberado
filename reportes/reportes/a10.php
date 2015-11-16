<?php
//include("Includes/FusionCharts.php");
//include("../conexion.php");

$data="<chart caption='Tiempo de Ejecución de Ordenes desde la Asignacion de una Orden' shownames='1' showvalues='$show_values' showLabels='$show_lab' decimals='0' numberPrefix='Dias '>";
$data.="<categories><category label='Solución - Fecha del Sistema'/><category label='Solución - Fecha introducida'/><category label='Conformidad'/></categories>";
////////////////////////////////////////////////
		  if(isset($fecha1) && $fecha2)
			{
				$sql_alt="  AND b.fecha_asig BETWEEN '$fecha1' AND '$fecha2'";
			}
				else
			{
				$sql_alt="";

			}
////////////////////////////////////////////////

/* SEGUNDA TABLA 
DESDE asignacion HASTA solucion - fecha sistema */
	$i=0;
	$sol1_sum=0;
	$max1=0;
	$min1=0;
	$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
	$res1=mysql_db_query($db,$tiempo_sol1,$link);
	$num_cols1=mysql_num_rows($res1);
	while($tiempo_sol1=mysql_fetch_array($res1))
	{
		$tiempo_sol2="SELECT to_days(fecha_sol) - to_days(b.fecha_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.id_asig=$tiempo_sol1[id_asig] $sql_alt";
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
		$dat5_a=$min1;
		$dat5_z=$max1;
		$dat5_m=$prom1;
/*DESDE asignacion HASTA solucion - fecha introducida */
	$i=0;
	$sol1_sum=0;
	$max1=0;
	$min1=0;
	$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
	$res1=mysql_db_query($db,$tiempo_sol1,$link);
	$num_cols1=mysql_num_rows($res1);
	while($tiempo_sol1=mysql_fetch_array($res1))
	{
		$tiempo_sol2="SELECT to_days(fecha_sol_e) - to_days(b.fecha_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.id_asig=$tiempo_sol1[id_asig] $sql_alt";
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
		$dat6_a=$min1;
		$dat6_z=$max1;
		$dat6_m=$prom1;

/*DESDE asignacion HASTA conformidad */
	$i=0;
	$sol1_sum=0;
	$max1=0;
	$min1=0;
	$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
	$res1=mysql_db_query($db,$tiempo_sol1,$link);
	$num_cols1=mysql_num_rows($res1);
	while($tiempo_sol1=mysql_fetch_array($res1))
	{
		$tiempo_sol2="SELECT to_days(fecha_conf) - to_days(b.fecha_asig) AS num FROM conformidad a, asignacion b WHERE a.id_orden=b.id_orden AND b.id_asig=$tiempo_sol1[id_asig] $sql_alt";
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
		$dat7_a=$min1;
		$dat7_z=$max1;
		$dat7_m=$prom1;
		
$data.="<dataset seriesName='Minimo' color='AFD8F8' showvalues='$show_values' showLabels='$show_lab'>";
$data.="<set label='Minimo (Dias)' value='$dat5_a' /><set label='Minimo (Dias)' value='$dat6_a' /><set label='Minimo (Dias)' value='$dat7_a' />";
$data.="</dataset><dataset seriesName='Maximo' color='F6BD0F' showvalues='$show_values' showLabels='$show_lab'>";
$data.="<set label='Maximo (Dias)' value='$dat5_z' /><set label='Maximo (Dias)' value='$dat6_z' /><set label='Maximo (Dias)' value='$dat7_z' />";
$data.="</dataset><dataset seriesName='Promedio' color='8BBA00' showvalues='$show_values' showLabels='$show_lab'>";
$data.="<set label='Promedio (Dias)' value='$dat5_m' /><set label='Promedio (Dias)' value='$dat6_m' /><set label='Promedio (Dias)' value='$dat7_m' />";
$data.="</dataset></chart>";
?>
<head>
   <script language="JavaScript" src="Charts/FusionCharts.js"></script>
</head>

<body bgcolor="#ffffff">

   <div id="chartdiv<?php $ra=rand(); echo $ra?>" align="center">The chart will appear within this DIV. This text will be replaced by the chart.</div>
   <script type="text/javascript">
      var myChart = new FusionCharts("Charts/MSColumn3D.swf", "myChartId", "<?php=$tam1?>", "<?php=$tam2?>", "0", "0");
      myChart.setDataXML("<?php=$data?>");
      myChart.render("chartdiv<?php=$ra?>");
   </script>

</body>
