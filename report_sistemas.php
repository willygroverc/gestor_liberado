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
<title>ESTADÍSTICAS DE TIPOS DE SISTEMAS</title>
</head>
</html>
<?php
require ("conexion.php");
//==========CONTRATOS=================
//NUMERO TOTAL DE SISTEMAS
$sql = "SELECT COUNT(Id_Sistema) AS numtot FROM sistemas";
$row=mysql_fetch_array(mysql_query($sql));
//NUMERO DE SISTEMAS DE APLICACIÓN
$sql1 = "SELECT COUNT(Id_Sistema) AS num_apli FROM sistemas WHERE Id_Tipo='APLICACION'";
$row1=mysql_fetch_array(mysql_query($sql1));
//NUMERO DE SISTEMAS DE OFIMÁTICA
$sql2 = "SELECT COUNT(Id_Sistema) AS num_ofim FROM sistemas WHERE Id_Tipo='OFIMATICA'";
$row2=mysql_fetch_array(mysql_query($sql2));
//NUMERO DE SISTEMAS DE SISTEMA OPERATIVO
$sql3 = "SELECT COUNT(Id_Sistema) AS num_so FROM sistemas WHERE Id_Tipo='SISTEMA OPERATIVO'";
$row3 = mysql_fetch_array(mysql_query($sql3));
//MUMERO DE SISTEMAS DE BASE DE DATOS
$sql4 = "SELECT COUNT(Id_Sistema) AS num_bd FROM sistemas WHERE Id_Tipo='BASE DE DATOS'";
$row4 = mysql_fetch_array(mysql_query($sql4));
//MUMERO DE SISTEMAS UTILITARIO
$sql5 = "SELECT COUNT(Id_Sistema) AS num_utili FROM sistemas WHERE Id_Tipo='UTILITARIO'";
$row5 = mysql_fetch_array(mysql_query($sql5));
//MUMERO DE SISTEMAS VARIOS
$sql6 = "SELECT COUNT(Id_Sistema) AS num_var FROM sistemas WHERE Id_Tipo='VARIOS'";
$row6 = mysql_fetch_array(mysql_query($sql6));

if ($row[0]<>"0")
{$papli=intval($row1['num_apli']*100/$row[0],10);
$pofim=intval($row2['num_ofim']*100/$row[0],10);
$pso=intval($row3['num_so']*100/$row[0],10);
$pbd=intval($row4['num_bd']*100/$row[0],10);
$putili=intval($row5['num_utili']*100/$row[0],10);
$pvar=intval($row6['num_var']*100/$row[0],10);}
else
{$papli="0"; $pofim="0"; $pso="0"; $pbd="0"; $putili="0"; $pvar="0";}

?>
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr align="center"> 
    <th width="308" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">TIPOS 
      DE SISTEMAS</font></th>
    <th width="81" background="images/main-button-tileR2.jpg"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">Cantidad</font></th>
    <th width="74" background="images/main-button-tileR2.jpg"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">%</font></th>
    <th width="145" background="images/main-button-tileR2.jpg"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
  </tr>
  <tr> 
    <td height="15" colspan="4"></td>
  </tr>
  <tr> 
    <td height="15" width="308"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Aplicacion</font></td>
    <td height="15" width="81"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['num_apli'];?>&nbsp;</font></div></td>
    <td height="15" width="74"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $papli;?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td width="145" height="15" bgcolor="#006699"><div align="left"></div>
      <font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$papli% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="12" colspan="4"></td>
  </tr>
  <tr> 
    <td width="308" height="15"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Ofimatica</font></div></td>
    <td width="81"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['num_ofim'];?></font></div></td>
    <td width="74"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pofim;?> 
        %&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td nowrap width="145" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pofim% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="12" colspan="4"></td>
  </tr>
  <tr> 
    <td width="308"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Sistema 
      Operativo </font></td>
    <td width="81"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row3['num_so'];?></font></div></td>
    <td width="74"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pso;?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td nowrap width="145" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pso% SRC=images/barra.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="14" colspan="4"></td>
  </tr>
  <tr> 
    <td width="308" height="21"> <div align="left">&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">Base 
        de Datos</font></div></td>
    <td width="81"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row4['num_bd'];?></font></div></td>
    <td width="74"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pbd;?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td nowrap width="145" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pbd% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="14" colspan="4"></td>
  </tr>
  <tr> 
    <td height="21"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Utilitario</font></td>
    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row5['num_utili'];?></font></div></td>
    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $putili;?>&nbsp;%</font></div></td>
    <td nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$putili% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="16" colspan="4"></td>
  </tr>
  <tr> 
    <td height="15">&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">Varios</font></td>
    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row6['num_var'];?></font></div></td>
    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $pvar;?>&nbsp;%</font></div></td>
    <td nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pvar% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="15" colspan="4"></td>
  </tr>
  <tr> 
    <th width="308" height="21" nowrap bgcolor="#CCCCCC"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Nro 
        TOTAL DE SISTEMAS</font></div></th>
    <td width="81" bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['numtot'];?></font></strong></div></td>
    <td width="74" bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;100%&nbsp;&nbsp;&nbsp;&nbsp;</font></strong></div></td>
    <td nowrap width="145" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=100% SRC=images/barra.jpg>";?></font></td>
  </tr>
</table>
<div align="center"><br>
  <strong><font size="2" face="Arial, Helvetica, sans-serif">Nota : </font></strong><font size="2" face="Arial, Helvetica, sans-serif">En 
  algunos casos, la suma estadistica tiene un error de 1% por motivos de redondeo.</font></div>
