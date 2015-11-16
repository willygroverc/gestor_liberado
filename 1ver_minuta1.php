<?php
include ("top_ver.php");
include ("conexion.php");
$idmin=($_GET['variable']);
$sql = "SELECT *,DATE_FORMAT(en_fecha,'%d / %m / %Y') as en_fecha,DATE_FORMAT(fecha,'%d / %m / %Y') as fecha FROM minuta  WHERE id_minuta='$idmin' ";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - ACTAS</title>
</head>
<body>
<p><?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><u>MINUTA 
        DE REUNION</u></font></strong></div></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="58"> <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CODIGO</strong></font></p>
    </td>
    <td width="579"><p>&nbsp;
	<?php 
	echo "$row[codigo]";
	/*if($row[codigo]=="CSI"){echo "$row[codigo] (Comite de Sistemas)";}
	elseif($row[codigo]=="CCP"){echo "$row[codigo] (Comite de Cambios en Prod.)";}
	elseif($row[codigo]=="CRC"){echo "$row[codigo] (Comite de Recup. y Conting.)";}
	elseif($row[codigo]=="OTRO"){echo "$row[codigo]";}*/
	?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="131"> <p align="left"><font size="2" face="Arial, Helvetica, sans-serif">ELABORADO 
        POR<strong> </strong></font></p></td>
    <td width="260"><strong>	
	<?php 
	$consul="SELECT * FROM users WHERE login_usr='$row[elab_por]'";
	$resul=mysql_db_query($db,$consul,$link);
	$fila=mysql_fetch_array($resul);	
	echo $fila[nom_usr]."&nbsp;".$fila[apa_usr]."&nbsp;".$fila[ama_usr];?>
</strong></td>
    <td width="81"><font size="2" face="Arial, Helvetica, sans-serif">EN FECHA</font></td>
    <td width="165"><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row[en_fecha];?></font></p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>

<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="260"><font size="2" face="Arial, Helvetica, sans-serif">TIPO DE REUNION: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ORDINARIA</font> 
      <?php 
	if ($row[tipo_min]=="Ordinaria")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
		else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
    </td>
    <td width="151"><font size="2" face="Arial, Helvetica, sans-serif">EXTRAORDINARIA:</font> 
      <?php 
	if ($row[tipo_min]=="Extraordinaria")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
		else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
    </td>
    <td width="91"><font size="2" face="Arial, Helvetica, sans-serif">EMERGENCIA:</font></td>
    <td width="52">&nbsp;
	      <?php 
	if ($row[tipo_min]=="Emergencia")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
		else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>

	</td>
    <td width="83"><font size="2" face="Arial, Helvetica, sans-serif">OTROS:</font> 
      <?php 
	if ($row[tipo_min]=="Otros")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
		else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
    </td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="50"><font size="2" face="Arial, Helvetica, sans-serif">FECHA</font></td>
    <td width="120"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<?php echo $row[fecha];?>&nbsp;</font></td>
    <td width="64"><font size="2" face="Arial, Helvetica, sans-serif">HORA</font></td>
    <td width="93"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<?php echo $row[hora]; ?>&nbsp;</font></td>
    <td width="59"><font size="2" face="Arial, Helvetica, sans-serif">LUGAR</font></td>
    <td width="251"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row[lugar] ?>&nbsp;</font></td>
  </tr>
<tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>

  </tr>
</table>

<br>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td height="18" colspan="4" ><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ASISTENTES</font></strong></div></td>
  </tr>
  <tr> 
    <td height="21"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE</font></strong></div></td>
    <td width="203" valign="top"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">CARGO 
    /ROL</font></strong></div></td>
    <td width="146" valign="top"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FIRMA</font></strong></div></td>
  </tr>
  <?php
