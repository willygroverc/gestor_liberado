<?php
include("datos_gral.php");
include("conexion.php");
if (isset($_REQUEST['menu']) == 'ASIGNADO') {
      if(isset($_REQUEST['nombre'])==null){
                 $var2 = "";
                 
        }else{
    $var2 = " AND asig='$_REQUEST[nombre]'";}
}
if(isset($_REQUEST['DA'])){
        if(isset($_REQUEST['nombre'])==null){
            $var2='';
        }else{$var2=" AND asig='$_REQUEST[nombre]'";}
        
	if (strlen($_REQUEST['DA']) == 1){ $_REQUEST['DA'] = "0".$_REQUEST['DA']; }
	if (strlen($_REQUEST['MA']) == 1){ $_REQUEST['MA'] = "0".$_REQUEST['MA']; }	 	 
    $fec1 = $_REQUEST['AA']."-".$_REQUEST['MA']."-".$_REQUEST['DA'];   
	if (strlen($_REQUEST['DE']) == 1){ $_REQUEST['DE'] = "0".$_REQUEST['DE']; }
	if (strlen($_REQUEST['ME']) == 1){ $_REQUEST['ME'] = "0".$_REQUEST['ME']; }
	$fec2 = $_REQUEST['AE']."-".$_REQUEST['ME']."-".$_REQUEST['DE']; 
        
        $var_cond_o1=" AND a.fecha_asig BETWEEN '$fec1' AND '$fec2' AND b.fecha BETWEEN '$fec1' AND '$fec2'";
	$var_cond_o2=" AND a.fecha BETWEEN '$fec1' AND '$fec2' AND c.fecha_sol BETWEEN '$fec1' AND '$fec2'";
	$var_cond_o3=" AND a.fecha BETWEEN '$fec1' AND '$fec2' AND c.fecha_sol_e BETWEEN '$fec1' AND '$fec2'";
	$var_cond_o4=" AND a.fecha BETWEEN '$fec1' AND '$fec2' AND c.fecha_conf BETWEEN '$fec1' AND '$fec2'";
	
	$var_cond_a1=" AND a.fecha_sol BETWEEN '$fec1' AND '$fec2' AND b.fecha_asig BETWEEN '$fec1' AND '$fec2'";
	$var_cond_a2=" AND a.fecha_sol_e BETWEEN '$fec1' AND '$fec2' AND b.fecha_asig BETWEEN '$fec1' AND '$fec2'";
	$var_cond_a3=" AND a.fecha_conf BETWEEN '$fec1' AND '$fec2' AND b.fecha_asig BETWEEN '$fec1' AND '$fec2'";
	
	$var_cond_s1=" AND a.fecha_sol BETWEEN '$fec1' AND '$fec2' AND b.fechaestsol_asig BETWEEN '$fec1' AND '$fec2'";
	$var_cond_s2=" AND a.fecha_sol_e BETWEEN '$fec1' AND '$fec2' AND b.fechaestsol_asig BETWEEN '$fec1' AND '$fec2'";
	
	$var_cond_s3=" AND c.fecha_sol BETWEEN '$fec1' AND '$fec2' AND c.fecha_sol_e BETWEEN '$fec1' AND '$fec2'";
	$var_cond_s4=" AND a.fecha_conf BETWEEN '$fec1' AND '$fec2' AND c.fecha_sol BETWEEN '$fec1' AND '$fec2'";
	$var_cond_s5=" AND a.fecha_conf BETWEEN '$fec1' AND '$fec2' AND c.fecha_sol_e BETWEEN '$fec1' AND '$fec2'";
}
?>
<title>REPORTE POR TIEMPOS</title>
<font size="el burr"></font>
<table width="70%">
<tr>
<?php 
if(isset($_REQUEST['menu']))
{
    if(isset($_REQUEST['nombre'])==null){
        
    }  else {
        
    	$sql_us="SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$_REQUEST[nombre]'";
	$result_us=mysql_db_query($db,$sql_us,$link);
	$row_us=mysql_fetch_array($result_us);
	echo "<td width=\"26%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>&nbsp;&nbsp;&nbsp;Reporte:</strong></font></td>";
	echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Asignado a $row_us[nom_usr] $row_us[apa_usr] $row_us[ama_usr]</font></td>";
}}

