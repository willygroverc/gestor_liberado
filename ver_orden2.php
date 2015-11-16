<?php
include ("top_ver.php");
require_once('funciones.php');
$id_orden=SanitizeString($_REQUEST['id_orden']);
$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes,users WHERE id_orden='$id_orden' AND cod_usr=login_usr";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);

$sql1 = "SELECT *, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig FROM asignacion WHERE id_orden='$id_orden' ORDER BY id_asig DESC limit 1"; 
$result1=mysql_query($sql1);
$row1=mysql_fetch_array($result1);

$sql2 = "SELECT *, DATE_FORMAT(fecha_seg, '%d/%m/%Y') AS fecha_seg, DATE_FORMAT(fecha_rea, '%d/%m/%Y') AS fecha_rea FROM seguimiento WHERE id_orden='$id_orden'"; 
$result2=mysql_query($sql2);

$sql3 = "SELECT *, DATE_FORMAT(fecha_sol, '%d/%m/%Y') as fecha_sol, DATE_FORMAT(fecha_sol_e, '%d/%m/%Y') as fecha_sol_e FROM solucion WHERE id_orden='$id_orden'";
$result3=mysql_query($sql3);
$row3=mysql_fetch_array($result3);

$sql4 = "SELECT *, DATE_FORMAT(fecha_conf, '%d/%m/%Y') as fecha_conf FROM conformidad WHERE id_orden='$id_orden'"; 
$result4=mysql_query($sql4);
$row4=mysql_fetch_array($result4);

$sql5 = "SELECT * FROM costo WHERE id_orden='$id_orden'";
$result5=mysql_query($sql5);

$sql6 = "SELECT SUM(subtot_cos) AS total_cos FROM costo where id_orden='$id_orden'";
$result6=mysql_query($sql6);
$row6=mysql_fetch_array($result6); 

$sql8 = "SELECT * FROM titular WHERE ci_ruc='$row[ci_ruc]'";
$result8=mysql_query($sql8);
$row8=mysql_fetch_array($result8);
?>
<html>
<head>
<title>Orden de Trabajo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="general.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF">
<p><?php
include("datos_gral.php");
?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> 
        <div align="center"><b><u><font size="3" face="Arial, Helvetica, sans-serif">ORDEN 
        DE TRABAJO</font></u></b></div>
    </td>
  </tr>
</table>
<table width="635" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="123" class="titulo2">Fecha de creacion : </td>
    <td width="105" class="tit_form"><?php echo $row['fecha'];?></td>
    <td width="128" class="titulo2">Hora de creacion : </td>
    <td width="73" class="tit_form"><?php echo $row['time'];?></td>
    <td width="109"><div align="right" class="titulo2">N: </div></td>
    <td width="97"><table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
        <tr> 
          <td align="center" class="tit_form">&nbsp;<?php echo $row['id_orden'];?></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1" colspan="2"></td>
  </tr>
</table>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="titulo"><u><strong>Datos del usuario</strong> </u></td>
  </tr>
</table>
<br>
<table width="635" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="134" nowrap class="titulo2">Registrado por :</td>
    <td width="259" nowrap class="tit_form"><strong>
	<?php 
	if ($row['login_usr']==""){echo "SISTEMA";}
	else {echo $row['nom_usr']." ".$row['apa_usr']." ".$row['ama_usr'];}
	?></strong></td>
    <td width="43" nowrap>&nbsp;</td>
    <td width="63" nowrap class="titulo2">Firma : </td>
    <td width="136" nowrap>_________________</td>
  </tr>
  <tr> 
    <td height="1" ></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1"></td>
    <td height="1"></td>
  </tr>

