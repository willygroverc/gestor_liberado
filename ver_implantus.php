<?php
include ("top_ver.php");
require_once('funciones.php');
$OrdAyuda=SanitizeString($_GET['IdOrden']);
$ncc=SanitizeString($_GET['NomCordCamb']);
$fcc=SanitizeString($_GET['FechCordConf']);
$rcc=SanitizeString($_GET['ResuCordConf']);
$nsu=SanitizeString($_GET['NomUsConf']);
$fuc=SanitizeString($_GET['FechUsConf']);
$ruc=SanitizeString($_GET['ResuUsConf']);
	
?>

<html>
<head>
<title>Gestor F1-MyM Implantacion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="general.css" rel="stylesheet" type="text/css">
</head>

<body>
<p>
<?php
include("datos_gral.php");
?>
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
    <td width="178" nowrap class="titulo2">Coordinador de cambios</td>
    <td  class="tit_form" width="277" nowrap ><strong>
	<?php 
	$sql6 = "SELECT * FROM users WHERE login_usr='$ncc'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>
	</strong></td>
    <td width="39" nowrap>&nbsp;</td>
    <td width="165" nowrap class="tit_form"><strong><?php echo $fcc;?></strong></td>
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
	if ($rcc=="SI")
		{
		echo "<img src=\"images/si1.gif\" border=\"1\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\" border=\"1\">";
		}
	?>
    </td>
    <td width="146" nowrap class="titulo2">PARCIAL 
      <?php 
	if ($rcc=="PARCIAL")
		{
		echo "<img src=\"images/si1.gif\" border=\"1\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\" border=\"1\">";
		}
	?>
    </td>
    <td width="104" nowrap class="titulo2">NO
      <?php 
	if ($rcc=="NO")
		{
		echo "<img src=\"images/si1.gif\" border=\"1\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\" border=\"1\">";
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
	$IdOrden=SanitizeString($IdOrden);
	$sql_b = "SELECT * FROM implantus WHERE OrdAyuda='$IdOrden'";
	$res_b = mysql_db_query($db,$sql_b,$link);
	$row_b = mysql_fetch_array($res_b);
	
	$sql6 = "SELECT * FROM users WHERE login_usr='$row_b[NomUsConf]'";
	$result6=mysql_db_query($db,$sql6,$link);
	$row6=mysql_fetch_array($result6);
	echo $row6['apa_usr']." ".$row6['ama_usr']." ".$row6['nom_usr'];?>	
    </strong></td>
    <td width="47" nowrap>&nbsp;</td>
    <td width="157" nowrap class="tit_form"><strong><?php echo $fuc;?></strong></td>
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
	if ($ruc=="SI")
		{
		echo "<img src=\"images/si1.gif\" border=\"1\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\" border=\"1\">";
		}
	?>
    </td>
    <td width="146" nowrap class="titulo2">PARCIAL
      <?php 
	if ($ruc=="PARCIAL")
		{
		echo "<img src=\"images/si1.gif\" border=\"1\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\" border=\"1\">";
		}
	?>
    </td>
    <td width="104" nowrap class="titulo2">NO
      <?php 
	if ($ruc=="NO")
		{
		echo "<img src=\"images/si1.gif\" border=\"1\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\" border=\"1\">";
		}
	?>
    </td>
  </tr>
</table>



</body>
</html>
