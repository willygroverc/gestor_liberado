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
?>
<html>
<head>
<title>ESTADISTICAS - TEMPERATURA Y HUMEDAD RELATIVA</title>
</head>
</html>
<?php
include ("conexion.php");
//==========CONTRATOS=================
//NUMERO TOTAL DE REGISTROS
$sql = "SELECT COUNT(numero) AS numtot FROM controltemp";
$row=mysql_fetch_array(mysql_query($sql));
//TEMPERATURA PROMEDIO
$sql1 = "SELECT ROUND(AVG(temperatura),2) AS temp_pro FROM controltemp";
$row1=mysql_fetch_array(mysql_query($sql1));
//TEMPERATURA MAXIMA
$sql2 = "SELECT MAX(temperatura) AS temp_max FROM controltemp";
$row2=mysql_fetch_array(mysql_query($sql2));
//TEMPERATURA MÍNIMA
$sql3 = "SELECT MIN(temperatura) AS temp_min FROM controltemp";
$row3 = mysql_fetch_array(mysql_query($sql3));
//HUMEDAD RELATIVA PROMEDIO
$sql4 = "SELECT ROUND(AVG(hr),2) AS hr_pro FROM controltemp";
$row4 = mysql_fetch_array(mysql_query($sql4));
//HUMEDAD RELATIVA MAXIMA
$sql5 = "SELECT MAX(hr) AS hr_max FROM controltemp";
$row5 = mysql_fetch_array(mysql_query($sql5));
//HUMEDAD RELATIVA MINIMA
$sql6 = "SELECT MIN(hr) AS hr_min FROM controltemp";
$row6 = mysql_fetch_array(mysql_query($sql6));
?>
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <th width="304" align="center" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CONTROL 
      DE TEMPERATURA Y HUMEDAD RELATIVA</font></th>
    <th width="100" align="center" bgcolor="#006699"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">CIFRAS</font></th>
  </tr>
  <tr> 
    <td height="15" colspan="2"></td>
  </tr>
  <tr> 
    <td height="21" width="304"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Temperatura 
      Promedio </font></td>
    <td height="21"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['temp_pro'];?>&nbsp;&ordm;C</font></div></td>
  </tr>
  <tr align="center"> 
    <td height="21"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Temperatura 
        Maxima</font></div></td>
    <td height="21"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['temp_max'];?> 
      &ordm;C </font></td>
  </tr>
  <tr> 
    <td width="304" height="15"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Temperatura 
        Minima</font></div></td>
    <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row3['temp_min'];?> 
        &ordm;C </font></div></td>
  </tr>
  <tr> 
    <td height="17" colspan="2"></td>
  </tr>
  <tr> 
    <td width="304"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Humedad 
      Relativa Promedio</font></td>
    <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row4['hr_pro'];?> 
        % </font></div></td>
  </tr>
  <tr> 
    <td height="19">&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">Humedad 
      Relativa</font> <font size="2" face="Arial, Helvetica, sans-serif">Maxima</font></td>
    <td height="19"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row5['hr_max'];?> 
        % </font></div></td>
  </tr>
  <tr> 
    <td width="304" height="15"> <div align="left">&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">Humedad 
        Relativa Minima</font></div></td>
    <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row6['hr_min'];?> 
        % </font></div></td>
  </tr>
  <tr> 
    <td height="15" colspan="2"></td>
  </tr>
  <tr> 
    <th width="304" height="21" nowrap bgcolor="#CCCCCC"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Nro 
        TOTAL DE REGISTROS</font></div></th>
    <td bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['numtot'];?></font></strong></div></td>
  </tr>
</table>
<div align="center"></div>
