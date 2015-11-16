<?php
include ("../conexion.php");
$data="<chart caption='Tiempo de Ejecución de Ordenes desde el Ingreso de una Orden' shownames='1' showvalues='$show_values' showLabels='$show_lab' decimals='0' numberPrefix='Dias '>";
$data.="<categories><category label='Asignación'/><category label='Solución - Fecha del Sistema'/><category label='Solución - Fecha introducida'/><category label='Conformidad'/></categories>";
////////////////////////////////////////////////
		  if(isset($fecha1) && $fecha2)
			{
				$sql_alt="  AND a.fecha BETWEEN '$fecha1' AND '$fecha2'";
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
		if($menu){$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
		else{     $tiempo_sol1="SELECT DISTINCT(id_orden), MIN(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(fecha_asig) - to_days(a.fecha) AS num FROM asignacion b, ordenes a WHERE b.id_orden=a.id_orden AND b.id_asig=$tiempo_sol1[id_asig] $sql_alt";
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
		$dat1_a=$min1;
		$dat1_z=$max1;
		$dat1_m=$prom1;
		
////////////////////////
/*DESDE ingreso de orden HASTA solucion sistema */
		$i=0;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		if($menu){$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
		else{$tiempo_sol1="SELECT DISTINCT(id_orden), MIN(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(c.fecha_sol) - to_days(a.fecha) AS num FROM ordenes a, solucion c, asignacion b WHERE a.id_orden=c.id_orden AND b.id_asig=$tiempo_sol1[id_asig] AND c.id_orden=$tiempo_sol1[id_orden] $sql_alt";
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
			};
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
		$dat2_a=$min1;
		$dat2_z=$max1;
		$dat2_m=$prom1;
/*DESDE ingreso de orden HASTA solucion-fecha introducida  */
	$i=0;
	$sol1_sum=0;
	$max1=0;
	$min1=0;
	if($menu){$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
	else{$tiempo_sol1="SELECT DISTINCT(id_orden), MIN(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
	$res1=mysql_db_query($db,$tiempo_sol1,$link);
	$num_cols1=mysql_num_rows($res1);
	while($tiempo_sol1=mysql_fetch_array($res1))
	{
		$tiempo_sol2="SELECT to_days(c.fecha_sol_e) - to_days(a.fecha) AS num FROM ordenes a, solucion c, asignacion b WHERE a.id_orden=c.id_orden AND b.id_asig=$tiempo_sol1[id_asig] AND c.id_orden=$tiempo_sol1[id_orden] $sql_alt";
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

		$dat3_a=$min1;
		$dat3_z=$max1;
		$dat3_m=$prom1;
		
	/*DESDE ingreso de orden HASTA conformidad */
	$i=0;
	$sol1_sum=0;
	$max1=0;
	$min1=0;
	if($menu){$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
	else{$tiempo_sol1="SELECT DISTINCT(id_orden), MIN(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
	$res1=mysql_db_query($db,$tiempo_sol1,$link);
	$num_cols1=mysql_num_rows($res1);
	while($tiempo_sol1=mysql_fetch_array($res1))
	{
		$tiempo_sol2="SELECT to_days(c.fecha_conf) - to_days(a.fecha) AS num FROM ordenes a, conformidad c, asignacion b WHERE a.id_orden=c.id_orden AND b.id_asig=$tiempo_sol1[id_asig] AND c.id_orden=$tiempo_sol1[id_orden] $sql_alt";
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
		$dat4_a=$min1;
		$dat4_z=$max1;
		$dat4_m=$prom1;

$data.="<dataset seriesName='Minimo' color='AFD8F8' showValues='$show_values' showLabels='$show_lab'>";
$data.="<set label='Minimo (Dias)' value='$dat1_a' /><set label='Minimo (Dias)' value='$dat2_a' /><set label='Minimo (Dias)' value='$dat3_a' /><set label='Minimo (Dias)' value='$dat4_a' />";
$data.="</dataset><dataset seriesName='Maximo' color='F6BD0F' showValues='$show_values' showLabels='$show_lab'>";
$data.="<set label='Maximo (Dias)' value='$dat1_z' /><set label='Maximo (Dias)' value='$dat2_z' /><set label='Maximo (Dias)' value='$dat3_z' /><set label='Maximo (Dias)' value='$dat4_z' />";
$data.="</dataset><dataset seriesName='Promedio' color='8BBA00' showValues='$show_values' showLabels='$show_lab'>";
$data.="<set label='Promedio (Dias)' value='$dat1_m' /><set label='Promedio (Dias)' value='$dat2_m' /><set label='Promedio (Dias)' value='$dat3_m' /><set label='Promedio (Dias)' value='$dat4_m' />";
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
