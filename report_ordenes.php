<script language="javascript">
function procesos(area, filtro1, id, f1, f2, tipo){
	window.open("report_ordenes_pro.php?a="+area+"&f="+filtro1+"&id="+id+"&f1="+f1+"&f2="+f2+"&t="+tipo, "", 'width=900,height=500,status=no,resizable=yes,top=150,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=yes');
}
function procesos_asig(area, filtro1, id, f1, f2, tipo){
	window.open("report_ordenes_pro_asig.php?a="+area+"&f="+filtro1+"&id="+id+"&f1="+f1+"&f2="+f2+"&t="+tipo, "", 'width=900,height=500,status=no,resizable=yes,top=150,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=yes');
}
</script>
<?php
$id_agencia=$_GET['id_agencia'];
$id_area=$_GET['id_area'];
$nom_area=$_GET['nom_area'];
$filtro1=$_GET['filtro1']; //
$nom_filtro1=$_GET['nom_filtro1'];
$id_nombre=$_GET['id_nombre']; //
$nombre=$_GET['nombre']; //
$fecha1=$_GET['fecha1'];
$fecha2=$_GET['fecha2'];

$fecha1=substr($fecha1,6,4).'-'.substr($fecha1,3,2).'-'.substr($fecha1,0,2);
$fecha2=substr($fecha2,6,4).'-'.substr($fecha2,3,2).'-'.substr($fecha2,0,2);
require ("conexion.php");
echo '<link rel="stylesheet" type="text/css" href="css/style.css"/>';

// NUMERO DE ORDENES TOTALES SEGUN PARAMETROS ENVIADOS //
$cond="";
$cond_total="";

if ($id_agencia!=0){
	$cond.=" and u.adicional1='$id_agencia'";
	$cond_total.=" and u.adicional1='$id_agencia'";	
}
if ($id_area!=0){
	$cond.=" AND u.area_usr='$id_area'";
	$cond_total.=" AND u.area_usr='$id_area'";
}

if ($filtro1==1 || $filtro1==2){ // ENVIADOS POR TECNICO || ENVIADOS POR CLIENTE
	if($id_nombre!='0')
		$cond.=" AND o.cod_usr='$id_nombre'";
	else{
		if ($filtro1==1){
			$cond.=" AND u.tipo2_usr='T'";
			$cond_total.=" AND u.tipo2_usr='T'";
		}
		if ($filtro1==2){
			$cond.=" AND u.tipo2_usr='C'";
			$cond_total.=" AND u.tipo2_usr='C'";
		}
	}
}

//____________________________________________________________//
// TOTAL DE ORDENES //

$sql_total="SELECT count(o.id_orden) as total FROM ordenes o LEFT JOIN users u ON o.cod_usr=u.login_usr
			WHERE '1'='1' $cond_total AND o.fecha BETWEEN '$fecha1' AND '$fecha2'";
$recordset=mysql_query($sql_total);
$fila=mysql_fetch_array($recordset);
$total=$fila['total'];