</table>
<br>
<table width="635" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="95" nowrap class="titulo2">Asignado a :</td>
    <td width="301" nowrap class="tit_form"><strong>
	<?php 
	$sql7 = "SELECT * FROM users WHERE login_usr='$row1[asig]'";
	$result7=mysql_query($sql7);
	$row7=mysql_fetch_array($result7);
	echo $row7['nom_usr']." ".$row7['apa_usr']." ".$row7['ama_usr'];
	?></strong></td>
    <td width="42" nowrap>&nbsp;</td>
    <td width="61" nowrap class="titulo2">Firma : </td>
    <td width="136" nowrap>_________________</td>
  </tr>
  <tr> 
    <td height="1" ></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1"></td>
    <td height="1"></td>
  </tr> 
</table>
<table width="635" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="635" nowrap class="titulo"><u><strong>Datos del Titular </strong></u></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="77" class="titulo2">CI/RUC : </td>
    <td width="127" class="tit_form"><?php echo $row['ci_ruc'];?></td>
    <td width="433">&nbsp;</td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="147" class="titulo2">Nombre y Apellidos : </td>
    <td width="254" class="tit_form"><?php echo $row8['nombre']." ".$row8['apaterno']." ".$row8['amaterno']; if($row8['acasada']!=""){echo " de $row8[acasada]";}?></td>
    <td width="35">&nbsp;</td>
	<?php 
	if (!isset($row3[0]) ) { ?>
	<td width="62" class="titulo2">Firma : </td>
    <td width="139">_________________</td>
	<?php } ?>	
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
  </tr>
</table>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="48" class="titulo2">Email :</td>
    <td width="168" class="tit_form"><?php echo $row8['email'];?></td>
    <td width="70" class="titulo2">Direccion :</td>
    <td width="213" class="tit_form"><?php echo $row8['direccion'];?></td>
    <td width="38" class="titulo2">Telf.:</td>
    <td width="99" class="tit_form"><?php echo $row8['telf'];?></strong></td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="58" class="titulo2">Entidad :</td>
    <td width="155"class="tit_form" ><?php echo $row8['entidad'];?></td>
    <td width="68" class="titulo2">Area :</td>
    <td width="187" class="tit_form"><strong><?php echo $row8['area'];?></strong></td>
    <td width="64" class="titulo2">Cargo :</td>
    <td width="104" class="tit_form"><strong><?php echo $row8['cargo'];?></strong></td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr> 
    <td height="19" class="titulo"> <div align="left"><u><strong>Descripcion de 
        la Consulta</strong></u></div></td>
  </tr>
</table>
<table width="636" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
<?php 
	echo "<tr><td class='tit_form'>&nbsp;".$row['desc_inc']. "</td></tr>";	
?>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="205" class="titulo2">Fecha estimada de solucion: </td>
    <td width="157" class="tit_form"><?php echo $row1['fechaestsol_asig'];?></td>
    <td width="275">&nbsp;</td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="2">
 	<tr align="center"><td class="titulo"><div align="left"><u>Seguimiento:</u></div></td></tr>
</table>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr align="center" bgcolor="#CCCCCC"> 
    <td width="12%" class="titulo3">Nro.</td>
	<td width="23%" class="titulo2">Realizado por</td>
	<td width="9%" class="titulo2">Fecha de Realizaci�n</td>
    <td width="12%" class="titulo3">Estado</td>
    <td width="26%" class="titulo3">Observaciones</td>
    <td width="8%" class="titulo2">Fecha de Registro</td>
    <td width="10%" class="titulo3">Hora</td>
  </tr>

