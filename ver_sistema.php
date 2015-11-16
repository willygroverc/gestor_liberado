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
$idsis=$variable;
$sql="SELECT * FROM sistemas WHERE Id_Sistema='$idsis'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?>
<html>
<head>
<title> GesTor F1 - PRODUCCIÓN-PROAPD - PROPIETARIOS Y RESPONSABLES</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font size="4" face="Arial, Helvetica, sans-serif"><u>PROPIETARIOS Y RESPONSABLES </u>
        </font></strong></div></td>
  </tr>
</table>

<br>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NUMERO 
      DE SISTEMA</strong></font></td>
    <td>&nbsp;<?php echo $row['Id_Sistema'];?>&nbsp;</td>
  </tr>
    <tr> 
    <td width="200" height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SISTEMA</strong></font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['Descripcion']; ?></font></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">I.- UNIDAD DE SISTEMA</font></strong></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif">1.- NOMBRE 
      DEL TITULAR</font></td>
    <td>
	<?php 
	$sql2="SELECT * FROM users WHERE login_usr='$row[Titular1]'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	echo $row2['nom_usr']."&nbsp;".$row2['apa_usr']."&nbsp;".$row2['ama_usr'];?>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif">2.-NOMBRE 
      DEL SUPLENTE </font></td>
    <td>	
	<?php 
	$sql3="SELECT * FROM users WHERE login_usr='$row[Suplente1]'";
	$result3=mysql_query($sql3);
	$row3=mysql_fetch_array($result3);
	echo $row3['nom_usr']."&nbsp;".$row3['apa_usr']."&nbsp;".$row3['ama_usr'];?>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">II.-DUENO</font></strong></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif">1.- AREA</font></td>
    <td><?php echo $row['Area']; ?>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif">2.- NOMBRE DEL TITULAR</font></td>
    <td>	
	<?php 
	$sql4="SELECT * FROM users WHERE login_usr='$row[Titular2]'";
	$result4=mysql_query($sql4);
	$row4=mysql_fetch_array($result4);
	echo $row4['nom_usr']."&nbsp;".$row4['apa_usr']."&nbsp;".$row4['ama_usr'];?>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif">3.- NOMBRE DEL SUPLENTE 
      </font></td>
    <td>	
	<?php 
	$sql5="SELECT * FROM users WHERE login_usr='$row[Suplente2]'";
	$result5=mysql_query($sql5);
	$row5=mysql_fetch_array($result5);
	echo $row5['nom_usr']."&nbsp;".$row5['apa_usr']."&nbsp;".$row5['ama_usr'];?>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
   </tr>
</table>
</body>
</html>