if ($total!=0){
	//____________________________________________________________//
	//  ASIGNADAS - NO ASIGNADAS //
	$sql_asig="SELECT count(o.id_orden) as nro FROM ordenes o 
				LEFT JOIN users u ON o.cod_usr=u.login_usr
				WHERE o.id_orden IN (SELECT a.id_orden FROM asignacion a) $cond AND o.fecha BETWEEN '$fecha1' AND '$fecha2'";

	$recordset=mysql_query($sql_asig);
	$fila=mysql_fetch_array($recordset);
	$num_asig=$fila['nro'];

	if ($total!=0){
		$porc_asig=number_format(($num_asig*100)/$total,2);
	}
	else
		$porc_asig=0;
	//___________________________________________________________
		
	//  ESCALADAS - NO ESCALADAS //
	$sql_escal="SELECT count(o.id_orden) as nro FROM ordenes o 
				LEFT JOIN users u ON o.cod_usr=u.login_usr
				WHERE o.id_orden IN (SELECT a.id_orden FROM asignacion a WHERE a.escal<>'0') $cond AND o.fecha BETWEEN '$fecha1' AND '$fecha2'";
	$recordset=mysql_query($sql_escal);
	$fila=mysql_fetch_array($recordset);
	$num_escal=$fila['nro'];
	if ($total!=0){
		$porc_escal=number_format(($num_escal*100)/$total,2);
	}
	else
		$porc_escal=0;
	//___________________________________________________________

	//  CON SEGUIMIENTO - SIN SEGUIMIENTO //
	$sql_segui="SELECT o.id_orden as nro FROM ordenes o 
				LEFT JOIN users u ON o.cod_usr=u.login_usr
				INNER JOIN seguimiento s ON o.id_orden=s.id_orden
				WHERE 1=1 $cond AND o.fecha BETWEEN '$fecha1' AND '$fecha2' GROUP BY o.id_orden";
	//echo $sql_segui;
	$recordset=mysql_query($sql_segui);
	$num_segui=mysql_num_rows($recordset);

	if ($total!=0){
		$porc_segui=number_format(($num_segui*100)/$total,2);
	}
	else
		$porc_segui=0;
	//___________________________________________________________

	//  CON SOLUCION - SIN SOLUCION //
	$sql_solu="SELECT count(o.id_orden) as nro FROM ordenes o 
				LEFT JOIN users u ON o.cod_usr=u.login_usr
				WHERE o.id_orden IN (SELECT s.id_orden FROM solucion s) $cond AND o.fecha BETWEEN '$fecha1' AND '$fecha2'";
	$recordset=mysql_query($sql_solu);
	$fila=mysql_fetch_array($recordset);
	$num_solu=$fila['nro'];
	if ($total!=0){
		$porc_solu=number_format(($num_solu*100)/$total,2);
	}
	else
		$porc_solu=0;
	//___________________________________________________________

	//  CON CONFORMIDAD - SIN CONFORMIDAD //
	$sql_conf="SELECT count(o.id_orden) as nro FROM ordenes o 
				LEFT JOIN users u ON o.cod_usr=u.login_usr
				WHERE o.id_orden IN (SELECT c.id_orden FROM conformidad c) $cond AND o.fecha BETWEEN '$fecha1' AND '$fecha2'";
	$recordset=mysql_query($sql_conf);
	$fila=mysql_fetch_array($recordset);
	$num_conf=$fila['nro'];
	if ($total!=0){
		$porc_conf=number_format(($num_conf*100)/$total,2);
	}
	else
		$porc_conf=0;
	//___________________________________________________________

	//  CONFORMES - DISCONFORMES //
	$sql_conf1="SELECT o.id_orden as nro FROM ordenes o 
				LEFT JOIN users u ON o.cod_usr=u.login_usr
				INNER JOIN conformidad c ON o.id_orden=c.id_orden
				WHERE c.tipo_conf=1 $cond AND o.fecha BETWEEN '$fecha1' AND '$fecha2' GROUP BY o.id_orden";
	$recordset=mysql_query($sql_conf1);
	$num_conf1=mysql_num_rows($recordset);
	if ($total!=0){
		$porc_conf1=number_format(($num_conf1*100)/$total,2);
	}
	else
		$porc_conf1=0;
	//___________________________________________________________
	//  CON COSTO - SIN COSTO //
	$sql_costo="SELECT count(o.id_orden) as nro FROM ordenes o 
				LEFT JOIN users u ON o.cod_usr=u.login_usr
				WHERE u.costo_usr>0 $cond AND o.fecha BETWEEN '$fecha1' AND '$fecha2'";
	$recordset=mysql_query($sql_costo);
	$fila=mysql_fetch_array($recordset);
	$num_costo=$fila['nro'];
	if ($total!=0){
		$porc_costo=number_format(($num_costo*100)/$total,2);
	}
	else
		$porc_costo=0;
	//___________________________________________________________
	//  ANIDADAS - SIN ANIDACION //
	$sql_anid="SELECT o.id_orden as nro FROM ordenes o 
				LEFT JOIN users u ON o.cod_usr=u.login_usr
				WHERE o.id_anidacion<>0 $cond AND o.fecha BETWEEN '$fecha1' AND '$fecha2' GROUP BY o.id_orden";

	$recordset=mysql_query($sql_anid);
	$num_anid=mysql_num_rows($recordset);
	if ($total!=0){
		$porc_anid=number_format(($num_anid*100)/$total,2);
	}
	else
		$porc_anid=0;
	//___________________________________________________________
	//  TIPIFICADAS NIVEL 1 //
	$sql_tipi1="SELECT count(o.id_orden) as nro FROM ordenes o 
				LEFT JOIN users u ON o.cod_usr=u.login_usr
				WHERE o.area <> 0 $cond AND o.fecha BETWEEN '$fecha1' AND '$fecha2'";

	$recordset=mysql_query($sql_tipi1);
	$fila=mysql_fetch_array($recordset);
	$num_tipi1=$fila['nro'];

	if ($total!=0){
		$porc_tipi1=number_format(($num_tipi1*100)/$total,2);
	}
	else
		$porc_tipi1=0;
	//___________________________________________________________

	//  TIPIFICADAS NIVEL 2 //
	$sql_tipi2="SELECT count(o.id_orden) as nro FROM ordenes o 
				LEFT JOIN users u ON o.cod_usr=u.login_usr
				WHERE o.area <> 0 AND o.dominio <> 0 $cond AND o.fecha BETWEEN '$fecha1' AND '$fecha2'";

	$recordset=mysql_query($sql_tipi2);
	$fila=mysql_fetch_array($recordset);
	$num_tipi2=$fila['nro'];

	if ($total!=0){
		$porc_tipi2=number_format(($num_tipi2*100)/$total,2);
	}
	else
		$porc_tipi2=0;
	//___________________________________________________________
	//  TIPIFICADAS NIVEL 3 //
	$sql_tipi3="SELECT count(o.id_orden) as nro FROM ordenes o 
				LEFT JOIN users u ON o.cod_usr=u.login_usr
				WHERE o.area <> 0 AND o.dominio <> 0 AND o.objetivo <> 0 $cond AND o.fecha BETWEEN '$fecha1' AND '$fecha2'";
	$recordset=mysql_query($sql_tipi3);
	$fila=mysql_fetch_array($recordset);
	$num_tipi3=$fila['nro'];

	if ($total!=0){
		$porc_tipi3=number_format(($num_tipi3*100)/$total,2);
	}
	else
		$porc_tipi3=0;
	//___________________________________________________________
}
else{
$num_asig=0;$porc_asig=0;
$num_escal=0;$porc_escal=0;
$num_segui=0;$porc_segui=0;
$num_solu=0;$porc_solu=0;
$num_conf=0;$porc_conf=0;
$num_conf1=0;$porc_conf1=0;
$num_costo=0;$porc_costo=0;
$num_anid=0;$porc_anid=0;
$num_tipi1=0;$porc_tipi1=0;
$num_tipi2=0;$porc_tipi2=0;
$num_tipi3=0;$porc_tipi3=0;
}
?>

