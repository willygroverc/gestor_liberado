<?php
include("top_ver.php");
require_once('funciones.php');
$idorden=SanitizeString($_GET['variable']);
$idorden=SanitizeString($idorden);
$idorden=_clean($idorden);
$sql="SELECT *, DATE_FORMAT(fecha_rr, '%d/%m/%Y') AS fecha_rr, DATE_FORMAT(fecha_ra, '%d/%m/%Y') AS fecha_ra 
	  FROM revision WHERE id_orden='$idorden'";
$resul=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($resul);

$sql5="SELECT * FROM ordenes WHERE id_orden='$idorden'";
$resul5=mysql_db_query($db,$sql5,$link);
$row5=mysql_fetch_array($resul5);
?>
<html>
<head>
<title> GesTor F1 - PROBLEMAS-PROAPI - PRODUCCIÓN</title>
</head>
<body><p>
<?php
include("datos_gral.php");
?>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><strong><u>REVISION 
        DEL DIA SIGUIENTE</u></strong></font></div></td>
  </tr>
</table>
<br>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="207" height="20"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NUMERO 
      DE ORDEN DE MESA : </strong></font></td>
    <td width="78">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['id_orden']?>&nbsp;</td>
    <td width="351">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
  </tr>
</table>
<br>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="227" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DESCRIPCION 
      DE LA INCIDENCIA : </strong></font></td>
    <td width="409"><?php echo $row5['desc_inc']?>&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="80%" border="1" align="center" cellpadding="1" cellspacing="1">
  <tr bgcolor="#CCCCCC"> 
    <td width="1%" rowspan="2"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">N&ordm;</font></strong></div></td>
    <td width="10%" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></strong></div></td>
    <td colspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">INICIO</font></strong></div></td>
    <td colspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FIN</font></strong></div></td>
    <td width="10%" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TIEMPO</font></strong></div></td>
    <td width="1%" rowspan="2"><strong><font size="2" face="Arial, Helvetica, sans-serif">SI</font></strong></td>
    <td width="1%" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NO</font></strong></div></td>
    <td width="10%" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></div></td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td width="7%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA</font></strong></div></td>
    <td width="5%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">HORA</font></strong></div></td>
    <td width="7%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA</font></strong></div></td>
    <td width="5%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">HORA</font></strong></div></td>
  </tr>
  <?php
  require_once('funciones.php');
  $variable=SanitizeString($variable);
 $sql2="SELECT *,DATE_FORMAT(Fecha_ini,'%d / %m / %Y') as Fecha_I,DATE_FORMAT(Fecha_fin,'%d / %m / %Y') as Fecha_F FROM detaller WHERE id_orden='$variable'";
 $resul2=mysql_db_query($db,$sql2,$link);
