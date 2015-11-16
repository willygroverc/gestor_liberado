<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include("top_ver.php");
?>
<html>
<head>
	<title> GesTor F1 - PRODUCCIÓN-PROAPD - CONTROL TEMP. Y HUMEDAD</title>
</head>
<body><p>
<?php
include("datos_gral.php");
?>
<table width="100%" border="0">
  <tr>
    <td><div align="center"><strong><font size="4" face="Arial, Helvetica, sans-serif"><u>CONTROL DE TEMPERATURA Y HUMEDAD 
        RELATIVA</u></font></strong></div></td>
  </tr>
</table>

<br>
<table width="100%" border="1">
  <tr bgcolor="#CCCCCC"> 
    <th><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NUMERO</strong></font></div></th>
    <th><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA</strong></font></div></th>
    <th><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>HORA</strong></font></div></th>
    <th><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>TEMPERATURA (&deg;C)</strong></font></div></th>
    <th><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>HUMEDAD 
        RELATIVA (EN %)</strong></font></div></th>
    <th><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>RESPONSABLE</strong></font></div></th>
    <th><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES</strong></font></div></th>
  </tr>
  <?php
$sql="SELECT *,DATE_FORMAT(fecha,'%d / %m / %Y') as fecha FROM controltemp";
$resul=mysql_query($sql);
while ($row=mysql_fetch_array($resul))
{
	echo"<tr align=\"center\">";
	echo"<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[numero]</font></td>";
	echo"<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[fecha]</font></td>";
	echo"<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[hora]</font></td>";
	echo"<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[temperatura]</font></td>";
	echo"<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[hr]</font></td>";
	$sql2="SELECT * FROM users WHERE login_usr='$row[nombresp]'";
	$resul2=mysql_query($sql2);
	$row2=mysql_fetch_array($resul2);
	echo"<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row2[nom_usr]  $row2[apa_usr]  $row2[ama_usr]</font></td>";
	echo"<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[observ]</font></td>";
	echo"</tr>";
}
?>
</table>
</body>
</html>