<table width="90%" border="1" align="center"  background="images/fondo.jpg">
<tr><th bgcolor="#006699" colspan="4" align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">ESTADISTICAS DE ORDENES DE TRABAJO DEL 
<?php 
$fecha1_lbl=substr($fecha1,8,2).'/'.substr($fecha1,5,2).'/'.substr($fecha1,0,4);
$fecha2_lbl=substr($fecha2,8,2).'/'.substr($fecha2,5,2).'/'.substr($fecha2,0,4);

echo $fecha1_lbl.' AL '.$fecha2_lbl;?></font></th></tr>
<tr>
	<th bgcolor="#006699" colspan="4" align="center">
		<font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">
                AGENCIA:<?php echo isset($nom_agencia);?>&nbsp;&nbsp;&nbsp;&nbsp; 
		AREA:<?php echo $nom_area;?>
		</font>
	</th>
</tr>
<?php 
	if($filtro1!=0)
		echo '<tr><th bgcolor="#006699" colspan="4" align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">'.$nom_filtro1.':'.$nombre.'</font></th></tr>';
?>
  <tr> 
    <td> 
      <table border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr align="center"> 
          <th width="237" bgcolor="#006699"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">ORDENES DE TRABAJO</font></th>
          <th width="97" bgcolor="#006699" align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">CANTIDAD</font></th>
          <th width="100" bgcolor="#006699" align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">%</font></th>
          <th width="145" bgcolor="#006699"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Asignadas</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','1'" ?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $num_asig;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $porc_asig;?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.$porc_asig.'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;No Asignadas</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','2'" ?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $total-$num_asig;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo number_format(100-$porc_asig,2);?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.(100-$porc_asig).'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Escaladas</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','3'" ?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $num_escal;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $porc_escal;?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.$porc_escal.'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;No Escaladas</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','4'" ?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $total-$num_escal;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo number_format(100-$porc_escal,2);?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.(100-$porc_escal).'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Con Seguimiento</font></td>
          <td width="97" align="center" ><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','5'" ?>);"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $num_segui;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $porc_segui;?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.$porc_segui.'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin Seguimiento</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','6'" ?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $total-$num_segui;?></u></font></a></td>
          <td width="100"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo number_format(100-$porc_segui,2);?>%</font></div></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.(100-$porc_segui).'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Con Solucion</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','7'" ?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $num_solu;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $porc_solu;?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.$porc_solu.'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin Solucion</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','8'" ?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $total-$num_solu;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo number_format(100-$porc_solu,2);?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.(100-$porc_solu).'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Con Conformidad</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','9'" ?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $num_conf;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $porc_conf;?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.$porc_conf.'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin Conformidad</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','10'";?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $total-$num_conf;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo number_format(100-$porc_conf,2);?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.(100-$porc_conf).'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;</font></td>
          <td width="97" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td width="100" div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td nowrap width="145" >&nbsp;</td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Conformidad</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','11'";?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $num_conf1;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $porc_conf1;?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.$porc_conf1.'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Disconformidad</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','12'";?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $num_conf-$num_conf1;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo number_format($porc_conf-$porc_conf1,2);?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.($porc_conf-$porc_conf1).'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Con Costo</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','13'";?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $num_costo;?></u></font></a></td>
          <td width="100"align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $porc_costo;?>%</font></td>
		  <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.$porc_costo.'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin Costo</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','14'";?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $total-$num_costo;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo number_format(100-$porc_costo,2);?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.(100-$porc_costo).'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr><td height="10">&nbsp;</td><td height="10">&nbsp;</td><td height="10">&nbsp;</td><td height="10"></td></tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Anidadas</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','15'";?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $num_anid;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $porc_anid;?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.$porc_anid.'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td width="237" align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin Anidar</font></td>
          <td width="97" align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','16'";?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $total-$num_anid;?></u></font></a></td>
          <td width="100" align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo number_format(100-$porc_anid,2);?>%</font></td>
          <td nowrap width="145" bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.(100-$porc_anid).'%" SRC="images/barra.jpg">';?></td>
        </tr>
        
		<tr> 
          <td height="10"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10"></td>
        </tr>
		<!---->
		<tr> 
          <td align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Tipificadas de Nivel 1</font></td>
		  <td align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','26'";?>)"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $num_tipi1?></u></font></a></td>
          <td div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $porc_tipi1;?></font>%</td>
          <td nowrap bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.$porc_tipi1.'%" SRC="images/barra.jpg">';?></td>
        </tr>		
		<tr> 
          <td align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Tipificadas de Nivel 2</font></td>
		  <td align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','27'";?>);"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $num_tipi2;?></u></font></a></td>
          <td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $porc_tipi2;?></font>%</td>
          <td nowrap bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.$porc_tipi2.'%" SRC="images/barra.jpg">';?></td>
        </tr>		
		<tr> 
          <td align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Tipificadas de Nivel 3</font></td>
		  <td align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','28'";?>);"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $num_tipi3?></u></font></a></td>
          <td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $porc_tipi3?></font>%</td>
          <td nowrap bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.$porc_tipi3.'%" SRC="images/barra.jpg">';?></td>
        </tr>
		<tr> 
          <td align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sin Tipificaci&oacute;n</font></td>
		  <td align="center"><a href="javascript:procesos(<?php echo "'".$id_area."','".$filtro1."','".$id_nombre."','".$fecha1."','".$fecha2."','29'";?>);"><font size="2" face="Arial, Helvetica, sans-serif" color="#0000FF">&nbsp;<u><?php echo $total-$num_tipi1?></u></font></a></td>
          <td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo number_format(100-$porc_tipi1,2);?></font>%</td>
          <td nowrap bgcolor="#006699"><?php echo '<IMG HEIGHT="15" WIDTH="'.(100-$porc_tipi1).'%" SRC="images/barra.jpg">';?></td>
        </tr>
        <tr> 
          <td height="10" width="237"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="97"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="100"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td height="10" width="145"></td>
        </tr>
        <tr> 
          <th nowrap bgcolor="#CCCCCC"><font size="2" face="Arial, Helvetica, sans-serif">Nro TOTAL DE ORDENES</font></th>
          <td bgcolor="#CCCCCC" align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $total;?></font></strong></td>
          <td nowrap bgcolor="#CCCCCC" align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">100%</font></strong></td>
          <td nowrap bgcolor="#CCCCCC"><IMG HEIGHT="15" WIDTH="100%" SRC="images/barra.jpg"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<div align="center">
  <strong><font size="1" face="Arial, Helvetica, sans-serif">NOTA : </font></strong><font size="1" face="Arial, Helvetica, sans-serif">En 
  algunos casos, la suma estadistica tiene un error de 1% por motivos de redondeo.</font></div>