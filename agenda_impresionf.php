<?php 
include("conexion.php");
if (strlen($DA) == 1){ $DA = "0".$DA; }
if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
$fec1 = $AA."-".$MA."-".$DA;   
if (strlen($DE) == 1){ $DE = "0".$DE; }
if (strlen($ME) == 1){ $ME = "0".$ME; }
$fec2 = $AE."-".$ME."-".$DE; 
?>
<html>
<head>
<title>Impresion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<br>
<div align="center"><strong><font size="4" face="Arial, Helvetica, sans-serif"><u>LISTA DE 
  AGENDA - MINUTA DE REUNION</u></font></strong> </div>
<br>
<table width="100%" border="3" align="center" cellpadding="0" cellspacing="0">
  <tr align="center"> 
    <th class="menu"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA</font></strong></th>
    <th class="menu"><strong><font size="2" face="Arial, Helvetica, sans-serif">CODIGO</font></strong></th>
    <th class="menu"><strong><font size="2" face="Arial, Helvetica, sans-serif">Nro</font></strong></th>
    <th class="menu"><strong><font size="2" face="Arial, Helvetica, sans-serif">ELABORADO 
      POR</font></strong></th>
    <th class="menu"><strong><font size="2" face="Arial, Helvetica, sans-serif">TIPO 
      DE REUNION</font></strong></th>
    <th class="menu"><strong><font size="2" face="Arial, Helvetica, sans-serif">LUGAR</font></strong></th>
  </tr>
  <?php
$sql = "SELECT *, DATE_FORMAT(en_fecha, '%d/%m/%Y') AS en_fecha FROM agenda WHERE en_fecha BETWEEN '$fec1' AND '$fec2' ORDER BY id_agenda ASC"; 
$result=mysql_db_query($db,$sql,$link);
while ($row=mysql_fetch_array($result)) 
{
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[en_fecha]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[codigo]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[num_codigo]</td>";
		$sql7="SELECT * FROM users WHERE login_usr='$row[elab_por]'";
		$result7=mysql_db_query($db,$sql7,$link);
		$row7=mysql_fetch_array($result7);	
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row7[nom_usr] $row7[apa_usr] $row7[ama_usr]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[tipo_reu]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[lugar]</font></td>";	
	echo "</tr>\n";}
?>
</table>
</body>
</html>
