<?php
include ("top_ver.php");
require_once('funciones.php');
$OrdAyuda=SanitizeString($_GET['IdOrden']);
if(!empty($_GET['NomCordCamb'])) $ncc=SanitizeString($_GET['NomCordCamb']);

$sql = "SELECT *,DATE_FORMAT(Fecha,'%d / %m / %Y') as Fecha,DATE_FORMAT(FechEstEnt,'%d / %m / %Y') as FechEstEnt,".
"DATE_FORMAT(FechAcep,'%d / %m / %Y') as FechAcep FROM solicitud WHERE OrdAyuda='$OrdAyuda'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);

$sql3 = "SELECT *, DATE_FORMAT(FechRespAp, '%d/%m/%Y') AS FechRespAp, DATE_FORMAT(FechUsRespAp, '%d/%m/%Y') AS FechUsRespAp,
		 DATE_FORMAT(FechComAp, '%d/%m/%Y') AS FechComAp
		 FROM aprobus WHERE OrdAyuda='$OrdAyuda'";
$result3=mysql_db_query($db,$sql3,$link);
$row3=mysql_fetch_array($result3);

$sql4 = "SELECT *, DATE_FORMAT(FechCordConf, '%d/%m/%Y') AS FechCordConf, DATE_FORMAT(FechUsConf, '%d/%m/%Y') AS FechUsConf
		 FROM implantus WHERE OrdAyuda='$OrdAyuda'";
