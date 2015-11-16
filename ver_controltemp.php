<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Sanitizacion de variables para evitar ataques de SQL injection
// Fecha: 		01/OCT/2013
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include("top_ver.php");
require_once('funciones.php');
$variable=SanitizeString($_GET['variable']);
$num=$variable;
$sql="SELECT *,DATE_FORMAT(fecha,'%d / %m / %Y') as fecha FROM controltemp WHERE numero='$num'";
$resul=mysql_query($sql);
$row=mysql_fetch_array($resul);
?>
<html>
<head>
	<title> GesTor F1 - PRODUCCIÓN-PROAPD - CONTROL TEMP. Y HUMEDAD</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><u><strong>CONTROL 
        DE TEMPERATURA Y HUMEDAD RELATIVA</strong></u></font></div></td>
  </tr>
</table>

<br>
&nbsp;&nbsp;&nbsp; 
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="159"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NUMERO 
      DE CONTROL :</strong></font></td>
    <td width="80">&nbsp;&nbsp;<?php echo $row['numero']; ?>&nbsp;</td>
    <td width="397">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
  </tr>
</table>
&nbsp; 
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="158"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA DE 
      CONTROL :</strong></font></td>
    <td width="478">&nbsp;&nbsp;<?php echo $row['fecha']; ?>&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
&nbsp; 
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="157"><font size="2" face="Arial, Helvetica, sans-serif"><strong>HORA DE 
      CONTROL :</strong></font></td>
    <td width="479">&nbsp;&nbsp;<?php echo $row['hora'];?>&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
&nbsp; 
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="156"><font size="2" face="Arial, Helvetica, sans-serif"><strong>TEMPERATURA 
      :</strong></font></td>
    <td width="480">&nbsp;&nbsp;<?php echo $row['temperatura']; ?>&nbsp; &deg; C</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="156"><font size="2" face="Arial, Helvetica, sans-serif"><strong>HUMEDAD 
      RELATIVA :</strong></font></td>
    <td width="480">&nbsp;&nbsp;<?php echo $row['hr'] ?>&nbsp; %</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="208"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE 
      DEL RESPONSABLE :</strong></font></td>
    <td width="428">&nbsp;&nbsp; 
      <?php 
	$consul="SELECT * FROM users WHERE login_usr='$row[nombresp]'";
	$resul=mysql_query($consul);
	$fila=mysql_fetch_array($resul);	
	echo $fila['nom_usr']."&nbsp;".$fila['apa_usr']."&nbsp;".$fila['ama_usr'];?>
      &nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="152"><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES:</strong></font></td>
    <td width="484">&nbsp;&nbsp;<?php echo $row['observ']; ?>&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
</body>
</html>