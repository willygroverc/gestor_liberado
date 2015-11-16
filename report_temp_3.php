<?php
include("datos_gral.php");
include("conexion.php");
if($menu=='ASIGNADO') $var2="AND asig='$nombre'";
if(isset($DA)){
	if (strlen($DA) == 1){ $DA = "0".$DA; }
	if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
    $fec1 = $AA."-".$MA."-".$DA;   
	if (strlen($DE) == 1){ $DE = "0".$DE; }
	if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fec2 = $AE."-".$ME."-".$DE; 
	$var_cond1="AND fecha_sol_e BETWEEN '$fec1' AND '$fec2'";
	$var_cond2="AND a.fecha_asig BETWEEN '$fec1' AND '$fec2' AND b.fecha BETWEEN '$fec1' AND '$fec2'";
	$var_cond3="AND a.fecha_sol_e BETWEEN '$fec1' AND '$fec2' AND b.fecha BETWEEN '$fec1' AND '$fec2'";
	$var_cond4="AND a.fecha_sol_e BETWEEN '$fec1' AND '$fec2' AND b.fecha_asig BETWEEN '$fec1' AND '$fec2'";
	$var_cond5="AND a.fecha_sol BETWEEN '$fec1' AND '$fec2' AND b.fecha BETWEEN '$fec1' AND '$fec2'";
	$var_cond6="AND a.fecha_sol BETWEEN '$fec1' AND '$fec2' AND b.fecha_asig BETWEEN '$fec1' AND '$fec2'";
	$var_cond7="AND a.fecha_sol BETWEEN '$fec1' AND '$fec2' AND a.fecha_sol_e BETWEEN '$fec1' AND '$fec2'";
	$var_cond8="AND a.fecha_conf BETWEEN '$fec1' AND '$fec2' AND b.fecha BETWEEN '$fec1' AND '$fec2'";
	$var_cond9="AND a.fecha_conf BETWEEN '$fec1' AND '$fec2' AND b.fecha_asig BETWEEN '$fec1' AND '$fec2'";
	$var_cond10="AND a.fecha_conf BETWEEN '$fec1' AND '$fec2' AND b.fecha_sol_e BETWEEN '$fec1' AND '$fec2'";
	$var_cond11="AND a.fecha_conf BETWEEN '$fec1' AND '$fec2' AND b.fecha_sol BETWEEN '$fec1' AND '$fec2'";
}
?>
<title>REPORTE POR TIEMPOS</title>
<font size="el burr"></font>
<table width="70%">
<tr>
<?php 
if($menu)
{
	$sql_us="SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$nombre'";
	$result_us=mysql_db_query($db,$sql_us,$link);
	$row_us=mysql_fetch_array($result_us);
	echo "<td width=\"26%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>&nbsp;&nbsp;&nbsp;Reporte:</strong></font></td>";
	echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Asignado a $row_us[nom_usr] $row_us[apa_usr] $row_us[ama_usr]</font></td>";
}
else 
{
	echo "<td width=\"26%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>&nbsp;&nbsp;&nbsp;Reporte:</strong></font></td>";
	echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">GENERAL</font></td>";
}
if(isset($DA))
{
	echo "<tr>";
	echo "<td width=\"26%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>&nbsp;&nbsp;&nbsp;Entre Fechas:</strong></font></td>";
	echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Del:".$DA."/".$MA."/".$AA."&nbsp;&nbsp;&nbsp;Al:".$DE."/".$ME."/".$AE."</font></td>";
	echo "</tr>";
}
else {echo "<tr>";}
?>
</table>
<p align="center"><strong><font face="Arial, Helvetica, sans-serif"><u>TIEMPOS 
  DE EJECUCION DE ORDENES</u></font></strong></p>
<div align="center">
  <table width="50%" border="1" cellspacing="0">
    <tr bgcolor="#CCCCCC"> 
      <td colspan="2"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA ESTIMADA DE SOLUCION 