$result4=mysql_db_query($db,$sql4,$link);
$row4=mysql_fetch_array($result4);
?>
<html>
<head>
<title> GesTor F1 - DESARROLLO Y MANTENIMIENTO-PROADM</title>
<link href="general.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>
</head>
<body>
<p><?php
include("datos_gral.php");
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> 
      <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">DESARROLLO 
        Y MANTENIMIENTO</font></u></b></div>
    </td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="164" class="titulo2">Fecha y Hora de Recepcion:</td>
    <td width="174" class="tit_form"><div align="center"><strong><?php echo $row['Fecha'];?></strong></div></td>
    <td width="11">&nbsp;</td>
    <td width="93" class="tit_form"><div align="center"><strong><?php echo $row['Hora'];?></strong></div></td>
    <td width="85" class="titulo2"><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">Rubrica: 
        </font></div></td>
    <td width="370">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td height="2" bgcolor="#000000"></td>
    <td height="2"></td>
    <td height="2" bgcolor="#000000"></td>
    <td height="2" ></td>
	<td height="2" bgcolor="#000000"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="115" class="titulo2"><font size="2" face="Arial, Helvetica, sans-serif">Asignado 
      a: </font></td>
    <td width="391" class="tit_form"><strong>
	<?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row[AsignA]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
	</strong></td>
    <td width="462" class="titulo2"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Orden 
        Mesa de Ayuda N:</font> <strong><?php echo $row['OrdAyuda'];?></strong></div></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td height="2" bgcolor="#000000"></td>
    <td height="2"></td>
  </tr> 
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="152" class="titulo2" ><font size="2" face="Arial, Helvetica, sans-serif">Viabilidad 
      :<strong> </strong>&nbsp;&nbsp;SI</font> 
      <?php 
	if ($row['Viabilidad']=="SI")
		{
		echo "<img src=\"images/si1.gif\"  >";
		}
		else
		{
		echo "<img src=\"images/no1.gif\"  >";
		}
	?>
    </td>
    <td width="62" height="21" class="tit_form"><font size="2" face="Arial, Helvetica, sans-serif">NO</font> 
      <?php 
	if ($row['Viabilidad']=="NO")
		{
		echo "<img src=\"images/si1.gif\"  >";
		}
		else
		{
		echo "<img src=\"images/no1.gif\"  >";
		}
	?>
    </td>
    <td width="67" class="titulo2"><font size="2" face="Arial, Helvetica, sans-serif">Tiempo :<strong> </strong></font></td>
    <td width="108" class="tit_form"><strong><?php echo $row['Tiempo'];?> <?php echo $row['Tiempo1'];?></strong></td>
    <td width="58" class="titulo2"><font size="2" face="Arial, Helvetica, sans-serif">Costo :</font> </td>
    <td width="85" class="tit_form"><strong><?php echo $row['CostoI'];?> <?php echo $row['MonedaI'];?></strong></td>
    <td width="124" class="titulo2"><font size="2" face="Arial, Helvetica, sans-serif">Otros Costos : </font></td>
    <td width="233" class="tit_form"><strong><?php echo $row['CostoII'];?> <?php echo $row['MonedaII'];?></strong><strong> 
      </strong></td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td height="2" ></td>
    <td height="2" ></td>
	<td height="2" bgcolor="#000000"></td>
    <td height="2" ></td>
    <td height="2" bgcolor="#000000"></td>
	<td height="2" ></td>
    <td height="2" bgcolor="#000000"></td>
    <td width="8" height="2"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="94" height="20" class="titulo2"><font size="2" face="Arial, Helvetica, sans-serif">Prioridad: 
      </font></td>
    <td width="102" class="tit_form"> Alta
      <?php 
	if ($row['Prioridad']=="1")
		{
		echo "<img src=\"images/si1.gif\"  >";
		}
		else
		{
		echo "<img src=\"images/no1.gif\"  >";
		}
	?>
    </td>
    <td width="99" class="tit_form">Media
      <?php 
	if ($row['Prioridad']=="2")
		{
		echo "<img src=\"images/si1.gif\"  >";
		}
		else
		{
		echo "<img src=\"images/no1.gif\"  >";
		}
	?>
    </td>
    <td width="236" class="tit_form"> Baja 
      <?php 
	if ($row['Prioridad']=="3")
		{
		echo "<img src=\"images/si1.gif\"  >";
		}
		else
		{
		echo "<img src=\"images/no1.gif\"  >";
		}
	?>
    </td>
    <td width="172" class="titulo2">Fecha estimada de entrega: </td>
    <td width="194" class="tit_form"> <strong><?php echo $row['FechEstEnt'];?></strong></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td height="2" ></td>
    <td height="2"></td>
	<td height="2"></td>
    <td height="2" ></td>
    <td height="2" bgcolor="#000000"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="285" nowrap class="titulo2"><font size="2" face="Arial, Helvetica, sans-serif">Aceptacion 
      del usuario responsable :</font></td>
    <td width="36" nowrap class="tit_form"> <font size="2">SI</font> 
      <?php 
	if ($row['Aceptac']=="SI")
		{
		echo "<img src=\"images/si1.gif\"  >";
		}
		else
		{
		echo "<img src=\"images/no1.gif\"  >";
		}
	?>
    </td>
    <td width="52" nowrap class="tit_form"><font size="2" face="Arial, Helvetica, sans-serif">NO</font><strong> 
      <?php 
	if ($row['Aceptac']=="NO")
		{
		echo "<img src=\"images/si1.gif\"  >";
		}
		else
		{
		echo "<img src=\"images/no1.gif\"  >";
		}
	?>
      </strong></td>
    <td width="40" nowrap class="titulo2">Firma: </td>
    <td width="101" nowrap>&nbsp;</td>
    <td width="15" nowrap>&nbsp;</td>
    <td width="147" nowrap class="titulo2">Fecha de Asignacion :</td>
    <td colspan="2" nowrap class="tit_form"><strong><?php echo $row['FechAcep'];?></strong></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td height="2"></td>
    <td height="2"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2" ></td>
    <td height="2"></td>
    <td width="221" height="2" bgcolor="#000000"></td>
  </tr>
</table>
<BR>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> 
      <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">CRONOGRAMA</font></u></b></div>
    </td>
  </tr>
