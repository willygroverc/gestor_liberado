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
include("top_ver.php");
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - PROVEEDORES</title>
</head>
<body>
<p><?php
include("datos_gral.php");
?>
<table width="100%" border="0">
  <tr>
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><u><strong>LISTADO 
        DE PROVEEDORES </strong></u></font></div></td>
  </tr>
</table>

<br>
<table width="100%" border="1">
  <tr bgcolor="#CCCCCC"> 
    <td width="3%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Nro.</font></strong></div></td>
    <td width="10%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE</font></strong></div></td>
    <td width="18%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">DIRECCION</font></strong></div></td>
    <td width="9%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TELEFONO 
    1</font></strong></div></td>
    <td width="9%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TELEFONO 
    2</font></strong></div></td>
    <td width="14%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">E 
    - MAIL</font></strong></div></td>
    <td width="14%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ENCARGADO</font></strong></div></td>
    <td width="14%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">CLASIFICACION</font></strong></div></td>
    <td width="14%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">SERVICIO</font></strong></div></td>
    <td width="14%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">N. RIESGO</font></strong></div></td>
    <td width="14%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">DESC. RIESGO</font></strong></div></td>
    <td width="14%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">N. CALIDAD</font></strong></div></td>
    <td width="14%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">DESC. CALIDAD</font></strong></div></td>
    <td width="22%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></div></td>
  </tr>
<?php
$sql = "SELECT * FROM proveedor ORDER BY IdProv DESC";
$result=mysql_query($sql); 
while ($row=mysql_fetch_array($result)) 
{
  	echo '<tr align="center">';
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['IdProv'].'</font></td>';
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['NombProv'].'</font></td>';
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['DirecProv'].'</font></td>';
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['Fono1Prov'].'</font></td>';
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['Fono2Prov'].'</font></td>';
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['EmailProv'].'</font></td>';
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['EncProv'].'</font></td>';
	$sqlT="SELECT servicio_nombre FROM t_servicio where servicio_cod='$row[nivel1]'";
	$resultT=mysql_query($sqlT);
	$filaT=mysql_fetch_array($resultT);
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$filaT['servicio_nombre'].'</font></td>';
	$sqlT2="SELECT servicio2 FROM t_servicio2 where id_serv2='$row[nivel2]'";
	$resultT2=mysql_query($sqlT2);
	$filaT2=mysql_fetch_array($resultT2);
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$filaT2['servicio2'].'</font></td>';
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['nivelRiesgo'].'</font></td>';
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['descRiesgo'].'</font></td>';
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['nivelCalidad'].'</font></td>';
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['descCalidad'].'</font></td>';
	echo '<td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row['ObsProv'].'</font></td>';
	echo '</tr>';
}
?>
</table>
</body>
</html>