<?php
$tiempo_sol2="SELECT to_days(b.fechaestsol_asig) - to_days(fecha_sol_e) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden $var_cond1 $var2 ORDER BY num DESC";
$res2=mysql_db_query($db,$tiempo_sol2,$link);
$num_cols2=mysql_num_rows($res2);
$pasados=0;
$atiempo=0;
while($tiempo_sol2=mysql_fetch_array($res2))
{
	if($tiempo_sol2[num] < 0) $pasados++;
	else $atiempo++;
}
if($num_cols2==0) $prom2=0;
else $prom2=number_format(round($sol2_sum/$num_cols2,2),2);
?>
          </strong><strong> </strong></font></div></td>
    </tr>
    <tr> 
      <td width="84%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>ORDENES 
        SOLUCIONADAS A TIEMPO :</strong></font></td>
      <td width="16%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$atiempo?>
          </font></div></td>
    </tr>
    <tr> 
      <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>ORDENES SOLUCIONADAS 
        FUERA DE TIEMPO :</strong></font></td>
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$pasados?>
          </font></div></td>
    </tr>
  </table>
</div>
<p align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif"><u>ASIGNACION</u> 
</font></strong></p>
<div align="center">
  <table width="95%" border="1" cellspacing="0" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
      <td width="17%" rowspan="2"> <div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;DESDE</font></strong></font></div></td>
      <td width="27%" rowspan="2"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">HASTA</font></strong></font></div></td>
      <td width="8%" rowspan="2"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">Nro. 
          ORDENES</font></strong></font></div></td>
      <td height="23" colspan="4"> <div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif">TIEMPO 
          TRANCURRIDO</font></strong></font></strong></font></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td width="10%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">MAXIMO</font></strong></font></div></td>
      <td width="9%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">MINIMO</font></strong></font></div></td>
      <td width="10%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">PROMEDIO</font></strong></font></div></td>
      <td width="19%" bgcolor="#006699">&nbsp;</td>
    </tr>
    <?php
		//$tiempo_asig="SELECT to_days(fecha_asig) - to_days(b.fecha) AS num FROM asignacion a, ordenes b WHERE a.id_orden=b.id_orden $var_cond2 $var2 ORDER BY num DESC";
		$tiempo_asig="SELECT to_days(fecha_asig) - to_days(b.fecha) AS num FROM asignacion a, ordenes b WHERE a.id_orden=b.id_orden GROUP BY a.id_orden ORDER BY num DESC";
		$res=mysql_db_query($db,$tiempo_asig,$link);
		$num_cols=mysql_num_rows($res);
		$i=1;
		$asig_sum=0;
		$max=0;
		$min=0;
		while($tiempo_asig=mysql_fetch_array($res)){
			if($i==1) if($tiempo_asig[num]) $max=$tiempo_asig[num];
			if($i==$num_cols) if($tiempo_asig[num]) $min=$tiempo_asig[num];
			$i++;
			$asig_sum+=$tiempo_asig[num];
		}
		if($num_cols==0) {$prom=0;}
		else {$prom=number_format(round($asig_sum/$num_cols,2),2);}
	?>
    <tr align="center"> 
      <td rowspan="4" valign="top"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;INGRESO 
          DE ORDEN </font></strong></div></td>
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ASIGNACION</font></strong></div></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $num_cols;?>&nbsp;</font></td>
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $max." dia(s)";?>&nbsp;</font></div></td>
      <td><div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"><?php echo $min." dia(s)";?>&nbsp;</font></div></td>
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $prom." dia(s)";?>&nbsp;</font></div></td>
	  <?php if($max<>0){$porc=($prom*100)/$max;} else{$porc=0;}?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=15 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
    <?php
		$tiempo_sol1="SELECT to_days(fecha_sol) - to_days(b.fecha) AS num FROM solucion a, ordenes b WHERE a.id_orden=b.id_orden $var_cond5 $var2 ORDER BY num DESC";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		$i=1;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		while($tiempo_sol1=mysql_fetch_array($res1)){
			if($i==1) if($tiempo_sol1[num]) $max1=$tiempo_sol1[num];
			if($i==$num_cols1) if($tiempo_sol1[num]) $min1=$tiempo_sol1[num];
			$i++;
			$sol1_sum+=$tiempo_sol1[num];
		}
		if($num_cols1==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$num_cols1,2),2);
	?>
    <tr align="center"> 
      <td><strong><font size="2" face="Arial, Helvetica, sans-serif">SOLUCION 
        - FECHA SISTEMA</font></strong></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $num_cols1;?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $max1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $min1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $prom1." dia(s)";?>&nbsp;</font></td>
       <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=15 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
    <?php
		$i=1;
		$sol1_sum=0;
		$min1=0;
		$max1=0;
		$tiempo_sol1="SELECT to_days(fecha_sol_e) - to_days(b.fecha) AS num FROM solucion a, ordenes b WHERE a.id_orden=b.id_orden $var_cond3 $var2 ORDER BY num DESC";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			if($i==1) if($tiempo_sol1[num] && $tiempo_sol1[num]>0) $max1=$tiempo_sol1[num];
			if($i==$num_cols1) if($tiempo_sol1[num] && $tiempo_sol1[num]>0) $min1=$tiempo_sol1[num];
			$i++;
			$sol1_sum+=$tiempo_sol1[num];
		}
		if($num_cols1==0) {$prom1=0;}
		else {$prom1=number_format(round($sol1_sum/$num_cols1,2),2);}
		?>
    <tr align="center"> 
      <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOLUCION 
        - FECHA INTRODUCIDA</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $num_cols1;?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $max1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $min1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $prom1." dia(s)";?>&nbsp;</font></td>
      <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=16 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
    <?php
		$i=0;
		$max1=0;
		$min1=0;
		$sol1_sum=0;
		$prom1=0;
		$tiempo_sol1="SELECT to_days(fecha_conf) - to_days(b.fecha) AS num FROM conformidad a, ordenes b WHERE a.id_orden=b.id_orden $var_cond8 $var2 ORDER BY num DESC";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1)){
			if($i==1) $max1=$tiempo_sol1[num];
			if($i==$num_cols1) $min1=$tiempo_sol1[num];
			$i++;
			$sol1_sum+=$tiempo_sol1[num];
		}
		if($num_cols1==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$num_cols1,2),2);
	?>
    <tr align="center"> 
      <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CONFORMIDAD</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $num_cols1;?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $max1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $min1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $prom1." dia(s)";?>&nbsp;</font></td>
       <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=15 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
  </table>
  <br>
  <table width="95%" border="1" cellspacing="0" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
      <td width="17%" rowspan="2"> <div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;DESDE</font></strong></font></div></td>
      <td width="27%" rowspan="2"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">HASTA</font></strong></font></div></td>
      <td width="8%" rowspan="2"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">Nro. 
          ORDENES</font></strong></font></div></td>
      <td height="23" colspan="4"> <div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif">TIEMPO 
          TRANCURRIDO</font></strong></font></strong></font></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td width="10%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">MAXIMO</font></strong></font></div></td>
      <td width="9%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">MINIMO</font></strong></font></div></td>
      <td width="10%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">PROMEDIO</font></strong></font></div></td>
      <td width="19%" bgcolor="#006699">&nbsp;</td>
    </tr>
    <?php
		$i=0;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(fecha_sol) - to_days(b.fecha_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.id_asig=$tiempo_sol1[id_asig]";
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
	?>
		<?php
		/*$tiempo_sol1="SELECT id_asig,to_days(fecha_sol) - to_days(b.fecha_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden $var_cond5 $var2 GROUP BY b.id_orden ORDER BY num DESC";
		echo $tiempo_sol1
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		$i=1;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		while($tiempo_sol1=mysql_fetch_array($res1)){
			if($i==1) if($tiempo_sol1[num]) $max1=$tiempo_sol1[num];
			if($i==$num_cols1) if($tiempo_sol1[num]) $min1=$tiempo_sol1[num];
			$i++;
			$sol1_sum+=$tiempo_sol1[num];
		}
		if($num_cols1==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$num_cols1,2),2);*/
	?>
    <tr align="center"> 
      <td rowspan="3" valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif">ASIGNACION</font></strong></td>
      <td><strong><font size="2" face="Arial, Helvetica, sans-serif">SOLUCION 
        - FECHA SISTEMA</font></strong></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $max1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $min1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $prom1." dia(s)";?>&nbsp;</font></td>
      <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=15 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
     <?php
		$i=0;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(fecha_sol_e) - to_days(b.fecha_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.id_asig=$tiempo_sol1[id_asig]";
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
	?>
	
	<?php
		/*$i=1;
		$sol1_sum=0;
		$min1=0;
		$max1=0;
		$tiempo_sol1="SELECT to_days(fecha_sol_e) - to_days(b.fecha_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden $var_cond3 $var2 GROUP BY b.id_orden ORDER BY num DESC";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			if($i==1) if($tiempo_sol1[num] && $tiempo_sol1[num]>0) $max1=$tiempo_sol1[num];
			if($i==$num_cols1) if($tiempo_sol1[num] && $tiempo_sol1[num]>0) $min1=$tiempo_sol1[num];
			$i++;
			$sol1_sum+=$tiempo_sol1[num];
		}
		if($num_cols1==0) {$prom1=0;}
		else {$prom1=number_format(round($sol1_sum/$num_cols1,2),2);}*/
		?>
    <tr align="center"> 
      <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOLUCION 
        - FECHA INTRODUCIDA</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $max1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $min1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $prom1." dia(s)";?>&nbsp;</font></td>
      <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=16 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
    <?php
		$i=0;
		$max1=0;
		$min1=0;
		$sol1_sum=0;
		$prom1=0;
		$tiempo_sol1="SELECT to_days(fecha_conf) - to_days(b.fecha_asig) AS num FROM conformidad a, asignacion b WHERE a.id_orden=b.id_orden $var_cond8 $var2 GROUP BY b.id_orden ORDER BY num DESC";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1)){
			if($i==1) $max1=$tiempo_sol1[num];
			if($i==$num_cols1) $min1=$tiempo_sol1[num];
			$i++;
			$sol1_sum+=$tiempo_sol1[num];
		}
		if($num_cols1==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$num_cols1,2),2);
	?>
    <tr align="center"> 
      <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CONFORMIDAD</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $num_cols1;?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $max1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $min1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $prom1." dia(s)";?>&nbsp;</font></td>
      <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=15 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
  </table>
  <br>
  <table width="95%" border="1" cellspacing="0" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
      <td height="23" colspan="7"> <div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif">SOLUCION 
          ANTICIPADA</font></strong></font></strong></font></strong></font></div>
        <div align="center"><font color="#FFFFFF"><strong></strong></font></div>
        <div align="center"><font color="#FFFFFF"><strong></strong></font></div></td>
    </tr>
    <tr bgcolor="#006699"> 
      <td width="17%" rowspan="2"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">DESDE</font></strong></font></div></td>
      <td width="26%" rowspan="2"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">HASTA</font></strong></font></div></td>
      <td width="7%" rowspan="2"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">Nro. 
          ORDENES</font></strong></font></div></td>
      <td height="23" colspan="4"> <div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif">TIEMPO 
          TRANCURRIDO</font></strong></font></strong></font></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td width="11%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">MAXIMO</font></strong></font></div></td>
      <td width="10%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">MINIMO</font></strong></font></div></td>
      <td width="11%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">PROMEDIO</font></strong></font></div></td>
      <td width="18%" bgcolor="#006699">&nbsp;</td>
    </tr>
    <?php
		$i=1;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		$tiempo_sol1="SELECT id_asig, to_days(fecha_sol) - to_days(b.fechaestsol_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.fechaestsol_asig>a.fecha_sol $var_cond5 $var2 GROUP BY b.id_orden ORDER BY num ASC";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			if($i==1) if($tiempo_sol1[num]) $max1=$tiempo_sol1[num];
			if($i==$num_cols1) if($tiempo_sol1[num]) $min1=$tiempo_sol1[num];
			$i++;
			$sol1_sum+=$tiempo_sol1[num];
		}
		if($num_cols1==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$num_cols1,2),2);
	?>
    <tr align="center"> 
      <td rowspan="2" valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
        ESTIMADA DE SOLUCION</strong></font></strong></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif">SOLUCION 
        - FECHA SISTEMA</font></strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $num_cols1;?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif">
	   <?php 
	  	$max1=abs($max1); echo $max1." dia(s) antes";
	   ?>
	   &nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif">
	   <?php 
	  	$min1=abs($min1); echo $min1." dia(s) antes";	  
	   ?>
	  &nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif">
	  <?php 
	  	$prom1=abs($prom1); echo $prom1." dia(s) antes";
	   ?>
	  &nbsp;</font></td>
      <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}
	  ?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=15 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
    <?php
		$i=1;
		$sol1_sum=0;
		$min1=0;
		$max1=0;
		$tiempo_sol1="SELECT to_days(fecha_sol_e) - to_days(b.fechaestsol_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.fechaestsol_asig>a.fecha_sol $var_cond3 $var2 GROUP BY b.id_orden ORDER BY num ASC";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			if($i==1) if($tiempo_sol1[num]) $max1=$tiempo_sol1[num];
			if($i==$num_cols1) if($tiempo_sol1[num]) $min1=$tiempo_sol1[num];
			$i++;
			$sol1_sum+=$tiempo_sol1[num];
		}
		if($num_cols1==0) {$prom1=0;}
		else {$prom1=number_format(round($sol1_sum/$num_cols1,2),2);}
		?>
    <tr align="center"> 
      <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOLUCION 
        - FECHA INTRODUCIDA</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $num_cols1;?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"> 
        <?php 
	  	$max1=abs($max1); 
		echo $max1." dia(s) antes";	  
	   ?>
        &nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif">
	    <?php 
	  	$min1=abs($min1); 
		echo $min1." dia(s) antes";	  
	  	?>
	  &nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif">
	  <?php 
	  	$prom1=abs($prom1); 
		echo $prom1." dia(s) antes";
	  	?>
	  &nbsp;</font></td>
      <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=16 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
    <?php
		$i=0;
		$max1=0;
		$min1=0;
		$sol1_sum=0;
		$prom1=0;
		$tiempo_sol1="SELECT id_asig,to_days(fecha_conf) - to_days(b.fecha_asig) AS num FROM conformidad a, asignacion b WHERE a.id_orden=b.id_orden $var_cond8 $var2 GROUP BY b.id_orden ORDER BY num DESC";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1)){
			if($i==1) $max1=$tiempo_sol1[num];
			if($i==$num_cols1) $min1=$tiempo_sol1[num];
			$i++;
			$sol1_sum+=$tiempo_sol1[num];
		}
		if($num_cols1==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$num_cols1,2),2);
	?>
  </table>
  <br>
  <table width="95%" border="1" cellspacing="0" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
      <td height="23" colspan="7"> <div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOLUCION 
          A TIEMPO O RETRASADA</strong></font></strong></font></font></strong></font></div>
        <div align="center"><font color="#FFFFFF"><strong></strong></font></div>
        <div align="center"><font color="#FFFFFF"><strong></strong></font></div></td>
    </tr>
    <tr bgcolor="#006699"> 
      <td width="17%" rowspan="2"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">DESDE</font></strong></font></div></td>
      <td width="26%" rowspan="2"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">HASTA</font></strong></font></div></td>
      <td width="7%" rowspan="2"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">Nro. 
          ORDENES</font></strong></font></div></td>
      <td height="23" colspan="4"> <div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif">TIEMPO 
          TRANCURRIDO</font></strong></font></strong></font></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td width="11%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">MAXIMO</font></strong></font></div></td>
      <td width="10%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">MINIMO</font></strong></font></div></td>
      <td width="11%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">PROMEDIO</font></strong></font></div></td>
      <td width="18%" bgcolor="#006699">&nbsp;</td>
    </tr>
    <?php
		$i=1;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		/*$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(fecha_sol) - to_days(b.fechaestsol_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.fechaestsol_asig<=a.fecha_sol AND b.id_asig=$tiempo_sol1[id_asig]";
			$res2=mysql_db_query($db,$tiempo_sol2,$link);
			$tiempo_sol2=mysql_fetch_array($res2);
			if($tiempo_sol2){echo "hola";}
		}*/
		$tiempo_sol1="SELECT to_days(fecha_sol) - to_days(b.fechaestsol_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.fechaestsol_asig<=a.fecha_sol $var_cond5 $var2 GROUP BY b.id_orden ORDER BY num ASC";
		echo $tiempo_sol1;
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			if($i==1) if($tiempo_sol1[num]) $max1=$tiempo_sol1[num];
			if($i==$num_cols1) if($tiempo_sol1[num]) $min1=$tiempo_sol1[num];
			$i++;
			$sol1_sum+=$tiempo_sol1[num];
		}
		if($num_cols1==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$num_cols1,2),2);
	?>
    <tr align="center"> 
      <td rowspan="2" valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
        ESTIMADA DE SOLUCION</strong></font></strong></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif">SOLUCION 
        - FECHA SISTEMA</font></strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $num_cols1;?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"> 
        <?php 
	  	$max1=abs($max1); echo $max1." dia(s) antes";
	   ?>
        &nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"> 
        <?php 
	  	$min1=abs($min1); echo $min1." dia(s) antes";	  
	   ?>
        &nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"> 
        <?php 
	  	$prom1=abs($prom1); echo $prom1." dia(s) antes";
	   ?>
        &nbsp;</font></td>
      <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}
	  ?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=15 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
    <?php
		$i=1;
		$sol1_sum=0;
		$min1=0;
		$max1=0;
		$tiempo_sol1="SELECT to_days(fecha_sol_e) - to_days(b.fechaestsol_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.fechaestsol_asig<=a.fecha_sol $var_cond3 $var2 GROUP BY b.id_orden ORDER BY num ASC";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			if($i==1) if($tiempo_sol1[num]) $max1=$tiempo_sol1[num];
			if($i==$num_cols1) if($tiempo_sol1[num]) $min1=$tiempo_sol1[num];
			$i++;
			$sol1_sum+=$tiempo_sol1[num];
		}
		if($num_cols1==0) {$prom1=0;}
		else {$prom1=number_format(round($sol1_sum/$num_cols1,2),2);}
		?>
    <tr align="center"> 
      <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOLUCION 
        - FECHA INTRODUCIDA</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $num_cols1;?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"> 
        <?php 
	  	$max1=abs($max1); 
		echo $max1." dia(s) antes";	  
	   ?>
        &nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"> 
        <?php 
	  	$min1=abs($min1); 
		echo $min1." dia(s) antes";	  
	  	?>
        &nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"> 
        <?php 
	  	$prom1=abs($prom1); 
		echo $prom1." dia(s) antes";
	  	?>
        &nbsp;</font></td>
      <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=16 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
    <?php
		$i=0;
		$max1=0;
		$min1=0;
		$sol1_sum=0;
		$prom1=0;
		$tiempo_sol1="SELECT to_days(fecha_conf) - to_days(b.fecha_asig) AS num FROM conformidad a, asignacion b WHERE a.id_orden=b.id_orden $var_cond8 $var2 GROUP BY b.id_orden ORDER BY num DESC";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1)){
			if($i==1) $max1=$tiempo_sol1[num];
			if($i==$num_cols1) $min1=$tiempo_sol1[num];
			$i++;
			$sol1_sum+=$tiempo_sol1[num];
		}
		if($num_cols1==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$num_cols1,2),2);
	?>
  </table>