</table><BR><BR>
<table width="100%" border="2" align="center">
  <tr bgcolor="#CCCCCC"> 
    <td width="2%" rowspan="2"><div align="center"><font size="1"><font size="1"><span class="titulo2"><span class="style1">N.</span><font size="1">-</font></span></font></font></div></td>
    <td width="9%" rowspan="2" class="titulo2"><div align="center">Tarea/Fase</div></td>
	<td colspan="2" class="titulo2"><div align="center">Fechas Programadas</div></td>
    <td colspan="2" class="titulo2"><div align="center">Fechas Reales</div></td>
    <td width="17%" rowspan="2" class="titulo2"><div align="center">Nombre Responsable</div></td>
    <td width="11%" rowspan="2" class="titulo2"><div align="center">Rubrica Responsable</div></td>
    <td width="16%" rowspan="2" class="titulo2"><div align="center">Observaciones</div></td>
  </tr>
  <tr> 
    <td width="11%" height="16" bgcolor="#CCCCCC"> 
    <div align="center" class="titulo2"><b>Inicio</b></div></td>
    <td width="11%" bgcolor="#CCCCCC" class="titulo2"><div align="center"><b>Termino</b></div></td>
    <td width="12%" bgcolor="#CCCCCC" class="titulo2"><div align="center"><b>Inicio</b></div></td>
    <td width="11%" bgcolor="#CCCCCC" class="titulo2"><div align="center"><b>Termino</b></div></td>
  </tr>
  <?php 
  $sql5 = "SELECT *,DATE_FORMAT(FeProIni,'%d / %m / %Y') as FeProIni,DATE_FORMAT(FeProTer,'%d / %m / %Y') as FeProTer,".
          "DATE_FORMAT(FeRealIni,'%d / %m / %Y') as FeRealIni,DATE_FORMAT(FeRealTer,'%d / %m / %Y') as FeRealTer FROM cronograma WHERE OrdAyuda='$OrdAyuda' AND TareCrono='Especificaciones'";
  $result5=mysql_db_query($db,$sql5,$link);
  $row5=mysql_fetch_array($result5);?>
  <tr align="center"> 
    <td height="22">
