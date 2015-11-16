<html>
<head>
<title>ESTADÍSTICAS DE CAMBIOS EN PRODUCCION</title>
</head>
</html>
<?php
include ("conexion.php");

//==========CONTRATOS=================
//NUMERO TOTAL DE SOLICITUD DE PROYECTOS
$sql = "SELECT COUNT(Codigo) AS numtot FROM soliccambiodatos";
$row=mysql_fetch_array(mysql_db_query($db,$sql,$link));
//NUMERO DE PROYECTOS EN PLANIFICACIÓN
$sql1 = "SELECT COUNT(DISTINCT Codigo) AS planif FROM soliccambioplanif";
$row1=mysql_fetch_array(mysql_db_query($db,$sql1,$link));
//NUMERO DE PROYECTOS EN EJECUCIÓN
$sql2 = "SELECT COUNT(DISTINCT Codigo) AS ejecuc FROM soliccambioejecucion";
$row2=mysql_fetch_array(mysql_db_query($db,$sql2,$link));
$plan = $row1['planif']-$row2['ejecuc'];
//NUMERO DE PROYECTOS EN CONTROL
$sql3 = "SELECT COUNT(DISTINCT Codigo) AS control FROM soliccambiocontrol";
$row3 = mysql_fetch_array(mysql_db_query($db,$sql3,$link));
$ejec = $row2['ejecuc']-$row3['control'];
//MUMERO DE PROYECTOS EN CIERRE
$sql4 = "SELECT COUNT(DISTINCT Codigo) AS cierre FROM soliccambiocierre";
$row4 = mysql_fetch_array(mysql_db_query($db,$sql4,$link));
$cont = $row3['control']-$row4['cierre'];
//MUMERO DE PROYECTOS SIN NADA
$nada="0";
$sql5 = "SELECT Codigo FROM soliccambiodatos";
$result5=mysql_db_query($db,$sql5,$link);
while($row5=mysql_fetch_array($result5))
{	$sql6 = "SELECT Codigo FROM soliccambioplanif WHERE Codigo='$row5[Codigo]'";
	$row6 = mysql_fetch_array(mysql_db_query($db,$sql6,$link));
	$sql7 = "SELECT Codigo FROM soliccambioejecucion WHERE Codigo='$row5[Codigo]'";
	$row7 = mysql_fetch_array(mysql_db_query($db,$sql7,$link));
	$sql8 = "SELECT Codigo FROM soliccambiocontrol WHERE Codigo='$row5[Codigo]'";
	$row8 = mysql_fetch_array(mysql_db_query($db,$sql8,$link));
	$sql9 = "SELECT Codigo FROM soliccambiocierre WHERE Codigo='$row5[Codigo]'";
	$row9 = mysql_fetch_array(mysql_db_query($db,$sql9,$link));
	/*if (!$row6[Codigo] AND !$row7[Codigo] AND !$row8[Codigo] AND !$row9[Codigo])
		{$nada=$nada+1;}*/
}
$num_cam=0;
$sqle = "SELECT DISTINCT(id_orden), MAX(id_asig) AS id_asig FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";
$resulte=mysql_db_query($db,$sqle,$link);
while($rowe=mysql_fetch_array($resulte)) 
{
	$sql1e = "SELECT area FROM asignacion WHERE id_asig='$rowe[id_asig]'";
	$result1e=mysql_db_query($db,$sql1e,$link);
	$row1e=mysql_fetch_array($result1e);
	if ($row1e['area']=="Cambios"){ $num_cam=$num_cam+1;}
}
$nada=$num_cam-$row[0];

if ($row[0]<>"0")
{
$soli=$row[0]-$plan-$ejec-$cont-$row4['cierre'];
$psolic=intval($soli*100/$row[0],10);
$pplanif=intval($plan*100/$row[0],10);
$pejecuc=intval($ejec*100/$row[0],10);
$pcontrol=intval($cont*100/$row[0],10);
$pcierre=intval($row4['cierre']*100/$row[0],10);
$pnada=intval($nada*100/$row[0],10);}
else
{$psolic=0; $pplanif="0"; $pejecuc="0"; $pcontrol="0"; $pcierre="0"; $pnada="0";}

?> 
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr align="center"> 
    <th width="286" background="images/main-button-tileR1.jpg" height="20"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CAMBIOS 
      EN PRODUCCION</font></th>
    <th width="70" background="images/main-button-tileR1.jpg" height="20"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">Cantidad</font></th>
    <th width="78" background="images/main-button-tileR1.jpg" height="20"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">%</font></th>
    <th width="142" background="images/main-button-tileR1.jpg" height="20"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
  </tr>
  <tr> 
    <td height="15" colspan="4"></td>
  </tr>
  <tr> 
    <td height="15" width="286"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Fase 
      de Solicitud</font></td>
    <td height="15" width="70"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $soli;?>&nbsp;</font></div></td>
    <td height="15" width="78"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pplanif;?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td width="142" height="15" bgcolor="#006699"><div align="left"></div>
      <font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$psolic% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="12" colspan="4"></td>
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
        TOTAL DE CAMBIOS EN PRODUCCION</font></div></th>
    <td width="70" bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['numtot'];?></font></strong></div></td>
    <td width="78" bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;100%&nbsp;&nbsp;&nbsp;&nbsp;</font></strong></div></td>
    <td nowrap width="142" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=100% SRC=images/barra.jpg>";?></font></td>
  </tr>
</table>

<div align="center"><br>
  <strong><font size="2" face="Arial, Helvetica, sans-serif">Nota : </font></strong><font size="2" face="Arial, Helvetica, sans-serif">En 
  algunos casos, la suma estadistica tiene un error de 1% por motivos de redondeo.</font></div>
