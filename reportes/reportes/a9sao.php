<?php
include ("../conexion.php");
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
	$tiempo_sol2="SELECT to_days(fecha_asig) - to_days(b.fecha) AS num FROM asignacion a, ordenes b WHERE a.id_orden=b.id_orden AND a.id_asig=$tiempo_sol1[id_asig] $var_cond_o1 $var2";
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
	$tiempo_sol2="SELECT to_days(c.fecha_sol) - to_days(a.fecha) AS num FROM ordenes a, solucion c, asignacion b WHERE a.id_orden=c.id_orden AND b.id_asig=$tiempo_sol1[id_asig] AND c.id_orden=$tiempo_sol1[id_orden] $var_cond_o2 $var2";
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
	$tiempo_sol2="SELECT to_days(c.fecha_sol_e) - to_days(a.fecha) AS num FROM ordenes a, solucion c, asignacion b WHERE a.id_orden=c.id_orden AND b.id_asig=$tiempo_sol1[id_asig] AND c.id_orden=$tiempo_sol1[id_orden] $var_cond_o3 $var2";
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
	$tiempo_sol2="SELECT to_days(c.fecha_conf) - to_days(a.fecha) AS num FROM ordenes a, conformidad c, asignacion b WHERE a.id_orden=c.id_orden AND b.id_asig=$tiempo_sol1[id_asig] AND c.id_orden=$tiempo_sol1[id_orden] $var_cond_o4 $var2";
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
$prom=($dat1_m+$dat2_m+$dat3_m+$dat4_m)/4;
?>