else 
{
	echo "<td width=\"26%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>&nbsp;&nbsp;&nbsp;Reporte:</strong></font></td>";
	echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">GENERAL</font></td>";
}
if(isset($_REQUEST['DA']))
{
	echo "<tr>";
	echo "<td width=\"26%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>&nbsp;&nbsp;&nbsp;Entre Fechas:</strong></font></td>";
	echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Del:".$_REQUEST['DA']."/".$_REQUEST['MA']."/".$_REQUEST['AA']."&nbsp;&nbsp;&nbsp;Al:".$_REQUEST['DE']."/".$_REQUEST['ME']."/".$_REQUEST['AE']."</font></td>";
	echo "</tr>";
}
else {echo "<tr>";}
?>
</table>
<p align="center"><strong><font face="Arial, Helvetica, sans-serif"><u>TIEMPOS DE EJECUCION DE ORDENES</u></font></strong></p>
<div align="center"> </div>
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
		$i=0;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		if(isset($_REQUEST['menu'])){$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
		else{$tiempo_sol1="SELECT DISTINCT(id_orden), MIN(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
                if(isset($var_cond_o1)==null){
                    $var_cond_o1='';
                }
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(fecha_asig) - to_days(b.fecha) AS num FROM asignacion a, ordenes b WHERE a.id_orden=b.id_orden AND a.id_asig="."$tiempo_sol1[id_asig]".$var_cond_o1.$var2;
			//print_r($tiempo_sol2);
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
	?>
	<tr align="center"> 
      <td rowspan="4" valign="top"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;INGRESO 
          DE ORDEN </font></strong></div></td>
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ASIGNACION</font></strong></div></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $max1." dia(s)";?>&nbsp;</font></div></td>
      <td><div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"><?php echo $min1." dia(s)";?>&nbsp;</font></div></td>
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $prom1." dia(s)";?>&nbsp;</font></div></td>
	  <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=15 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
    
	 <?php
		$i=0;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		if(isset($_REQUEST['menu'])){$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
		else{$tiempo_sol1="SELECT DISTINCT(id_orden), MIN(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
                if(isset($var_cond_o2)==null){
                    $var_cond_o2='';
                }
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(c.fecha_sol) - to_days(a.fecha) AS num FROM ordenes a, solucion c, asignacion b WHERE a.id_orden=c.id_orden AND b.id_asig=".$tiempo_sol1['id_asig'].' '. 'AND c.id_orden='.$tiempo_sol1['id_orden'].$var_cond_o2.$var2;
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
	?>
    <tr align="center"> 
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
		if(isset($_REQUEST['menu'])){$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
		else{$tiempo_sol1="SELECT DISTINCT(id_orden), MIN(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
                if(isset($var_cond_o3)==null){
                    $var_cond_o3='';
                }
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(c.fecha_sol_e) - to_days(a.fecha) AS num FROM ordenes a, solucion c, asignacion b WHERE a.id_orden=c.id_orden AND b.id_asig=".$tiempo_sol1['id_asig'].' '.'AND c.id_orden='.$tiempo_sol1['id_orden'].$var_cond_o3.$var2;
			//print_r($tiempo_sol2);
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
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
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		if(isset($_REQUEST['menu'])){$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
		else{$tiempo_sol1="SELECT DISTINCT(id_orden), MIN(id_asig) as id_asig FROM asignacion GROUP BY id_orden";}
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
                $var_cond_o4='';
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(c.fecha_conf) - to_days(a.fecha) AS num FROM ordenes a, conformidad c, asignacion b WHERE a.id_orden=c.id_orden AND b.id_asig=$tiempo_sol1[id_asig] AND c.id_orden=$tiempo_sol1[id_orden] $var_cond_o4 $var2";
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
	?>
   
   
    <?php
		/*$i=1;
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
		else $prom1=number_format(round($sol1_sum/$num_cols1,2),2);*/
	?>
    <tr align="center"> 
      <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CONFORMIDAD</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
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
                $var_cond_a1='';
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(fecha_sol) - to_days(b.fecha_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.id_asig=$tiempo_sol1[id_asig] $var_cond_a1 $var2";
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
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
                if(isset($var_cond_a2)==null){
                    $var_cond_a2='';
                }
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(fecha_sol_e) - to_days(b.fecha_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.id_asig=$tiempo_sol1[id_asig] $var_cond_a2 $var2";
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
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
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
                if(isset($var_cond_a3)==null){
                    $var_cond_a3='';
                }
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(fecha_conf) - to_days(b.fecha_asig) AS num FROM conformidad a, asignacion b WHERE a.id_orden=b.id_orden AND b.id_asig=$tiempo_sol1[id_asig] $var_cond_a3 $var2";
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
	?>
	<tr align="center"> 
      <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CONFORMIDAD</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
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
      <td width="25%" rowspan="2"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">HASTA</font></strong></font></div></td>
      <td width="7%" rowspan="2"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">Nro. 
          ORDENES</font></strong></font></div></td>
      <td height="23" colspan="4"> <div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif">TIEMPO 
          TRANCURRIDO</font></strong></font></strong></font></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr bgcolor="#CCCCCC"> 
      <td width="11%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">MAXIMO</font></strong></font></div></td>
      <td width="11%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">MINIMO</font></strong></font></div></td>
      <td width="11%" bgcolor="#006699"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">PROMEDIO</font></strong></font></div></td>
      <td width="18%" bgcolor="#006699">&nbsp;</td>
    </tr>
     <?php
		$i=0;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
                if(isset($var_cond_s1)==null){
                    $var_cond_s1='';
                }
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
	?>
	<tr align="center"> 
      <td rowspan="2" valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
        ESTIMADA DE SOLUCION</strong></font></strong></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif">SOLUCION 
        - FECHA SISTEMA</font></strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
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
		$i=0;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
                if(isset($var_cond_s2)==null){
                    $var_cond_s2='';
                }
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
	?>
	<tr align="center"> 
      <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOLUCION 
        - FECHA INTRODUCIDA</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
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
  </table>
  <br>
  <table width="95%" border="1" cellspacing="0" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
      <td colspan="4"> <div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOLUCION 
          A TIEMPO</strong></font></strong></font></font></strong></font></div>
        <div align="center"><font color="#FFFFFF"><strong></strong></font></div>
        <div align="center"><font color="#FFFFFF"><strong></strong></font></div></td>
    </tr>
    <tr bgcolor="#006699"> 
      <td width="26%"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">DESDE</font></strong></font></div></td>
      <td width="28%"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">HASTA</font></strong></font></div></td>
      <td width="17%"><div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">Nro. 
          ORDENES</font></strong></font></div></td>
      <td width="29%"> <div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<font color="#FFFFFF"><strong>PORCENTAJE</strong></font></font></strong></font></div>
        <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
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
			$tiempo_sol2="SELECT to_days(fecha_sol) - to_days(b.fechaestsol_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.fechaestsol_asig=a.fecha_sol AND b.id_asig=$tiempo_sol1[id_asig] $var_cond_s1 $var2";
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
	?>
    <tr align="center"> 
      <td rowspan="2" valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA ESTIMADA DE SOLUCION</strong></font></strong></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOLUCION - FECHA SISTEMA</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
      <td bgcolor="#006699" align="left"><?php 
		  $sql_tot="SELECT * FROM solucion";
		  $result_tot=mysql_db_query($db,$sql_tot,$link);
		  $row_tot=mysql_num_rows($result_tot);
		  if($row_tot<>0){$porc=($i*100)/$row_tot;}
		  else{$porc=0;}
		  echo "<img height=15 width=$porc% src=images/barra.jpg>"; 
	  ?></td>
    </tr>
    <?php
		$i=0;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
                if(isset($var_cond_s2)==null){
                    $var_cond_s2='';
                }
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(fecha_sol_e) - to_days(b.fechaestsol_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.fechaestsol_asig=a.fecha_sol_e AND b.id_asig=$tiempo_sol1[id_asig] $var_cond_s2 $var2";
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
	?>
    <tr align="center"> 
      <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOLUCION - FECHA INTRODUCIDA</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
      <td bgcolor="#006699" align="left"><?php 
		  $sql_tot="SELECT * FROM solucion";
		  $result_tot=mysql_db_query($db,$sql_tot,$link);
		  $row_tot=mysql_num_rows($result_tot);
		  if($row_tot<>0){$porc=($i*100)/$row_tot;}
		  else{$porc=0;}
		  echo "<img height=15 width=$porc% src=images/barra.jpg>"; 
	  ?></td>
      
    </tr>
  </table>
  <br>
  <table width="95%" border="1" cellspacing="0" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
      <td height="23" colspan="7"> <div align="center"><font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<font color="#FFFFFF"><strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOLUCION 
          RETRASADA</strong></font></strong></font></font></strong></font></div>
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
		$i=0;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(fecha_sol) - to_days(b.fechaestsol_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.fechaestsol_asig<a.fecha_sol AND b.id_asig=$tiempo_sol1[id_asig] $var_cond_s1 $var2";
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
	?>
    <tr align="center"> 
      <td rowspan="2" valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
        ESTIMADA DE SOLUCION</strong></font></strong></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif">SOLUCION 
        - FECHA SISTEMA</font></strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif">
        <?php	echo $max1." dia(s)";?>
        &nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $min1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $prom1." dia(s)";?>&nbsp;</font></td>
      <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}
	  ?>
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
			$tiempo_sol2="SELECT to_days(fecha_sol_e) - to_days(b.fechaestsol_asig) AS num FROM solucion a, asignacion b WHERE a.id_orden=b.id_orden AND b.fechaestsol_asig<a.fecha_sol_e AND b.id_asig=$tiempo_sol1[id_asig] $var_cond_s2 $var2";
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
	?>
    <tr align="center"> 
      <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOLUCION 
        - FECHA INTRODUCIDA</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
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
                 if(isset($var_cond_s3)==null){
                    $var_cond_s3='';
                }
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(c.fecha_sol) - to_days(c.fecha_sol_e) AS num FROM solucion c, asignacion b WHERE b.id_asig=$tiempo_sol1[id_asig] AND c.id_orden=$tiempo_sol1[id_orden] $var_cond_s3 $var2";
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
	?>
	<tr align="center"> 
      <td rowspan="2" valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif">SOLUCION 
        - FECHA SISTEMA</font></strong></td>
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
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
                 if(isset($var_cond_s4)==null){
                    $var_cond_s4='';
                }
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(a.fecha_conf) - to_days(c.fecha_sol) AS num FROM solucion c, conformidad a, asignacion b WHERE c.id_orden=a.id_orden AND b.id_asig=$tiempo_sol1[id_asig] AND c.id_orden=$tiempo_sol1[id_orden] $var_cond_s4 $var2";
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
	?>
	<tr align="center"> 
      <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CONFORMIDAD</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
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
			$tiempo_sol2="SELECT to_days(c.fecha_sol) - to_days(c.fecha_sol_e) AS num FROM solucion c, asignacion b WHERE b.id_asig=$tiempo_sol1[id_asig] AND c.id_orden=$tiempo_sol1[id_orden] $var_cond_s3 $var2";
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
	?>
	<tr align="center"> 
      <td rowspan="2" valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOLUCION 
        - FECHA INTRODUCIDA</strong></font></strong></td>
      <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif">SOLUCION 
        - FECHA SISTEMA</font></strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $max1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $min1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $prom1." dia(s)";?>&nbsp;</font></td>
      <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=16 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
    <?php
		$i=0;
		$sol1_sum=0;
		$max1=0;
		$min1=0;
		$tiempo_sol1="SELECT DISTINCT(id_orden), MAX(id_asig) as id_asig FROM asignacion GROUP BY id_orden";
		$res1=mysql_db_query($db,$tiempo_sol1,$link);
		$num_cols1=mysql_num_rows($res1);
                 if(isset($var_cond_s5)==null){
                    $var_cond_s5='';
                }
		while($tiempo_sol1=mysql_fetch_array($res1))
		{
			$tiempo_sol2="SELECT to_days(a.fecha_conf) - to_days(c.fecha_sol_e) AS num FROM solucion c, conformidad a, asignacion b WHERE c.id_orden=a.id_orden AND b.id_asig=$tiempo_sol1[id_asig] AND c.id_orden=$tiempo_sol1[id_orden] $var_cond_s5 $var2";
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
					if($tiempo_sol2['num']>$max1){$max1=$tiempo_sol2['num'];}
					if($tiempo_sol2['num']<$min1){$min1=$tiempo_sol2['num'];}
				}
				$i++;
				$sol1_sum+=$tiempo_sol2['num'];
			}
		}
		if($i==0) $prom1=0;
		else $prom1=number_format(round($sol1_sum/$i,2),2);
	?>
    <tr align="center"> 
      <td height="22"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CONFORMIDAD</strong></font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $i;?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $max1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $min1." dia(s)";?>&nbsp;</font></td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $prom1." dia(s)";?>&nbsp;</font></td>
      <?php if($max1<>0){$porc=($prom1*100)/$max1;} else{$porc=0;}?>
      <td bgcolor="#006699" align="left"><?php echo "<img height=15 width=$porc% src=images/barra.jpg>"; ?></td>
    </tr>
  </table>
  
</div>
<p align="left">&nbsp;</p>
