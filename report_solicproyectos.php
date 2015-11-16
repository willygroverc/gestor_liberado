<?php
// version: 	1.0
// Tipo: 		Perfectivo, Correctivo
// Objetivo:	Control acceso directo No autorizado.
//				Modificacion funciones php obsoletas para version 5.3
// Fecha:		23/NOV/2012 
// Autor:		Cesar Cuenca
//____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if (isset($_SESSION['tipo']) && $_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}
require ("conexion.php");

//==========CONTRATOS=================
//NUMERO TOTAL DE SOLICITUD DE PROYECTOS
$sql = "SELECT COUNT(Codigo) AS numtot FROM solicproydatos";
$row=mysql_fetch_array(mysql_query($sql));
//NUMERO DE PROYECTOS EN PLANIFICACIÓN
$sql1 = "SELECT COUNT(DISTINCT Codigo) AS planif FROM solicproyplanif";
$row1=mysql_fetch_array(mysql_query($sql1));
//NUMERO DE PROYECTOS EN EJECUCIÓN
$sql2 = "SELECT COUNT(DISTINCT Codigo) AS ejecuc FROM solicproyejecucion";
$row2=mysql_fetch_array(mysql_query($sql2));
$plan = $row1['planif']-$row2['ejecuc'];
//NUMERO DE PROYECTOS EN CONTROL
$sql3 = "SELECT COUNT(DISTINCT Codigo) AS control FROM solicproycontrol";
$row3 = mysql_fetch_array(mysql_query($sql3));
$ejec = $row2['ejecuc']-$row3['control'];
//MUMERO DE PROYECTOS EN CIERRE
$sql4 = "SELECT COUNT(DISTINCT Codigo) AS cierre FROM solicproycierre";
$row4 = mysql_fetch_array(mysql_query($sql4));
$cont = $row3['control']-$row4['cierre'];
//MUMERO DE PROYECTOS SIN NADA
$nada="0";
$sql5 = "SELECT Codigo FROM solicproydatos";
$result5=mysql_query($sql5);
while($row5=mysql_fetch_array($result5))
{	$sql6 = "SELECT Codigo FROM solicproyplanif WHERE Codigo='$row5[Codigo]'";
	$row6 = mysql_fetch_array(mysql_query($sql6));
	$sql7 = "SELECT Codigo FROM solicproyejecucion WHERE Codigo='$row5[Codigo]'";
	$row7 = mysql_fetch_array(mysql_query($sql7));
	$sql8 = "SELECT Codigo FROM solicproycontrol WHERE Codigo='$row5[Codigo]'";
	$row8 = mysql_fetch_array(mysql_query($sql8));
	$sql9 = "SELECT Codigo FROM solicproycierre WHERE Codigo='$row5[Codigo]'";
	$row9 = mysql_fetch_array(mysql_query($sql9));
	if (!$row6['Codigo'] AND !$row7['Codigo'] AND !$row8['Codigo'] AND !$row9['Codigo'])
		{$nada=$nada+1;}
}
if ($row[0]<>"0")
{$pplanif=intval($plan*100/$row[0],10);
$pejecuc=intval($ejec*100/$row[0],10);
$pcontrol=intval($cont*100/$row[0],10);
$pcierre=intval($row4['cierre']*100/$row[0],10);
$pnada=intval($nada*100/$row[0],10);}
else
{$pplanif="0"; $pejecuc="0"; $pcontrol="0"; $pcierre="0"; $pnada="0";}

?> 
<html>
<head>
<title>ESTADÍSTICAS DE SOLICITUD DE PROYECTOS</title>
</head>
</html>
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr align="center"> 
    <th width="286" background="images/main-button-tileR1.jpg" height="20"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SOLICITUD 
      DE PROYECTOS</font></th>
    <th width="70" background="images/main-button-tileR1.jpg" height="20"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">Cantidad</font></th>
    <th width="78" background="images/main-button-tileR1.jpg" height="20"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">%</font></th>
    <th width="142" background="images/main-button-tileR1.jpg" height="20"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
  </tr>
  <tr> 
    <td height="15" colspan="4"></td>
  </tr>
  <tr> 
    <td height="15" width="286"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Fase 
      de Planificacion</font></td>
    <td height="15" width="70"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $plan;?>&nbsp;</font></div></td>
    <td height="15" width="78"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pplanif;?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td width="142" height="15" bgcolor="#006699"><div align="left"></div>
      <font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pplanif% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="12" colspan="4"></td>
  </tr>
  <tr> 
    <td width="286" height="15"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Fase 
        de Ejecucion</font></div></td>
    <td width="70"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $ejec;?></font></div></td>
    <td width="78"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pejecuc;?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td nowrap width="142" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pejecuc% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="12" colspan="4"></td>
  </tr>
  <tr> 
    <td width="286"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Fase 
      de Control</font></td>
    <td width="70"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $cont;?></font></div></td>
    <td width="78"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pcontrol;?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td nowrap width="142" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pcontrol% SRC=images/barra.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="14" colspan="4"></td>
  </tr>
  <tr> 
    <td width="286" height="15"> <div align="left">&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">Fase 
        de Cierre</font></div></td>
    <td width="70"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row4['cierre'];?></font></div></td>
    <td width="78"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pcierre;?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td nowrap width="142" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pcierre% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="15" colspan="4"></td>
  </tr>
  <tr> 
    <td width="286" height="15">&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">En ninguna Fase</font></td>
    <td width="70"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $nada;?></font></div></td>
    <td width="78"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<?php echo $pnada;?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td nowrap width="142" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pnada% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="15" colspan="4"></td>
  </tr>
  <tr> 
    <th width="286" height="21" nowrap bgcolor="#CCCCCC"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Nro 
        TOTAL DE SOLICITUD DE PROYECTOS</font></div></th>
    <td width="70" bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['numtot'];?></font></strong></div></td>
    <td width="78" bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;100%&nbsp;&nbsp;&nbsp;&nbsp;</font></strong></div></td>
    <td nowrap width="142" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=100% SRC=images/barra.jpg>";?></font></td>
  </tr>
</table>

<div align="center"><br>
  <strong><font size="2" face="Arial, Helvetica, sans-serif">Nota : </font></strong><font size="2" face="Arial, Helvetica, sans-serif">En 
  algunos casos, la suma estadistica tiene un error de 1% por motivos de redondeo.</font></div>
