<?php
include ("conexion.php");
include("top_ver.php");
$sql = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacion, DATE_FORMAT(fec_del_back, '%d/%m/%Y') AS fec_del_back, DATE_FORMAT(fec_al_back, '%d/%m/%Y') AS fec_al_back, c.tipo_medio as medio FROM backups as b, controlinvent as c
		WHERE id_back=$id_back AND b.id_medio = c.Codigo";
$res = mysql_db_query($db, $sql, $link);
$row = mysql_fetch_array($res);
$sql2 = "SELECT CONCAT(apa_usr, ' ', ama_usr, ' ',nom_usr ) AS nombre FROM users WHERE login_usr='$row[login_back]'";
$res2 = mysql_db_query($db, $sql2, $link);
$row2 = mysql_fetch_array($res2);
if ( $row[fec_del_back] == "00/00/0000" ) $row[fec_del_back] = "&nbsp;";
if ( $row[fec_al_back] == "00/00/0000" ) $row[fec_al_back] = "&nbsp;";
	
?>
<html>
<head>
	<title> GesTor F1 -  BACKUPS - ADM. FUENTES</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><u>
        BACKUPS</u></font> </strong></div></td>
  </tr>
</table>
<br>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="150" height="23"> <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><b>Nro:</b></font></p>
    </td>
    <td width="497"><p><?php echo $row[id_back];?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="151" height="23"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><strong>
        NOMBRE BACKUP:</strong></font></p>
    </td>
    <td width="496"><p><?php echo $row[nom_back]; ?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="152" height="23"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><B>TIPO DE BACKUP:</B></font></p>
    </td>
    <td width="495"><p><?php echo $row[tipo_back]; ?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="152" height="23"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><B>MODULO:</B></font></p>
    </td>
    <td width="495"><p><?php echo $row[modulo]; ?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>

<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="152" height="23"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><B>FECHA CREACION:</B></font></p>
    </td>
    <td width="495"><p><?php echo $row[fecha_creacion]; ?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>

<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="154" height="23"><p><font size="2" face="Arial, Helvetica, sans-serif"><B>FECHA DEL:</B></font></p></td> 
    
    <td width="139"> <font size="2" face="Arial, Helvetica, sans-serif">
      <?php echo $row[fec_del_back]; ?> </font></td>
    <td width="122"><font size="2" face="Arial, Helvetica, sans-serif"><B>&nbsp;
      FECHA AL:</B></font></td>
    <td width="232"><p> <font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row[fec_al_back]; ?></font></p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>	
</table>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="152" height="23"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><B>MEDIO:</B></font></p>
    </td>
    <td width="495"><p><?php echo $row[medio];?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="152" height="23"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><B>OBSERVACION</B></font></p>
    </td>
    <td width="495"><p><?php echo $row[Observ];?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
 <table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="152" height="23"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><B>RESPONSABLE:</B></font></p>
    </td>
    <td width="495"><p><?php echo $row2[nombre];?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>

<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
 <BR>
</table>
<?php 
if ( $op == "version")
{
?>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="45%" height="53" > 
      <p><strong><font size="2" face="Arial, Helvetica, sans-serif">
       NRO. DE VERSIONES DEL ARCHIVO</font></strong></p>
    </td>
    
  </tr>
  
</table>
<table width="647" border="1" align="center" >
  <tr>
   <td width="113"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>Nro. VERSION</b></font></div></td>
         
    <td width="254"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>NOMBRE</b></font></div></td>
    <td width="258"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>FECHA CREACION</b> 
     </font></div></td>
  </tr>
<?php

$sql2 = "SELECT *, DATE_FORMAT(fecha_ver, '%d/%m/%Y') AS fecha_ver  FROM versiones WHERE id_arch=$id_arch ";
$result2 = mysql_db_query($db,$sql2,$link);
while ( $row2=mysql_fetch_array($result2) ) 
{	 
	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\" face='arial'>$row2[id_version]</font></td>";
	echo "<td><font size=\"1\" face='arial'>$row2[nombre_arch]</font></td>";
	if ($row2[fecha_ver]!="00/00/0000") 
	echo "<td><font size=\"1\" face='arial'>$row2[fecha_ver]</font></td>";
	else echo "<td>&nbsp;</td>";			
	echo "</tr>";
}
}
unset($op);
?>

</table>
<br>
<br>
</body>
</html>