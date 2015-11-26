<?php
$data="<chart caption='SOLUCION ANTICIPADA' shownames='1' showvalues='0' decimals='0' numberPrefix='Dias '>";
$data.="<categories><category label='Solución - Fecha del Sistema'/><category label='Solución - Fecha introducida'/></categories>";

if(isset($_REQUEST['var_cond_s1'])) $var_cond_s1=$_REQUEST['var_cond_s1']; else $var_cond_s1="";
if(isset($_REQUEST['var2'])) $var2=$_REQUEST['var2']; else $var2="";
if(isset($_REQUEST['var_cond_s2'])) $var_cond_s2=$_REQUEST['var_cond_s2']; else $var_cond_s2="";
/*  TABLA SOLUCIN ANTICIPADA
DESDE fecha de estimada de solucion HASTA solucion fecha sistema */ 
 
	$i=0;
	$sol1_sum=0;
	$max1=0;
	$min1=0;
	$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
	$res1=mysql_db_query($db,$tiempo_sol1,$link);
	$num_cols1=mysql_num_rows($res1);
	while($tiempo_sol1=mysql_fetch_array($res1))
	{
		$tiempo_sol2="SELECT to_days(fecha_sol) - to_days(b.fechaestsol_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.fechaestsol_asig>a.fecha_sol AND b.id_asig=$tiempo_sol1[id_asig] $var_cond_s1 $var2";
		
		$res2=mysql_db_query($db,$tiempo_sol2,$link);
		$tiempo_sol2=mysql_fetch_array($res2);
		if($tiempo_sol2)
		{
		if($i==0)
		{
			$max1=$tiempo_sol2['num'];
			$min1=$tiempo_sol2['num'];
		}
		else
			{
			if($tiempo_sol2['num']<$max1){$max1=$tiempo_sol2['num'];}
			if($tiempo_sol2['num']>$min1){$min1=$tiempo_sol2['num'];}
			}
			$i++;
			$sol1_sum+=$tiempo_sol2['num'];
		}
	}
	if($i==0) $prom1=0;
	else $prom1=number_format(round($sol1_sum/$i,2),2);
		$dat8_a=-$min1;
		$dat8_z=-$max1;
		$dat8_m=-$prom1;
/*DESDE fecha de estimada de solucion HASTA solucion fecha introducida */ 
	$i=0;
	$sol1_sum=0;
	$max1=0;
	$min1=0;
	$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
	$res1=mysql_db_query($db,$tiempo_sol1,$link);
	$num_cols1=mysql_num_rows($res1);
	while($tiempo_sol1=mysql_fetch_array($res1))
	{
		$tiempo_sol2="SELECT to_days(fecha_sol_e) - to_days(b.fechaestsol_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.fechaestsol_asig>a.fecha_sol_e AND b.id_asig=$tiempo_sol1[id_asig] $var_cond_s2 $var2";
		$res2=mysql_db_query($db,$tiempo_sol2,$link);
		$tiempo_sol2=mysql_fetch_array($res2);
		if($tiempo_sol2)
		{
			if($i==0)
			{
				$max1=$tiempo_sol2['num'];
				$min1=$tiempo_sol2['num'];
			}
			else
			{
				if($tiempo_sol2['num']<$max1){$max1=$tiempo_sol2['num'];}
				if($tiempo_sol2['num']>$min1){$min1=$tiempo_sol2['num'];}
			}
			$i++;
			$sol1_sum+=$tiempo_sol2['num'];
		}
	}
	if($i==0) $prom1=0;
	else $prom1=number_format(round($sol1_sum/$i,2),2);
		$dat9_a=-$min1;
		$dat9_z=-$max1;
		$dat9_m=-$prom1;
		
$data.="<dataset seriesName='Minimo' color='AFD8F8' showValues='0'>";
$data.="<set label='Minimo (Dias)' value='$dat8_a' /><set label='Minimo (Dias)' value='$dat9_a' />";
$data.="</dataset><dataset seriesName='Maximo' color='F6BD0F' showValues='0'>";
$data.="<set label='Maximo (Dias)' value='$dat8_z' /><set label='Maximo (Dias)' value='$dat9_z' />";
$data.="</dataset><dataset seriesName='Promedio' color='8BBA00' showValues='0'>";
$data.="<set label='Promedio (Dias)' value='$dat8_m' /><set label='Promedio (Dias)' value='$dat9_m' />";
$data.="</dataset></chart>";
?>
<head>
   <script language="JavaScript" src="Charts/FusionCharts.js"></script>
</head>

<body bgcolor="#ffffff">

   <div id="chartdiv" align="center">The chart will appear within this DIV. This text will be replaced by the chart.</div>
   <script type="text/javascript">
      var myChart = new FusionCharts("Charts/MSColumn3D.swf", "myChartId", "600", "300", "0", "0");
      myChart.setDataXML("<?php echo $data;?>");
      myChart.render("chartdiv");
   </script>

</body>