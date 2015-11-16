<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Se ha incrementado 4 campos: nivel de riesgo, descripcion de riesgo,
//				nivel de calidad, descricion de calidad
// Fecha: 		15/JUN/2014
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require('conexion.php');
include("top_ver.php");
$idprov=($_GET['variable']);
$sql="SELECT * FROM proveedor WHERE IdProv='$idprov'";
$resul=mysql_query($sql);
$row=mysql_fetch_array($resul);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - PROVEEDORES</title>
<style type="text/css">
<!--
.line {
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-top-color: #000000;
	border-right-color: #000000;
	border-bottom-color: #000000;
	border-left-color: #000000;
}
-->
</style>
</head>
<body>
<p><?php
include("datos_gral.php");
?>
<table width="590" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr> 
    <td colspan="4"><div align="center"><strong><font size="4" face="Arial, Helvetica, sans-serif"><u>PROVEEDOR</u></font></strong></div></td>
  </tr>
  <tr> 
    <td width="172">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">NUMERO DE PROVEEDOR:</font></strong></td>
    <td colspan="2" class="line"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['IdProv'] ?></font></td>
   
  </tr>
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE :</font></strong></td>
    <td colspan="2" class="line"><font face="Arial, Helvetica, sans-serif"><?php echo $row['NombProv'];?></font></td>
    <td class="line">&nbsp;</td>
  </tr>
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">DIRECCION :</font></strong></td>
    <td colspan="3" class="line"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['DirecProv']; ?></font></td>
  </tr>
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">TELEFONO 1 :</font></strong></td>
    <td width="138" class="line"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['Fono1Prov']; ?></font></td>
    <td width="104"><strong><font size="2" face="Arial, Helvetica, sans-serif">TELEFONO 2:</font></strong></td>
    <td width="144" class="line"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['Fono2Prov']; ?></font></td>
  </tr>
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">ENCARGADO :</font></strong></td>
    <td colspan="3" class="line"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['EncProv']; ?></font></td>
  </tr>
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">E-MAIL :</font></strong></td>
    <td colspan="2" class="line"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['EmailProv']; ?></font></td>
    <td class="line">&nbsp;</td>
  </tr>
  
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">CLASIFICACION :</font></strong></td>
    <td colspan="2" class="line"><font size="2" face="Arial, Helvetica, sans-serif">
	<?php
	/*$sqlT="SELECT servicio_nombre FROM t_servicio where servicio_cod='$row[nivel1]'";
	$resultT=mysql_query($sqlT);
	$filaT=mysql_fetch_array($resultT);
		echo $filaT['servicio_nombre']; 
	*/
	?></font>
	</td>
    <td class="line">&nbsp;</td>
  </tr>
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">SERVICIO:</font></strong></td>
    <td colspan="2" class="line"><font size="2" face="Arial, Helvetica, sans-serif">
	<?php
	/*$sqlT2="SELECT servicio2 FROM t_servicio2 where id_serv2='$row[nivel2]'";
	$resultT2=mysql_query($sqlT2);
	$filaT2=mysql_fetch_array($resultT2);
		echo $filaT2['servicio2']; 
	*/
	?></font>
	</td>
    <td class="line">&nbsp;</td>
  </tr>
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">NIVEL DE RIESGO:</font></strong></td>
    <td colspan="2" class="line"><font size="2" face="Arial, Helvetica, sans-serif"><?php //echo $row['nivelRiesgo']; ?></font></td>
    <td class="line">&nbsp;</td>
  </tr>
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">DESCRIPCION DE RIESGO:</font></strong></td>
    <td colspan="2" class="line"><font size="2" face="Arial, Helvetica, sans-serif"><?php //echo $row['descRiesgo']; ?></font></td>
    <td class="line">&nbsp;</td>
  </tr>  
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">NIVEL DE CALIDAD:</font></strong></td>
    <td colspan="2" class="line"><font size="2" face="Arial, Helvetica, sans-serif"><?php //echo $row['nivelCalidad']; ?></font></td>
    <td class="line">&nbsp;</td>
  </tr>
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">DESCRIPCION DE CALIDAD:</font></strong></td>
    <td colspan="2" class="line"><font size="2" face="Arial, Helvetica, sans-serif"><?php //echo $row['descCalidad']; ?></font></td>
    <td class="line">&nbsp;</td>
  </tr>
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES : </font></strong></td>
    <td colspan="3" class="line"><font size="2" face="Arial, Helvetica, sans-serif"><?php //echo $row['ObsProv']; ?></font></td>
  </tr>
</table>
</body>
</html>