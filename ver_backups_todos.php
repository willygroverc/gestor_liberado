<?php
include ("conexion.php");
include ("funciones.inc.php");
session_start();
$path = $_SESSION["path"];
?>
<html>
<head>
	<title> GesTor F1 - BACKUPS  - ADM. FUENTES</title>
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
<table width="890" border="1" align="center" >
  <tr bgcolor="#CCCCCC">
   <td width="29" align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>Nro.</b></font></td> 
    <td width="139" align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>NOMBRE BACKUP</b></font></td>
	<td width="107" align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>TIPO DE BACKUP</b></font></td>
	<td width="70" align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>MODULO</b></font></td>
    <td width="106" align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>FECHA CREACION </b></FONT></td> 
	<td width="79" align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>FECHA DEL</b></FONT></td>
	<td width="85" align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>FECHA AL</b></FONT></td>
	<td width="106" align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>MEDIO</b></FONT></td>	
	<td width="117" align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>RESPONSABLE </b></font></div></td>     
  </tr>
<?php
$sql = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacion, DATE_FORMAT(fec_del_back, '%d/%m/%Y') AS fec_del_back, DATE_FORMAT(fec_al_back, '%d/%m/%Y') AS fec_al_back, c.tipo_medio as medio FROM backups as b, controlinvent as c
		WHERE b.id_medio = c.Codigo  ORDER BY id_back DESC";
$res = mysql_db_query($db, $sql, $link);
while ( $fila = mysql_fetch_array($res))
{	$sql2 = "SELECT CONCAT(apa_usr, ' ', ama_usr, ' ',nom_usr ) AS nombre FROM users WHERE login_usr='$fila[login_back]'";
	$res2 = mysql_db_query($db, $sql2, $link);
	$row2 = mysql_fetch_array($res2);	
	if ( $fila[fec_del_back] == "00/00/0000" ) $fila[fec_del_back] = "&nbsp;";
	if ( $fila[fec_al_back] == "00/00/0000" ) $fila[fec_al_back] = "&nbsp;";
	if ( $fila[modulo] == "" ) $fila[modulo] = "&nbsp;";
	echo "<tr align='center'>";
	echo "<td><font size=\"1\" face='arial'>$fila[id_back]</font></td>";
	echo "<td><font size=\"1\" face='arial'>$fila[nom_back]</font></td>";
	echo "<td><font size=\"1\" face='arial'>$fila[tipo_back] </font></td>";
	echo "<td><font size=\"1\" face='arial'>$fila[modulo]</font></td>";
	echo "<td><font size=\"1\" face='arial'>$fila[fecha_creacion]</font></td>";
	echo "<td><font size=\"1\" face='arial'>$fila[fec_del_back]</font></td>";
	echo "<td><font size=\"1\" face='arial'>$fila[fec_al_back]</font></td>";
	echo "<td><font size=\"1\" face='arial'>$fila[medio]</font></td>";
	echo "<td><font size=\"1\" face='arial'>$row2[nombre]</font></td>";
	echo "</tr>";
} 
?>
</table>
<br>
<br>
</body>
</html>