<div align="center"><font size="1">1</font></div></td>
    <td ><div align="left" class="titulo2" >Especificaciones</div></td>
    <td><div align="center" class="titulo2" ><strong>&nbsp;<?php if ($row5['FeProIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeProTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProTer'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealTer'];?></strong></div></td>
    <td><div align="center"  class="tit_form"><strong>&nbsp; 
        <?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row5[RubricaR]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
        </strong></div></td>
    <td><font size="1">&nbsp;</font></td>
    <td class="tit_form"><strong>&nbsp;<?php echo $row5['Observ'];?></strong></div></td>
  </tr>
  <?php 
  $sql5 = "SELECT *,DATE_FORMAT(FeProIni,'%d / %m / %Y') as FeProIni,DATE_FORMAT(FeProTer,'%d / %m / %Y') as FeProTer,".
          "DATE_FORMAT(FeRealIni,'%d / %m / %Y') as FeRealIni,DATE_FORMAT(FeRealTer,'%d / %m / %Y') as FeRealTer FROM cronograma WHERE OrdAyuda='$OrdAyuda' AND TareCrono='Aprobacion Usuario'";
  $result5=mysql_db_query($db,$sql5,$link);
  $row5=mysql_fetch_array($result5);?>
  <tr> 
    <td><div align="center"><font size="1">2</font></div></td>
    <td class="titulo2"><div align="left">Aprobacion usuario</div></td>
    <td><div align="center" class="titulo2" ><strong>&nbsp;<?php if ($row5['FeProIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeProTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProTer'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealTer'];?></strong></div></td>

    <td class="tit_form"><div align="center"><strong>&nbsp; 
         <?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row5[RubricaR]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
	
        </strong></div></td>
    <td><div align="center"><font size="1">&nbsp;</font></div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp;<?php echo $row5['Observ'];?></strong></div></td>
  </tr>
  <?php 
  $sql5 = "SELECT *,DATE_FORMAT(FeProIni,'%d / %m / %Y') as FeProIni,DATE_FORMAT(FeProTer,'%d / %m / %Y') as FeProTer,".
          "DATE_FORMAT(FeRealIni,'%d / %m / %Y') as FeRealIni,DATE_FORMAT(FeRealTer,'%d / %m / %Y') as FeRealTer FROM cronograma WHERE OrdAyuda='$OrdAyuda' AND TareCrono='Analisis'";
  $result5=mysql_db_query($db,$sql5,$link);
  $row5=mysql_fetch_array($result5);?>
  <tr> 
    <td><div align="center"><font size="1">3</font></div></td>
    <td class="titulo2"><div align="left">Analisis</div></td>
    <td><div align="center" class="titulo2" ><strong>&nbsp;<?php if ($row5['FeProIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeProTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProTer'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealTer'];?></strong></div></td>

    <td class="tit_form"><div align="center"><strong>&nbsp; 
        <?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row5[RubricaR]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
	
        </strong></div></td>
    <td><div align="center"><font size="1">&nbsp;</div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp;<?php echo $row5['Observ'];?></strong></div></td>
  </tr>
  <?php 
  $sql5 = "SELECT *,DATE_FORMAT(FeProIni,'%d / %m / %Y') as FeProIni,DATE_FORMAT(FeProTer,'%d / %m / %Y') as FeProTer,".
          "DATE_FORMAT(FeRealIni,'%d / %m / %Y') as FeRealIni,DATE_FORMAT(FeRealTer,'%d / %m / %Y') as FeRealTer FROM cronograma WHERE OrdAyuda='$OrdAyuda' AND TareCrono='Diseno'";
  $result5=mysql_db_query($db,$sql5,$link);
  $row5=mysql_fetch_array($result5);?>
  <tr> 
    <td><div align="center"><font size="1">4</font></div></td>
    <td class="titulo2"><div align="left">Diseno</div></td>
    <td><div align="center" class="titulo2" ><strong>&nbsp;<?php if ($row5['FeProIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeProTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProTer'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealTer'];?></strong></div></td>

    <td class="tit_form"><div align="center"><strong>&nbsp; 
       <?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row5[RubricaR]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
        </strong></div></td>
    <td><div align="center"><font size="1">&nbsp;</font></div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp;<?php echo $row5['Observ'];?></strong></div></td>
  </tr>
  <?php 
  $sql5 = "SELECT *,DATE_FORMAT(FeProIni,'%d / %m / %Y') as FeProIni,DATE_FORMAT(FeProTer,'%d / %m / %Y') as FeProTer,".
          "DATE_FORMAT(FeRealIni,'%d / %m / %Y') as FeRealIni,DATE_FORMAT(FeRealTer,'%d / %m / %Y') as FeRealTer FROM cronograma WHERE OrdAyuda='$OrdAyuda' AND TareCrono='Programacion'";
  $result5=mysql_db_query($db,$sql5,$link);
  $row5=mysql_fetch_array($result5);?>
  <tr> 
    <td><div align="center"><font size="1">5</font></div></td>
    <td class="titulo2"><div align="left">Programacion</div></td>
    <td><div align="center" class="titulo2" ><strong>&nbsp;<?php if ($row5['FeProIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeProTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProTer'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealTer'];?></strong></div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp; 
        <?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row5[RubricaR]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
	</strong></div></td>
    <td><div align="center"><font size="1">&nbsp;</div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp;<?php echo $row5['Observ'];?></strong></div></td>
  </tr>
  <?php 
  $sql5 = "SELECT *,DATE_FORMAT(FeProIni,'%d / %m / %Y') as FeProIni,DATE_FORMAT(FeProTer,'%d / %m / %Y') as FeProTer,".
          "DATE_FORMAT(FeRealIni,'%d / %m / %Y') as FeRealIni,DATE_FORMAT(FeRealTer,'%d / %m / %Y') as FeRealTer FROM cronograma WHERE OrdAyuda='$OrdAyuda' AND TareCrono='Pruebas'";
  $result5=mysql_db_query($db,$sql5,$link);
  $row5=mysql_fetch_array($result5);?>
  <tr> 
    <td><div align="center"><font size="1">6</font></div></td>
    <td class="titulo2"><div align="left">Pruebas</div></td>
    <td><div align="center" class="titulo2" ><strong>&nbsp;<?php if ($row5['FeProIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeProTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProTer'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealTer'];?></strong></div></td>
    <td class="tit_form"><div align="center"><strong> &nbsp; 
      <?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row5[RubricaR]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
        </strong></div></td>
    <td><div align="center"><font size="1">&nbsp;</font></div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp;<?php echo $row5['Observ'];?></strong></div></td>
  </tr>
  <?php 
  $sql5 = "SELECT *,DATE_FORMAT(FeProIni,'%d / %m / %Y') as FeProIni,DATE_FORMAT(FeProTer,'%d / %m / %Y') as FeProTer,".
          "DATE_FORMAT(FeRealIni,'%d / %m / %Y') as FeRealIni,DATE_FORMAT(FeRealTer,'%d / %m / %Y') as FeRealTer FROM cronograma WHERE OrdAyuda='$OrdAyuda' AND TareCrono='Documentacion'";
  $result5=mysql_db_query($db,$sql5,$link);
  $row5=mysql_fetch_array($result5);?>
  <tr> 
    <td><div align="center"><font size="1">7</font></div></td>
    <td class="titulo2"><div align="left">Documentacion</div></td>
    <td><div align="center" class="titulo2" ><strong>&nbsp;<?php if ($row5['FeProIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeProTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProTer'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealTer'];?></strong></div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp; 
        <?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row5[RubricaR]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
        </strong></div></td>
    <td><div align="center">&nbsp;</div></td>
    <td><div align="center" class="tit_form"><strong>&nbsp;<?php echo $row5['Observ'];?></strong></div></td>
  </tr>
  <?php 
  $sql5 = "SELECT *,DATE_FORMAT(FeProIni,'%d / %m / %Y') as FeProIni,DATE_FORMAT(FeProTer,'%d / %m / %Y') as FeProTer,".
          "DATE_FORMAT(FeRealIni,'%d / %m / %Y') as FeRealIni,DATE_FORMAT(FeRealTer,'%d / %m / %Y') as FeRealTer FROM cronograma WHERE OrdAyuda='$OrdAyuda' AND TareCrono='Pase a Produccion'";
  $result5=mysql_db_query($db,$sql5,$link);
  $row5=mysql_fetch_array($result5);?>
  <tr> 
    <td><div align="center"><font size="1">8</font></div></td>
    <td class="titulo2"><div align="left">Pase a Produccion</div></td>
    <td><div align="center" class="titulo2" ><strong>&nbsp;<?php if ($row5['FeProIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeProTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProTer'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealTer'];?></strong></div></td>
    <td class="tit_form"><div align="center">&nbsp; 
        <?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row5[RubricaR]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
       </div></td>
    <td><div align="center"><font size="1">&nbsp;</font></div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp;<?php echo $row5['Observ'];?></strong></div></td>
  </tr>
  <?php 
  $sql5 = "SELECT *,DATE_FORMAT(FeProIni,'%d / %m / %Y') as FeProIni,DATE_FORMAT(FeProTer,'%d / %m / %Y') as FeProTer,".
          "DATE_FORMAT(FeRealIni,'%d / %m / %Y') as FeRealIni,DATE_FORMAT(FeRealTer,'%d / %m / %Y') as FeRealTer FROM cronograma WHERE OrdAyuda='$OrdAyuda' AND TareCrono='Capacitacion'";
  $result5=mysql_db_query($db,$sql5,$link);
  $row5=mysql_fetch_array($result5);?>
  <tr> 
    <td><div align="center"><font size="1">9</font></div></td>
    <td><div align="left" class="titulo2">Capacitacion</div></td>
    <td><div align="center" class="titulo2" ><strong>&nbsp;<?php if ($row5['FeProIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeProTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProTer'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealTer'];?></strong></div></td>
    <td><div align="center" class="tit_form"><strong>&nbsp; 
        <?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row5[RubricaR]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
        </strong></div></td>
    <td><div align="center"><font size="1">&nbsp;</font></div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp;<?php echo $row5['Observ'];?></strong></div></td>
  </tr>
  <?php 
  $sql5 = "SELECT *,DATE_FORMAT(FeProIni,'%d / %m / %Y') as FeProIni,DATE_FORMAT(FeProTer,'%d / %m / %Y') as FeProTer,".
          "DATE_FORMAT(FeRealIni,'%d / %m / %Y') as FeRealIni,DATE_FORMAT(FeRealTer,'%d / %m / %Y') as FeRealTer FROM cronograma WHERE OrdAyuda='$OrdAyuda' AND TareCrono='Implantacion'";
  $result5=mysql_db_query($db,$sql5,$link);
  $row5=mysql_fetch_array($result5);?>
  <tr> 
    <td><div align="center"><font size="1">10</font></div></td>
    <td class="titulo2"><div align="left">Implantacion</div></td>
    <td><div align="center" class="titulo2" ><strong>&nbsp;<?php if ($row5['FeProIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeProTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProTer'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealTer'];?></strong></div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp; 
       <?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row5[RubricaR]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
        </strong></div></td>
    <td><div align="center"><font size="1">&nbsp;</font></div></td>
    <td><div align="center" class="tit_form"><strong>&nbsp;<?php echo $row5['Observ'];?></strong></div></td>
  </tr>
  <?php 
  $sql5 = "SELECT *,DATE_FORMAT(FeProIni,'%d / %m / %Y') as FeProIni,DATE_FORMAT(FeProTer,'%d / %m / %Y') as FeProTer,".
          "DATE_FORMAT(FeRealIni,'%d / %m / %Y') as FeRealIni,DATE_FORMAT(FeRealTer,'%d / %m / %Y') as FeRealTer FROM cronograma WHERE OrdAyuda='$OrdAyuda' AND TareCrono='Explotacion'";
  $result5=mysql_db_query($db,$sql5,$link);
  $row5=mysql_fetch_array($result5);?>
  <tr> 
    <td><div align="center"><font size="1">11</font></div></td>
    <td class="titulo2"><div align="left">Explotacion</div></td>
    <td><div align="center" class="titulo2" ><strong>&nbsp;<?php if ($row5['FeProIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeProTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProTer'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealTer'];?></strong></div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp; 
        <?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row5[RubricaR]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
        </strong></div></td>
    <td><div align="center"><font size="1">&nbsp;</font></div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp;<?php echo $row5['Observ'];?></strong></div></td>
  </tr>
  <?php 
  $sql5 = "SELECT *,DATE_FORMAT(FeProIni,'%d / %m / %Y') as FeProIni,DATE_FORMAT(FeProTer,'%d / %m / %Y') as FeProTer,".
          "DATE_FORMAT(FeRealIni,'%d / %m / %Y') as FeRealIni,DATE_FORMAT(FeRealTer,'%d / %m / %Y') as FeRealTer FROM cronograma WHERE OrdAyuda='$OrdAyuda' AND TareCrono='Satisfaccion Usuaria'";
  $result5=mysql_db_query($db,$sql5,$link);
  $row5=mysql_fetch_array($result5);?>
  <tr> 
    <td><div align="center"><font size="1">12</font></div></td>
    <td class="titulo2"><div align="left">Satisfaccion usuaria</div></td>
    <td><div align="center" class="titulo2" ><strong>&nbsp;<?php if ($row5['FeProIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeProTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeProTer'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealIni'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealIni'];?></strong></div></td>
    <td><div align="center" class="titulo2"><strong>&nbsp;<?php if ($row5['FeRealTer'] == "00 / 00 / 0000") echo "&nbsp"; else echo $row5['FeRealTer'];?></strong></div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp; 
       <?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row5[RubricaR]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
        </strong></div></td>
    <td><div align="center"><font size="1">&nbsp;</font></div></td>
    <td class="tit_form"><div align="center"><strong>&nbsp;<?php echo $row5['Observ'];?></strong></div></td>
  </tr>
</table>
  
<br>

<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> 
      <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">APROBACIONES (FIRMA Y FECHA) </font></u></b></div>
    </td>
  </tr>
</table>



<br>
<table width="659" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="232" nowrap class="titulo2">Responsable de implantacion: </td>
    <td width="223" nowrap class="tit_form"><strong>
	<?php 
	
	$sql_a = "SELECT * FROM aprobus WHERE OrdAyuda='$IdOrden'";
	$res_a =mysql_db_query($db,$sql_a,$link);
	$row_a =mysql_fetch_array($res_a);
	//echo "sdsds".$nra;
	$sql6 = "SELECT * FROM users WHERE login_usr='$row_a[NombRespAp]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
	</strong></td>
    <td width="36" nowrap>&nbsp;</td>
    <td class="tit_form" width="168" nowrap><strong><?php echo $row_a['FechRespAp'];?></strong></td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="657" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="250" class="titulo2" nowrap>Usuario Responsable (implantacion) : </td>
    <td width="200" nowrap class="tit_form"><strong>
	
	<?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row_a[NomUsRespAp]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?></strong></td>
    <td width="36" nowrap>&nbsp;</td>
    <td width="171" nowrap class="tit_form"><strong><?php echo $row_a['FechUsRespAp'];?></strong></td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="661" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="377" nowrap class="titulo2" >Comite de Cambios (implantacion en ambiente 
      de produccion)</td>
    <td width="169" nowrap class="tit_form"><strong><?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row_a[ComCambAp]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
	</strong></td>
    <td width="10" nowrap>&nbsp;</td>
    <td width="105" nowrap class="tit_form"><strong><?php echo $row_a['FechComAp']; ?></strong></td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table> 

<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> 
      <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">IMPLANTACION</font></u></b></div>
    </td>
  </tr>
</table>

<br>
<table width="659" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="179" nowrap class="titulo2">Coordinador de cambios</td>
    <td  class="tit_form" width="276" nowrap ><strong>
	
	<?php 
	$sql_b = "SELECT * FROM implantus WHERE OrdAyuda='$IdOrden'";
	$res_b = mysql_db_query($db,$sql_b,$link);
	$row_b = mysql_fetch_array($res_b);
	
	$sql6 = "SELECT * FROM users WHERE login_usr='$row_b[NomCordCamb]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?> 
	</strong></td>
    <td width="39" nowrap>&nbsp;</td>
    <td width="165" nowrap class="tit_form"><strong><?php echo $row_b['FechCordConf'];?></strong></td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="659" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="326" nowrap class="titulo2">Conformidad de los resultados con la solicitud </td>
    <td width="83" nowrap class="titulo2">SI
      <?php 
	$rcc = $row_b['ResuCordConf'];
	if ($rcc=="SI")
		{
		echo "<img src=\"images/si1.gif\"  >";
		}
		else
		{
		echo "<img src=\"images/no1.gif\"  >";
		}
	?>
    </td>
    <td width="146" nowrap class="titulo2">PARCIAL 
      <?php 
	if ($rcc=="PARCIAL")
		{
		echo "<img src=\"images/si1.gif\"  >";
		}
		else
		{
		echo "<img src=\"images/no1.gif\"  >";
		}
	?>
    </td>
    <td width="104" nowrap class="titulo2">NO
      <?php 
	if ($rcc=="NO")
		{
		echo "<img src=\"images/si1.gif\"  >";
		}
		else
		{
		echo "<img src=\"images/no1.gif\"  >";
		}
	?>
    </td>
  </tr>
</table>
<br>
<table width="659" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="182" nowrap class="titulo2">Usuario Solicitante:</td>
    <td class="tit_form" width="273" nowrap><strong>
	<?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$row_b[NomUsConf]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>	
    </strong></td>
    <td width="47" nowrap>&nbsp;</td>
    <td width="157" nowrap class="tit_form"><strong><?php echo $row_b['FechUsConf'];?></strong></td>
  </tr>
   <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="659" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="326" nowrap class="titulo2">Conformidad de los resultados con la solicitud </td>
    <td width="83" nowrap class="titulo2">SI 
      <?php 
	  $ruc = $row_b['ResuUsConf'];
	if ($ruc=="SI")
		{
		echo "<img src=\"images/si1.gif\"  >";
		}
		else
		{
		echo "<img src=\"images/no1.gif\"  >";
		}
	?>
    </td>
    <td width="146" nowrap class="titulo2">PARCIAL
      <?php 
	if ($ruc=="PARCIAL")
		{
		echo "<img src=\"images/si1.gif\"  >";
		}
		else
		{
		echo "<img src=\"images/no1.gif\"  >";
		}
	?>
    </td>
    <td width="104" nowrap class="titulo2">NO
      <?php 
	if ($ruc=="NO")
		{
		echo "<img src=\"images/si1.gif\"  >";
		}
		else
		{
		echo "<img src=\"images/no1.gif\"  >";
		}
	?>
    </td>
  </tr>
</table>


</body>
</html>