</div>
<p align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif"><u>SOLUCION EJECUCION</u></font> 

<?php
$tiempo_sol2="SELECT to_days(fecha_sol_e) - to_days(b.fecha_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden $var_cond4 $var2 ORDER BY num DESC";
$res2=mysql_db_query($db,$tiempo_sol2,$link);
$num_cols2=mysql_num_rows($res2);
$i=1;
$sol2_sum=0;
$min2=0;
$max2=0;
while($tiempo_sol2=mysql_fetch_array($res2)){
	if($i==1) if($tiempo_sol2[num] && $tiempo_sol2[num]>0) $max2=$tiempo_sol2[num];
	if($i==$num_cols2) if($tiempo_sol2[num] && $tiempo_sol2[num]>0) $min2=$tiempo_sol2[num];
	$i++;
	$sol2_sum+=$tiempo_sol2[num];
}
if($num_cols2==0) $prom2=0;
else $prom2=number_format(round($sol2_sum/$num_cols2,2),2);
?>
  </strong></p>
<div align="center">
  <table width="50%" border="1" cellspacing="0">
    <tr bgcolor="#CCCCCC"> 
      <td colspan="4"> 
        <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif">TIEMPO 
          TRANCURRIDO (en dias)</font></strong></font> <strong></strong></div></td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;DESDE</font></strong></div></td>
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">MAXIMO</font></strong></div></td>
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">MINIMO</font></strong></div></td>
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">PROMEDIO</font></strong></div></td>
    </tr>
    <tr> 
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;EMISION 
          DE ORDEN </font></strong></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$max1?>&nbsp;
          </font></div></td>
      <td> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$min1?>&nbsp;
          </font></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$prom1?>&nbsp;
          </font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;ASIGNACION 
          DE ORDEN </font></strong></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$max2?>&nbsp;
          </font></div></td>
      <td> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$min2?>&nbsp;
          </font></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$prom2?>&nbsp;
          </font></div></td>
    </tr>
  </table>
