<html>
<head>
<title>ESTAD�STICAS DE CONTRATOS</title>
</head>
</html>
<?php
include ("conexion.php");
//==========CONTRATOS=================
//NUMERO TOTAL DE CONTRATOS
$sql = "SELECT COUNT(IdContra) AS numtot FROM contratodatos";
$row=mysql_fetch_array(mysql_db_query($db,$sql,$link));

//NUMERO DE CONTRATOS VENCIDOS
$fechahoy=date("Y-m-d");
$sql1 = "SELECT COUNT(IdContra) AS venc FROM contratodatos WHERE FechAl<'$fechahoy' AND Ejecucion='0' AND Cierre='0'";
$row1=mysql_fetch_array(mysql_db_query($db,$sql1,$link));
//NUMERO DE CONTRATOS VENCIDOS PERO EN EJECUCI�N
$sql2 = "SELECT COUNT(IdContra) AS vencejec FROM contratodatos WHERE FechAl<'$fechahoy' AND Ejecucion='1' AND Cierre='0'";
$row2=mysql_fetch_array(mysql_db_query($db,$sql2,$link));
//NUMERO DE CONTRATOS EN VIGENCIA
$sql3 = "SELECT COUNT(IdContra) AS vig FROM contratodatos WHERE FechAl>='$fechahoy' AND Cierre='0'";
$row3 = mysql_fetch_array(mysql_db_query($db,$sql3,$link));

//MUMERO DE CONTRATOS EN CIERRE
$sql4 = "SELECT COUNT(IdContra) AS cierre FROM contratodatos WHERE Cierre='1'";
$row4 = mysql_fetch_array(mysql_db_query($db,$sql4,$link));

if ($row[0]<>"0")
{$pvenc=intval($row1['venc']*100/$row[0],10);
$pvencejec=intval($row2['vencejec']*100/$row[0],10);
$pvig=intval($row3['vig']*100/$row[0],10);
$pcierre=intval($row4['cierre']*100/$row[0],10);
//corregido $rowo A $row1 no devolvia ningun valor  
$pcontra=round($row1['venc']*100/$row[0]);
}
else
{$pvenc="0"; $pvencejec="0"; $pvig="0"; $pcierre="0";$pcontra="0";}

?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr align="center"> 
    <th width="520" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CONTRATOS</font></th>
    <th width="96" background="images/main-button-tileR1.jpg"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">Cantidad</font></th>
    <th width="89" background="images/main-button-tileR1.jpg"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">%</font></th>
    <th background="images/main-button-tileR1.jpg"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp;</font></th>
  </tr>
  <tr> 
    <td height="15" colspan="4"></td>
  </tr>
  <tr> 
    <td height="15"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Vencidos 
      o Caducados</font></td>
    <td height="15"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['venc'];?>&nbsp;</font></div></td>
    <td height="15"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pvenc;?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td width="251" height="15" bgcolor="#006699"><div align="left"></div>
      <font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pvenc% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="12" colspan="4"></td>
  </tr>
  <tr> 
    <td height="15"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Vencidos 
        pero en Ejecucion</font></div></td>
    <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['vencejec'];?></font></div></td>
    <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pvencejec;?> 
        %&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pvencejec% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="12" colspan="4"></td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;En 
      Vigencia</font></td>
    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row3['vig'];?></font></div></td>
    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pvig;?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pvig% SRC=images/barra.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="14" colspan="4"></td>
  </tr>
  <tr> 
    <td height="15"> <div align="left">&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">Cerrados</font></div></td>
    <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row4['cierre'];?></font></div></td>
    <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pcierre;?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pcierre% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="15" colspan="4"></td>
	<tr> 
	<?php
	$sqlcont="SELECT tmp_alert FROM control_parametros";
	$resultcont=mysql_db_query($db,$sqlcont,$link);
	$rowcont=mysql_fetch_array($resultcont);
	$sqlo="SELECT count(IdContra) as venc FROM contratodatos WHERE FechAl BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 60 DAY) ORDER BY FechAl";
	$reso=mysql_db_query($db,$sqlo,$link);
	$rowo=mysql_fetch_array($reso);
	?>
    <td height="15"> <div align="left">&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">N&ordm; 
        de contratos por vencerse en los pr&oacute;ximos <?php echo $rowcont['tmp_alert']?> días</font></div></td>
    <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $rowo['venc'];?></font></div></td>
    <td> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $pcontra;?>&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
    <td nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=$pcontra% SRC=images/barra1.jpg>";?></font></td>
  </tr>
  <tr> 
    <td height="15" colspan="4"></td>
  </tr>
  <tr> 
    <th height="21" nowrap bgcolor="#CCCCCC"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Nro 
        TOTAL DE CONTRATOS</font></div></th>
    <td bgcolor="#CCCCCC"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['numtot'];?></font></strong></div></td>
    <td bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;100%&nbsp;&nbsp;&nbsp;&nbsp;</font></strong></div></td>
    <td nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo "<IMG HEIGHT=18 WIDTH=100% SRC=images/barra.jpg>";?></font></td>
  </tr>
</table>
<div align="center"><br>
  <strong><font size="2" face="Arial, Helvetica, sans-serif">Nota : </font></strong><font size="2" face="Arial, Helvetica, sans-serif">En 
  algunos casos, la suma estadistica tiene un error de 1% por motivos de redondeo.</font></div>
