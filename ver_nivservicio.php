<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include("top_ver.php");
$idserv=($_GET['variable']);
$sql="SELECT *, DATE_FORMAT(vigencia, '%d/%m/%Y') AS vigencia from nivservicio WHERE id_servi='$idserv'";
$resul=mysql_query($sql);
$row=mysql_fetch_array($resul);
	$tip_t="tec";
 	$tip_t2=md5($tip_t);
	$tip_p="prov";
	$tip_p2=md5($tip_p);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - ACUERDO DE NIVEL DE SERVICIO </title>
<style type="text/css">
<!--
td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>
<body>
<p><?php
include("datos_gral.php");
?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font size="4" face="Arial, Helvetica, sans-serif"><u>ACUERDO DE NIVEL DE SERVICIO</u></font></strong></div></td>
  </tr>
</table>

 
<br>
<table  width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="189"><strong><font size="2" face="Arial, Helvetica, sans-serif">NUMERO 
      DE SERVICIO : </font></strong></td>
    <td width="92">&nbsp;&nbsp;&nbsp;<?php echo $row['id_servi'];?> <div align="center"></div></td>
    <td width="355">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
  </tr>
</table>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="189"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE 
      DEL TECNICO: </strong>      </font></td>
    <td width="447">
	<?php 
	$consul="SELECT * FROM users WHERE login_usr='".$row['tecnico']."'";
	$resul=mysql_query($consul);
	$fila=mysql_fetch_array($resul);
	if (!empty($fila))	
	{echo $fila['nom_usr']."&nbsp;".$fila['apa_usr']."&nbsp;".$fila['ama_usr'];}
	else
	{$consul = "SELECT * FROM proveedor WHERE IdProv='".$row['tecnico']."'";
     $resul = mysql_query($consul);
     $fila = mysql_fetch_array($resul);
	 echo "&nbsp;".$fila['NombProv'];}
	?>
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
    <td width="129"><strong><font size="2" face="Arial, Helvetica, sans-serif">DESCRIPCION:</font></strong></td>
    <td width="507"><?php echo $row['desc_ser'];?>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>

</table>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABILIDAD 
      Y PRE REQUISITOS</font></strong></td>

</table>
<br>
<table width="634" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="51">&nbsp;</td>
    <td width="132"><strong><font size="2" face="Arial, Helvetica, sans-serif">1.- CLIENTE:</font></strong></td>
    <td width="451"><?php echo $row['clie_ser']; ?>&nbsp;</td>
  </tr>
  <tr> 
    <td></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="636" height="22" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="53">&nbsp;</td>
    <td width="132"><strong><font size="2" face="Arial, Helvetica, sans-serif">2.-ESPECIALISTA:</font></strong></td>
    <td width="451"><?php echo $row['especiali']; ?>&nbsp;</td>
  </tr>
  <tr> 
    <td></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="638" height="23" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="51">&nbsp;</td>
    <td width="135"><strong><font size="2" face="Arial, Helvetica, sans-serif">3.- NEGOCIO:</font></strong></td>
    <td width="452"><?php echo $row['negocios']; ?>&nbsp;</td>
  </tr>
  <tr> 
    <td></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="162"><strong><font size="2" face="Arial, Helvetica, sans-serif">TIEMPO 
      DE SERVICIO:</font></strong></td>
    <td width="105"><?php echo $row['tiem_ser']; ?>&nbsp;</td>
    <td width="109">&nbsp;</td>
    <td width="161"><strong><font size="2" face="Arial, Helvetica, sans-serif">HORARIO 
      DE SERVICIO:</font></strong></td>
    <td width="99"><?php echo $row['hora_ser']; ?></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="162"><strong><font size="2" face="Arial, Helvetica, sans-serif">VIGENCIA:</font></strong></td>
    <td width="105"><?php echo $row['vigencia']; ?>&nbsp;</td>
    <td width="369">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>