while($row2=mysql_fetch_array($resul2))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"2\">$row2[numero]&nbsp;</font></td>";
	echo "<td align=\"center\"><font size=\"2\">$row2[descripcion]&nbsp;</font></td>";
	echo "<td align=\"center\"><font size=\"2\">$row2[Fecha_I]&nbsp;</font></td>";
	echo "<td align=\"center\"><font size=\"2\">$row2[Hora_ini]&nbsp;</font></td>";
	echo "<td align=\"center\"><font size=\"2\">$row2[Fecha_F]&nbsp;</font></td>";
	echo "<td align=\"center\"><font size=\"2\">$row2[Hora_fin]&nbsp;</font></td>";
	
	$sql_diaI="SELECT TO_DAYS('$row2[Fecha_ini]') as DiaI";
	$row_diaI=mysql_fetch_array(mysql_db_query($db,$sql_diaI,$link));
	$sql_diaF="SELECT TO_DAYS('$row2[Fecha_fin]') as DiaF";
	$row_diaF=mysql_fetch_array(mysql_db_query($db,$sql_diaF,$link));
	
	$d3=$row_diaF['DiaF']-$row_diaI['DiaI'];
	$h="";	
	if($d3>"0"){$h=$h."$d3 dia(s) ";}	
	
	$sql_HoraI="SELECT TIME_TO_SEC('$row2[Hora_ini]') as HoraI";
	$row_HoraI=mysql_fetch_array(mysql_db_query($db,$sql_HoraI,$link));
	$sql_HoraF="SELECT TIME_TO_SEC('$row2[Hora_fin]') as HoraF";
	$row_HoraF=mysql_fetch_array(mysql_db_query($db,$sql_HoraF,$link));
	
	$hora_dif=$row_HoraF['HoraF']-$row_HoraI['HoraI'];
	
	$sql_hr_dif="SELECT SEC_TO_TIME($hora_dif) as HoraDif";
	$row_hr_dif=mysql_fetch_array(mysql_db_query($db,$sql_hr_dif,$link));
	
	$sql_hr="SELECT HOUR('$row_hr_dif[HoraDif]') as Hora";
	$row_hr=mysql_fetch_array(mysql_db_query($db,$sql_hr,$link));
	$sql_min="SELECT MINUTE('$row_hr_dif[HoraDif]') as Minuto";
	$row_min=mysql_fetch_array(mysql_db_query($db,$sql_min,$link));
	$sql_seg="SELECT SECOND('$row_hr_dif[HoraDif]') as Segundo";
	$row_seg=mysql_fetch_array(mysql_db_query($db,$sql_seg,$link));

	if($row_hr['Hora']>"0"){$h=$h."$row_hr[Hora] hr. ";}
	if($row_min['Minuto']>"0"){$h=$h."$row_min[Minuto] m. ";}
	if($row_seg['Segundo']>"0"){$h=$h."$row_seg[Segundo] s.";}
	 

	
	echo "<td><font size=\"1\">$h&nbsp;</font></td>";

	if($row2['elegido']=="Si")
	{echo "<td align=\"center\"><font size=\"2\">&nbsp;<img src=\"images/si1.gif\" border=\"1\"></font></td>";
     echo "<td align=\"center\"><font size=\"2\">&nbsp;<img src=\"images/no1.gif\" border=\"1\"></font></td>";
	}
	else
	{echo "<td align=\"center\"><font size=\"2\">&nbsp;<img src=\"images/no1.gif\" border=\"1\"></font></td>";
     echo "<td align=\"center\"><font size=\"2\">&nbsp;<img src=\"images/si1.gif\" border=\"1\"></font></td>";
	}
	echo "<td align=\"center\"><font size=\"2\">&nbsp;$row2[observ]</font></td>";
	echo "</tr>";
}
 ?>
</table>
<br>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="126" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES 
      : </strong></font></td>
    <td width="510"><?php echo $row['observaciones']?>&nbsp;</td>
</tr>
<tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="304"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE DEL RESPONSABLE DE LA REVISION : </strong></font></td>
    <td width="332"><?php 
	$sql3="SELECT * FROM users WHERE login_usr='$row[nomb_rrevision]'";
	$resul3=mysql_db_query($db,$sql3,$link);
	$row3=mysql_fetch_array($resul3);
	echo $row3['nom_usr']."&nbsp;".$row3['apa_usr']."&nbsp;".$row3['ama_usr'];?>&nbsp;</td>
</tr>
<tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>

<br>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="160"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA DE LA REVISION : </strong></font></td>
    <td width="476"><?php echo $row['fecha_rr']?>&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="323"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE DEL RESPONSABLE DE LA AUDITORIA : </strong></font></td>
    <td width="313"><?php 
	$sql4="SELECT * FROM users WHERE login_usr='$row[nomb_rauditoria]'";
	$resul4=mysql_db_query($db,$sql4,$link);
	$row4=mysql_fetch_array($resul4);
	echo $row4['nom_usr']."&nbsp;".$row4['apa_usr']."&nbsp;".$row4['ama_usr'];?>&nbsp;</td>

</tr>
<tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>

<br>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="170"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA DE LA AUDITORIA : </strong></font></td>
    <td width="466"><?php echo $row['fecha_ra']?>&nbsp;</td>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>

  </tr>
</table>
</body>
</html>