</div>
<p align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif"><u>SOLUCION REGISTRO</u></font> 
  
<?php
$tiempo_sol2="SELECT to_days(fecha_sol) - to_days(b.fecha_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden $var_cond6 $var2 ORDER BY num DESC";
$res2=mysql_db_query($db,$tiempo_sol2,$link);
$num_cols2=mysql_num_rows($res2);
$i=1;
$sol2_sum=0;
$min2=0;
$max2=0;
while($tiempo_sol2=mysql_fetch_array($res2)){
	if($i==1) if($tiempo_sol2[num]) $max2=$tiempo_sol2[num];
	if($i==$num_cols2) if($tiempo_sol2[num]) $min2=$tiempo_sol2[num];
	$i++;
	$sol2_sum+=$tiempo_sol2[num];
}
if($num_cols2==0) $prom2=0;
else $prom2=number_format(round($sol2_sum/$num_cols2,2),2);
?>
  </strong></p>
<div align="center">
  <table width="50%" border="1" cellspacing="0">
    <tr bgcolor="#CCCCCC"> 
      <td colspan="4"> 
        <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif">TIEMPO 
          TRANCURRIDO (en dias)</font></strong></font> <strong></strong></div></td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;DESDE</font></strong></div></td>
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">MAXIMO</font></strong></div></td>
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">MINIMO</font></strong></div></td>
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">PROMEDIO</font></strong></div></td>
    </tr>
    <tr> 
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;EMISION 
          DE ORDEN </font></strong></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$max1?>&nbsp;
          </font></div></td>
      <td> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$min1?>&nbsp;
          </font></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$prom1?>&nbsp;
          </font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;ASIGNACION 
          DE ORDEN </font></strong></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$max2?>&nbsp;
          </font></div></td>
      <td> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$min2?>&nbsp;
          </font></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$prom2?>&nbsp;
          </font></div></td>
    </tr>
  </table>