$sql2 = "SELECT * FROM asistentes WHERE id_minuta=$row[id_minuta]";
$result2=mysql_db_query($db,$sql2,$link);
while ($row2=mysql_fetch_array($result2)) 
{
	$cont=$cont+1;	
	echo "<tr align=\"center\">";
	echo "<td><font size=\"2\">&nbsp;$cont</font></td>";
	$sql3 = "SELECT * FROM users WHERE login_usr='$row2[nombre]'";
	$result3 = mysql_db_query($db,$sql3,$link);
	$row3 = mysql_fetch_array($result3); 
	if($row3)
	{echo "<td align=\"center\"><font size=\"2\">&nbsp;$row3[nom_usr] $row3[apa_usr] $row3[ama_usr]</font></td>";}
	else
	{echo "<td><font size=\"2\">&nbsp;$row2[nombre]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row2[cargo]</font></td>";
	echo "<td><font size=\"15\" height= \"100\"width=\"\">&nbsp; &nbsp; &nbsp;</font></td>";
	echo "</tr>";
}
?>
</table>
<br>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="4"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TEMAS 
        DISCUTIDOS</font></strong></div></td>
  </tr>
  <tr> 
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TEMA</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABLE</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">DURACION(min)</font></strong></div></td>
  </tr>
  <?php
$ttotal=0;
$sql25= "SELECT * FROM temad WHERE id_minuta=$row[id_minuta]";
$result25=mysql_db_query($db,$sql25,$link);
while ($row25=mysql_fetch_array($result25)) 
{
	echo "<tr align=\"center\">";
	echo "<td><font size=\"2\">&nbsp;$row25[id_tema]</font></td>";
		$sql5 = "SELECT * FROM temas WHERE id_tema='$row25[tema]'  AND id_agenda='$row[id_minuta]'";
		$result5 = mysql_db_query($db,$sql5,$link);
		$row5 = mysql_fetch_array($result5);
		if (!$row5[id_tema])
		{echo "<td>&nbsp;$row25[tema]</td>";}
		else
		{echo "<td>&nbsp;$row5[tema]</td>";}
	$sql3 = "SELECT * FROM users WHERE login_usr='$row25[responsable]'";
	$result3 = mysql_db_query($db,$sql3,$link);
	$row3 = mysql_fetch_array($result3); 
	if($row3)
	{echo "<td align=\"center\"><font size=\"2\">&nbsp;$row3[nom_usr] $row3[apa_usr] $row3[ama_usr]</font></td>";}
	else
	{	echo "<td><font size=\"2\">&nbsp;$row25[responsable]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row25[duracion]</font></td>";
	$ttotal+=$row25[duracion];
	echo "</tr>";
}
?>
  <tr> 
    <td colspan="3"><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong>TOTAL 
        =</strong></font></div></td>
    <td align="center"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp; 
      <?php 
			  $minutos=$ttotal%60;
			  $ttotal-=$minutos;
			  $horas=$ttotal/60;
			  if($horas > 0) echo $horas." hrs. ".$minutos." min.";
			  else echo $minutos." min.";?>
      </strong></font></td>
  </tr>
</table>
<br>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">RESULTADOS 
        POR TEMA</font></strong></div></td>
  </tr>
  <tr> 
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">RESULTADOS</font></strong></div></td>
  </tr>
  <?php
$sql13 = "SELECT * FROM rtema WHERE id_minuta=$row[id_minuta]";
$result13=mysql_db_query($db,$sql13,$link);
while ($row13=mysql_fetch_array($result13)) 
{
	echo "<tr align=\"center\">";
	echo "<td><font size=\"2\">&nbsp;$row13[id_tema]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row13[resultado]</font></td>";
	echo "</tr>";
}
?>
</table>
<br>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="4"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ACCIONES 
        POR TEMAS</font></strong></div></td>
  </tr>
  <tr> 
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ACCION</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABLE</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA 
        LIMITE</font></strong></div></td>
  </tr>
  <?php
$sql14 = "SELECT *, DATE_FORMAT(flimite, '%d/%m/%Y') AS flimite FROM atema WHERE id_minuta=$row[id_minuta]";
$result14=mysql_db_query($db,$sql14,$link);
while ($row14=mysql_fetch_array($result14)) 
{
	echo "<tr align=\"center\">";
	echo "<td><font size=\"2\">&nbsp;$row14[id_tema]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row14[accion]</font></td>";
	$sql3 = "SELECT * FROM users WHERE login_usr='$row14[responsable]'";
	$result3 = mysql_db_query($db,$sql3,$link);
	$row3 = mysql_fetch_array($result3); 
	if($row3)
	{echo "<td align=\"center\"><font size=\"2\">&nbsp;$row3[nom_usr] $row3[apa_usr] $row3[ama_usr]</font></td>";}
	else
	{echo "<td><font size=\"2\">&nbsp;$row14[responsable]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row14[flimite]</font></td>";
	echo "</tr>";
}
?>
</table><br>
<table width="637" border="2" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="4"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong> 
        PROPUESTAS</strong></font></div></td>
  </tr>
  <tr> 
    <td width="5%" height="21"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>N&ordf;</strong></font></div></td>
    <td width="30%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font size="2">NOMBRE</font></strong></font></div></td>
    <td width="45%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font size="2">PROPUESTAS</font></strong></font></div></td>
    <td width="20%"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font size="2">ARCHIVO 
        ADJUNTO </font></strong></font></div></td>
  </tr>
  <?php
		$cont=0;	
		$sql24 = "SELECT * FROM asistentes WHERE id_minuta='$row[id_minuta]' AND prop IS NOT NULL";
		$result24=mysql_db_query($db,$sql24,$link);
		while($row24=mysql_fetch_array($result24)) 
  		{
		$cont=$cont+1;
		 ?>
  <tr align="center"> 
    <td ><font size="2">&nbsp;<?php echo $cont?></font></td>
    <?php 	$sql5 = "SELECT * FROM users WHERE login_usr='$row24[nombre]' ";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5[login_usr])
				{echo "<td><font size=\"2\">&nbsp;$row24[nombre]</font></td>";}
				else
				{echo "<td><font size=\"2\">&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</font></td>";}?>
    <td><font size="2">&nbsp;<?php echo $row24[prop]?></font></td>
    <td><font size="2"><?php=$row24[adjunto]?>&nbsp;</font></td>
  </tr>
  <?php 
		
		 }
		 ?>
</table><br>
<table width="637" border="2" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="631" height="18"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">COMENTARIOS</font></strong></div></td>
  </tr>
  <tr> 
    <td height="42" valign="top"><div align="center"><font size="2"><?php echo $row[comentario]?></font></div></td>
  </tr>
  <?php
		$cont=0;	
		$sql24 = "SELECT * FROM asistentes WHERE id_minuta='$row[id_minuta]' AND prop IS NOT NULL";
		$result24=mysql_db_query($db,$sql24,$link);
		while($row24=mysql_fetch_array($result24)) 
  		{
		$cont=$cont+1;
		 ?>
  
  <?php 
		
		 }
		 ?>
</table>
<p>&nbsp;</p>
<div align="center"><br>
  <!-- <table width="637" border="2" cellpadding="0" cellspacing="0">
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>RECAUDACIONES</strong></font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Total 
          Recaudado :</font></strong><font size="2" face="Arial, Helvetica, sans-serif"> 
          <?php//=$row[recau]?>
          Bs.</font> </div></td>
    </tr>
  </table> -->
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>