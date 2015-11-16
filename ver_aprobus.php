<?php
include ("top_ver.php");
require_once('funciones.php');
$nra=SanitizeString($_GET['NomResAp']);
$fra=SanitizeString($_GET['FechResAp']);
$nura=SanitizeString($_GET['NomUsRespAp']);
$fura=SanitizeString($_GET['FechUsRespAp']);
$cca=SanitizeString($_GET['ComCambAp']);
$fca=SanitizeString($_GET['FechComAp']);
?>


<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="general.css" rel="stylesheet" type="text/css">
</head>

<body>
<p><?php
include("datos_gral.php");
?>
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
	$sql6 = "SELECT * FROM users WHERE login_usr='$nra'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
	</strong></td>
    <td width="36" nowrap>&nbsp;</td>
    <td class="tit_form" width="168" nowrap><strong><?php echo $fra;?></strong></td>
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
	$sql6 = "SELECT * FROM users WHERE login_usr='$nura'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?></strong></td>
    <td width="36" nowrap>&nbsp;</td>
    <td width="171" nowrap class="tit_form"><strong><?php echo $fura;?></strong></td>
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
	$sql6 = "SELECT * FROM users WHERE login_usr='$cca'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['nom_usr']." ".$row6['apa_usr']." ".$row6['ama_usr'];?>
	</strong></td>
    <td width="10" nowrap>&nbsp;</td>
    <td width="105" nowrap class="tit_form"><strong><?php echo $fca;?></strong></td>
  </tr>
  <tr> 
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
    <td height="1"></td>
    <td height="1" bgcolor="#000000"></td>
  </tr>
</table> 
</body>
</html>
