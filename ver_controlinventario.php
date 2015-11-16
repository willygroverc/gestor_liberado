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
include ("top_ver.php");
require_once('funciones.php');
$Codigo=SanitizeString($_GET['Codigo']);
?>
<html>
<head>
<title> GesTor F1 - PRODUCCIÓN-PROAPD - INVENTARIO DE MEDIOS</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font size="4" face="Arial, Helvetica, sans-serif"><u>INVENTARIOS DE MEDIOS DE RESPALDO </u>
        </font></strong></div></td>
  </tr>  <?php $sql2 = "SELECT *,DATE_FORMAT(FechaAlta,'%d / %m / %Y') as FechaAlta,DATE_FORMAT(FechaBaja,'%d / %m / %Y') as FechaBaja,DATE_FORMAT(FechaDestruc,'%d / %m / %Y') as FechaDestruc FROM controlinvent WHERE Codigo='$Codigo' ";
$result2=mysql_query($sql2);
while($row2=mysql_fetch_array($result2)) {?>
</table><br><br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CODIGO :</strong></font></td>
    <td>&nbsp;<font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo "$row2[codigo_usu] - $row2[tipo_medio] - $row2[tipo_dato] - $row2[nro_cds] - $row2[nro_corre]";?></strong></font>&nbsp;</td>
  </tr>
    <tr> 
    <td width="200" height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA ALTA : </strong></font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row2['FechaAlta'];?></font></strong></font></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<BR>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA BAJA :</strong></font></td>
    <td>&nbsp;<font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row2['FechaBaja'];?></font>&nbsp;</td>
  </tr>
  <tr>
    <td width="200" height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table><BR>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA DESTRUCCION :</strong></font></td>
    <td>&nbsp;<font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row2['FechaDestruc'];?></font>&nbsp;</td>
  </tr>
  <tr>
    <td width="200" height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table><BR>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES :</strong></font></td>
    <td>&nbsp;<font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row2['Observ'];?></font>&nbsp;</td>
  </tr>
  <tr>
    <td width="200" height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
  <?php 
		 }
?>
</table>
<p><br>
</p>
</body>
</html>