</div>
<p align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif"><u>SOLUCION EJECUCION VS. REGISTRO</u>
<?php
$tiempo_sol1="SELECT to_days(a.fecha_sol) - to_days(a.fecha_sol_e) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden $var_cond7 $var2 ORDER BY num DESC";
$res1=mysql_db_query($db,$tiempo_sol1,$link);
$num_cols1=mysql_num_rows($res1);
$i=1;
$sol1_sum=0;
$min1=0;
$max1=0;
while($tiempo_sol1=mysql_fetch_array($res1)){
	if($i==1) if($tiempo_sol1[num]) $max1=$tiempo_sol1[num];
	if($i==$num_cols1) if($tiempo_sol1[num]) $min1=$tiempo_sol1[num];
	$i++;
	$sol1_sum+=$tiempo_sol1[num];
}
if($num_cols1==0) $prom1=0;
else $prom1=number_format(round($sol1_sum/$num_cols1,2),2);
?>
  </font> </strong></p>
<div align="center">
  <table width="50%" border="1" cellspacing="0">
    <tr bgcolor="#CCCCCC"> 
      <td colspan="4"> 
        <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif">TIEMPO 
          TRANCURRIDO (en dias)</font></strong></font> <strong></strong></div></td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;DESDE</font></strong></div></td>
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">MAXIMO</font></strong></div></td>
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">MINIMO</font></strong></div></td>
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">PROMEDIO</font></strong></div></td>
    </tr>
    <tr> 
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">INTERVALO ENTRE<br>
          EJECUCION Y REGISTRO</font></strong></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$max1?>&nbsp;
          </font></div></td>
      <td> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$min1?>&nbsp;
          </font></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$prom1?>&nbsp;
          </font></div></td>
    </tr>
  </table>
