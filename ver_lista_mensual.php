<?php
include ("top_ver.php");
$sql="SELECT *,DATE_FORMAT(FechaDe,'%d / %m / %Y') as FechaDe FROM progtareasmensual ORDER BY Dia ASC";
$rs=mysql_db_query($db,$sql,$link);
print mysql_error();
?>
<html>
<head>
	<title> GesTor F1 - PRODUCCIÓN-PROAPD - CALENDARIZACIÓN</title>
	<style type="text/css">
		<!--
		.text {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 10px;
			font-style: normal;
			font-weight: normal;
		}
		-->
    </style>
</head>
<body><p>
<?php
include("datos_gral.php");
?>
<table width="100%" border="0">
  <tr>
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><strong><u>LISTA DE TAREAS MENSUALES </u></strong></font></div></td>
  </tr>
</table>


<br>
<table width="90%" border="1" align="center" cellpadding="2" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
    <td width="10%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NUMERO</font></strong></div></td>
    <td width="20%" align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">HORA</font></strong></td>
    <td width="20%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ACTIVIDAD</font></strong></div></td>
    <td width="20%" align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">DIA</font></strong></td>
    <td width="20%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA 
    DE PROGRAMACION</font></strong></div></td>
    <td width="20%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></div></td>
  </tr>
  <?php 
while ($row=mysql_fetch_array($rs))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\" class=\"text\">&nbsp;$row[IdProgTarea]</td>";
	echo "<td align=\"center\" class=\"text\">$row[HoraDe] - $row[HoraA]</td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$row[Actividad]</td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$row[Dia]</td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$row[FechaDe]</td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$row[Observaciones]</td>";
	echo "</tr>";
}
?>
</table>
</body>
</html>