<?php $conta=1;
	while ($row2=mysql_fetch_array($result2)) {
	?>
	 <tr align="center"> 
    	<td class="tit_form">Seg <?php echo $conta;?></td>
		<td class="tit_form"><strong>
		<?php 
		$sql_se = "SELECT * FROM users WHERE login_usr='$row2[login_usr]'";
		$result_se=mysql_query($sql_se);
		$row_se=mysql_fetch_array($result_se); 
		echo $row_se['nom_usr']." ".$row_se['apa_usr']." ".$row_se['ama_usr'];?>
      </strong></td>
	    <td class="tit_form"><?php echo $row2['fecha_rea'];?></td>
		<td class="tit_form">
			<?php //echo $row2[estado_seg];?>
			<?php 
			if ($row2['estado_seg']=="1")
			{echo "Cumplida en fecha";}
			if ($row2['estado_seg']=="2")
			{echo "Cumplida retrasada";}
			if ($row2['estado_seg']=="3")
			{echo "Pendiente en fecha";}
			if ($row2['estado_seg']=="4")
			{echo "Pendiente retrasada";}
			if ($row2['estado_seg']=="5")
			{echo "Desestimada";}
		 ?>
		</td>
    	<td class="tit_form">&nbsp;<?php echo $row2['obs_seg'];?></td>
	    <td class="tit_form"><?php echo $row2['fecha_seg'];?></td>
    	<td class="tit_form"><?php echo $row2['hora_seg'];?></td>
	 </tr>
         
<?php $conta++; }?>
         
</table>

<?php if (isset($row3[0])) { ?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr align="center" class="titulo"> 
    <td><div align="left"><u>Detalles de la Solucion</u></div></td>
  </tr>
</table>

<table width="636" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
  <?php 
	echo "<tr><td class='tit_form'>&nbsp;".$row3['detalles_sol']. "</td></tr>";	
?>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="200" class="titulo2">Fecha de EJECUCION DE solucion: </td>
    <td width="138" align="center" class="tit_form"><strong><?php echo $row3['fecha_sol_e'];?></strong></td>
    <td  align="right" class="titulo2">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td height="2" bgcolor="#000000"></td>
    <td height="2"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="156" class="titulo2">Fecha de solucion: </td>
    <td align="center" width="163" class="tit_form"><strong><?php echo $row3['fecha_sol'];?></strong></td>
    <td  align="right" width="118" class="titulo2">Hora :</td>
    <td align="center" width="163" class="tit_form"><strong><?php echo $row3['hora_sol'];?></strong></td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr align="center"> 
    <td class="titulo"><div align="left"><u>Medidas Preventivas Recomendadas</u></div></td>
  </tr>
</table>
<table width="636" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
  <?php 
	echo "<tr><td class='tit_form'>&nbsp;".$row3['medprev_sol']. "</td></tr>";	
?>
</table>
<?php  } ?>

<br>
<?php if(isset($row4[0])){ ?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr align="center"> 
    <td class="titulo"><div align="left"><u>Conformidad del Cliente</u></div></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="153" class="titulo2">Fecha de solucion: </td>
    <td align="center" width="163" class="tit_form"><strong><?php echo $row4['fecha_conf'];?></strong></td>
    <td  align="right" width="160" class="titulo">Hora:</td>
	<td align="center" width="161" class="tit_form"><strong><?php echo $row4['hora_conf'];?></strong></td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>

  <tr> 
    <td width="153" class="titulo2">Tiempo de solucion: </td>
    <td align="center" width="163" class="tit_form"><strong>
	<?php 
	if ($row4['tiemposol_conf']=="1") {echo "1 - Malo";}
	elseif ($row4['tiemposol_conf']=="2") {echo "2 - Bueno";}
	elseif ($row4['tiemposol_conf']=="3") {echo "3 - Excelente";}
	?></strong></td>
    <td  align="right" width="160" class="titulo2">Calidad de atencion :</td>
	<td align="center" width="161" class="tit_form"><strong>
	<?php 
	if ($row4['calidaten_conf']=="1") {echo "1 - Malo";}
	elseif ($row4['calidaten_conf']=="2") {echo "2 - Bueno";}
	elseif ($row4['calidaten_conf']=="3") {echo "3 - Excelente";}
	?></strong></td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table>
<br>

<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr align="center"> 
    <td class="titulo"><div align="left"><u>Observaciones del Cliente</u></div></td>
  </tr>
</table>

<table width="636" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
<?php 
	echo "<tr><td class='tit_form'>&nbsp;".$row4['obscli_conf']. "</td></tr>";	
?>
</table>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr> 
    <td width="462" align="right" class="titulo">Firma del Titular: </td>
    <td width="39">_____________________________________</td>
  </tr>
</table>
<?php  } ?>
<br>