</div>
<p align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif"><u>CONFORMIDAD</u></font><font size="2" face="Arial, Helvetica, sans-serif"> 

  <?php
$tiempo_sol2="SELECT to_days(fecha_conf) - to_days(b.fecha_asig) AS num FROM conformidad a, asignacion b WHERE a.id_orden=b.id_orden $var_cond9 $var2 ORDER BY num DESC";
$res2=mysql_db_query($db,$tiempo_sol2,$link);
$num_cols2=mysql_num_rows($res2);
$i=1;
$sol2_sum=0;
while($tiempo_sol2=mysql_fetch_array($res2)){
	if($i==1) $max2=$tiempo_sol2[num];
	if($i==$num_cols2) $min2=$tiempo_sol2[num];
	$i++;
	$sol2_sum+=$tiempo_sol2[num];
}
if($num_cols2==0) $prom2=0;
else $prom2=number_format(round($sol2_sum/$num_cols2,2),2);
?>
  <?php
$tiempo_sol3="SELECT to_days(fecha_conf) - to_days(b.fecha_sol_e) AS num FROM conformidad a, solucion b, asignacion c WHERE a.id_orden=b.id_orden AND a.id_orden=c.id_orden $var_cond10 $var2 ORDER BY num DESC";
$res3=mysql_db_query($db,$tiempo_sol3,$link);
$num_cols3=mysql_num_rows($res3);
$i=1;
$sol3_sum=0;
while($tiempo_sol3=mysql_fetch_array($res3)){
	if($i==1) $max3=$tiempo_sol3[num];
	if($i==$num_cols3) $min3=$tiempo_sol3[num];
	$i++;
	$sol3_sum+=$tiempo_sol3[num];
}
if($num_cols3==0) $prom3=0;
else $prom3=number_format(round($sol3_sum/$num_cols3,2),2);
?>
<?php
$tiempo_sol4="SELECT to_days(fecha_conf) - to_days(b.fecha_sol) AS num FROM conformidad a, solucion b, asignacion c WHERE a.id_orden=b.id_orden AND a.id_orden=c.id_orden $var_cond11 $var2 ORDER BY num DESC";
$res4=mysql_db_query($db,$tiempo_sol4,$link); 
$num_cols4=mysql_num_rows($res4);
$i=1;
$sol4_sum=0;
$max3=0;
$min3=0;
$max4=0;
$min4=0;
while($tiempo_sol4=mysql_fetch_array($res4)){
	if($i==1) $max4=$tiempo_sol4[num];
	if($i==$num_cols4) $min4=$tiempo_sol4[num];
	$i++;
	$sol4_sum+=$tiempo_sol4[num];
}
if($num_cols4==0) $prom4=0;
else $prom4=number_format(round($sol4_sum/$num_cols4,2),2);
?>
  </font> </strong></p>
