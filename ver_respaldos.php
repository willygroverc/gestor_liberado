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
include ("top_ver.php");
require_once('funciones.php');
$codub=SanitizeString($_GET['codub']);
$sql = "SELECT * FROM ubicacionresp WHERE codub='$codub' ";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?>
<html>
<head>
	<title> GesTor F1 - PRODUCCIÓN-PROAPD - UBICACIÓN DE RESPALDOS</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<p>
<?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font size="4" face="Arial, Helvetica, sans-serif"><b><u><font size="4" face="Arial, Helvetica, sans-serif">UBICACION DE RESPALDOS</font></u></b> </font></strong></div></td>
  </tr>		
</table><BR>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>  <?php 		
  		$sql2 = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ubicacionresp  WHERE codub='$codub'";
		$result2=mysql_query($sql2);
		while($row2=mysql_fetch_array($result2)) 
  		{
  		?>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CODIGO :</strong></font></td>
    <td>&nbsp;<font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $row2['codigo'];?></strong></font>&nbsp;</td>
  </tr>
  <tr>
    <td width="200" height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<BR>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><?php 			
	$sql0="SELECT * FROM controlinvent WHERE Codigo='$row2[codigo]'";
	$result0=mysql_query($sql0);
	$row0=mysql_fetch_array($result0);
	?>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>TIPO : </strong></font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $row0['Tipo'];?></strong></font><font size="2" face="Arial, Helvetica, sans-serif"><strong></strong></font></td>
  </tr>
  <tr>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<BR>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA :</strong></font></td>
    <td>&nbsp;<strong><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row2['fecha'];?></font></strong>&nbsp;</td>
  </tr>
  <tr>
    <td width="200" height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<BR>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CONTENIDO :</strong></font></td>
    <td>&nbsp;<font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $row2['contenido'];?></strong></font>&nbsp;</td>
  </tr>
  <tr>
    <td width="200" height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<BR>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES :</strong></font></td>
    <td>&nbsp;<strong><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row2['observ'];?></font></strong>&nbsp;</td>
  </tr>
  <tr>
    <td width="200" height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<BR>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CONTENIDO :</strong></font></td>
    <td>&nbsp;
      <table width="427" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr bgcolor="#FFFFFF">
          <td width="120"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SISTEMA</strong></font></div></td>
          <td width="149"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>EL NEGOCIO</strong></font></div></td>
          <td width="88"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SE1</strong></font></div></td>
          <td width="70"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SE2</strong></font></div></td>
        </tr>
  <td>&nbsp;&nbsp;</td>
  </tr><tr>
    <?php if  ($row2['ubi_sistema']=="1") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
		  else{ echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}?>
    <?php if  ($row2['ubi_negocio']=="1") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
    	  else{ echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}?>
    <?php if  ($row2['ubi_SE1']=="1") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
		  else{ echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";} ?>
    <?php if  ($row2['ubi_SE2']=="1") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
    	  else{ echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}?>
  </tr>
      </table>      <font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font>&nbsp;</td>
  </tr>

</table>
<p><?php 
		 }
?>
</p>
<p>&nbsp;</p>
<p><br>
</p>
<p>&nbsp;</p>
<p><br>
</p>
</body>
</html>