<?php 
    $conta=1;
	while ($row5=mysql_fetch_array($result5)) {
	if($conta==1) {		?>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="2" >
  <tr align="center">  
    <td class="titulo"> <div align="left"><u>Costos del Servicio:</u> </div></td> </tr>
</table>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" >
  <tr align="center" bgcolor="#CCCCCC"> 
    <td width="8%" class="titulo3">Nro</td>
	<td width="17%" class="titulo2" height="40">Responsable</td>
    <td width="34%" class="titulo3">Descripcion</td>
    <td width="6%" class="titulo3">Tiempo Horas</td>
    <td width="6%" class="titulo3">Costo x Hora</td>
    <td width="6%" class="titulo3">Subtotal</td>
	<td width="10%" class="titulo2" height="40">Costo x Hora Hombre</td>
	<td width="13%" class="titulo2" height="40">Costo Hora Hombre x Tiempo Servicio</td>
  </tr>
  <?php } ?>
    <?php
		$sConsulta = "SELECT * FROM users where login_usr='$row5[responsable]'";
		$sRes = mysql_query($sConsulta);
		$sReg=mysql_fetch_array($sRes);
		$costo_tiempo = $sReg['costo_usr'] * $row5['tiemph_cos'];
		$costo_total = $costo_total + $costo_tiempo;
	?>  
	 <tr align="center"> 
    	<td class="tit_form">Seg<?php echo $conta;?></td>
		<td class="tit_form"><?php echo $sReg['apa_usr']." ".$sReg['ama_usr']." ".$sReg['nom_usr'];?></td>
	    <td class="tit_form">&nbsp;<?php echo $row5['desc_cos'];?></td>
    	<td class="tit_form">&nbsp;<?php echo $row5['tiemph_cos'];?></td>
	    <td class="tit_form">&nbsp;<?php echo $row5['cosxh_cos'];?></td>
    	<td align="right" class="tit_form">&nbsp;<?php echo $row5['subtot_cos'];?></td>
		<td class="tit_form" align="right">&nbsp;<?php echo $sReg['costo_usr'];?></td>
        <td align="right" class="tit_form">&nbsp;<?php echo number_format($costo_tiempo,2);?></td>
	 </tr>
<?php $conta++; } ?>
<?php if(isset($row6[0])){ ?>
	 <tr> 
    	<td colspan="4">&nbsp;</td>
	    <td align="right" class="tit_form">Total Bs.</td>
    	<td align="right" class="tit_form"><?php echo $row6['total_cos'];?></td>	
		<td>&nbsp;</td>
	    <td align="right" class="tit_form"><?php if($costo_total <> 0)echo number_format($costo_total,2);?></td>
	 </tr>
</table>
<?php }?>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="2">
  <tr align="center"> 
    <td width="313" height="19"> <p class="titulo2"> &#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;<br>
        <?php 
	if ($row['login_usr']==""){echo "SISTEMA";}
	else {echo $row['nom_usr']." ".$row['apa_usr']." ".$row['ama_usr'];}
	?>
      </p></td>
    <td width="317" class="titulo2">&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;<br> 
      <?php /*
	$sql10 = "SELECT * FROM users WHERE login_usr='$row1[asig]'";
	$result10=mysql_query($sql10);
	$row10=mysql_fetch_array($result10); 
	echo $row10[nom_usr]." ".$row10[apa_usr]." ".$row10[ama_usr];*/?>VoBo
    </td>
  </tr>
</table>
</body>
</html>
	