<div align="center">
  <table width="50%" border="1" cellspacing="0">
    <tr bgcolor="#CCCCCC"> 
      <td colspan="4"> 
        <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif">TIEMPO 
          TRANCURRIDO (en dias)</font></strong></font> <strong></strong></div></td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;DESDE</font></strong></div></td>
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">MAXIMO</font></strong></div></td>
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">MINIMO</font></strong></div></td>
      <td> 
        <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">PROMEDIO</font></strong></div></td>
    </tr>
    <tr> 
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;EMISION 
          DE ORDEN </font></strong></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$max1?>&nbsp;
          </font></div></td>
      <td> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$min1?>&nbsp;
          </font></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$prom1?>&nbsp;
          </font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;ASIGNACION 
          DE ORDEN </font></strong></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$max2?>&nbsp;
          </font></div></td>
      <td> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$min2?>&nbsp;
          </font></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$prom2?>&nbsp;
          </font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;SOLUCION 
          - EJECUCION</font></strong></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$max3?>&nbsp;
          </font></div></td>
      <td> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$min3?>&nbsp;
          </font></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$prom3?>&nbsp;
          </font></div></td>
    </tr>
	<tr> 
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;SOLUCION 
          - REGISTRO</font></strong></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$max4?>&nbsp;
          </font></div></td>
      <td> <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$min4?>&nbsp;
          </font></div></td>
      <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php=$prom4?>&nbsp;
          </font></div></td>
    </tr>
  </table>
</div>
<p align="left">&nbsp;</p>
