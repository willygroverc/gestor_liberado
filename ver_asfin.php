<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		06/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include ("top_ver.php");
$IdInfast=($_GET['variable']);
$sql = "SELECT * FROM informacionast  WHERE id_infAST='$IdInfast' ";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - CLASIFICACIÓN DE LA INFORMACIÓN MANEJADA </title>
<link href="style1.css" rel="stylesheet" type="text/css">
</head>
<body>
<p><?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><u><strong>CLASIFICACION 
        DE LA INFORMACION MANEJADA</strong></u></font><strong> </strong></div></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="141" height="19"> 
      <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CLASIFICACION 
        Nro.</strong></font></p>
    </td>
    <td width="496"><p>&nbsp;<?php echo $row['id_infAST'];?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="27%" height="18">
<p><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE DEL TECNICO :</span></font></p>
    </td>
    <td width="73%"><p> 
        <?php require('conexion.php');
			  $sql2 = "SELECT * FROM users";
			  $result2 = mysql_query($sql2);
			  while ($row2 = mysql_fetch_array($result2)) 
				{
				if($row2['login_usr']==$row['tecnico'])
				echo $row2['nom_usr'].$row2['apa_usr'].$row2['ama_usr'];
	            }			  			 
	?>
      </p>
	</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="19%" height="19">
<h1><font size="2" face="Arial, Helvetica, sans-serif">DESCRIPCION :</font></h1>
    </td>
    <td width="81%"><p><?php echo $row['des_infAST'];?>&nbsp;</p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="44%" height="19"> 
      <p><font size="2" face="Arial, Helvetica, sans-serif">CLASIFICACION </font>: 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">CONFIDENCIAL:</font> 
        <?php 
	if ($row['clasifi']=="confidencial")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
	else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
      </p>
    </td>
    <td width="20%"><p><font size="2" face="Arial, Helvetica, sans-serif">RESERVADA</font> 
        <?php 
	if ($row['clasifi']=="Reservada")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
	else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
      </p>
    </td>
    <td width="18%"><p><font size="2" face="Arial, Helvetica, sans-serif">INTERNA</font> 
        <?php 
	if ($row['clasifi']=="Interna")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
	else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
      </p>
    </td>
    <td width="18%"><p><font size="2" face="Arial, Helvetica, sans-serif">PUBLICA</font> 
        <?php 
	if ($row['clasifi']=="Publica")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
	else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
      </p>
    </td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="16"> 
      <p><strong><font size="2" face="Arial, Helvetica, sans-serif">I.- DATOS 
        DE LA RETENCION</font></strong></p>
    </td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="33%" height="19"> 
      <p><font size="2" face="Arial, Helvetica, sans-serif">1.- TIEMPO DE RETENCION 
        :</font></p>
    </td>
    <td width="67%"><p><?php echo $row['tiempo_ret'];?>&nbsp;&nbsp;<?php echo $row['clas_tiempo']; ?></p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="65%" height="18"> 
      <p><font size="2" face="Arial, Helvetica, sans-serif">2.- MEDIO DE RETENCION 
        : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IMPRESO</font> 
        <?php 
					if ($row['medio_ret']=="Impreso")
					{echo "<img src=\"images/si1.gif\" border=\"1\">";}
					else
					{echo "<img src=\"images/no1.gif\" border=\"1\">";}
					?>
      </p>
    </td>
    <td width="35%"><p><font size="2" face="Arial, Helvetica, sans-serif">DIGTALIZADO</font> 
        <?php 
				if ($row['medio_ret']=="Digitalizado")
				{echo "<img src=\"images/si1.gif\" border=\"1\">";}
				else
				{echo "<img src=\"images/no1.gif\" border=\"1\">";}
			?>
      </p>
    </td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="16"> 
      <p><strong><font size="2" face="Arial, Helvetica, sans-serif">II.- DATOS 
        DE LA DESTRUCCION</font></strong></p>
    </td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="65%" height="19"> 
      <p><font size="2" face="Arial, Helvetica, sans-serif">1.- MEDIO DE DESTRUCCION 
        :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TRITURADO</font> 
        <?php 
	if ($row['medio_dest']=="Triturado")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
	else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
      </p>
    </td>
    <td width="35%"><p><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">PICADO</font> 
        <?php 
	if ($row['medio_dest']=="Picado")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
	else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
        &nbsp;</p>
    </td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="65%" height="19">
<p><font size="2" face="Arial, Helvetica, sans-serif">2.- CONTROL DE DESTRUCCION 
        : </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DUAL:</font> 
        <?php 
	if ($row['control_dest']=="Dual")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
	else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
      </p>
    </td>
    <td width="35%"> <p><font size="2" face="Arial, Helvetica, sans-serif">PERSONAL:</font> 
        <?php 
	if ($row['control_dest']=="Personal")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
	else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
      </p>
    </td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="37%" height="19">
<p><font size="2" face="Arial, Helvetica, sans-serif">3.- ACTA DE DESTRUCCION 
        : </font></p>
    </td>
    <td width="63%"><p><?php echo $row['acta_dest'];?>&nbsp;</p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="16"> 
      <p><strong><font size="2" face="Arial, Helvetica, sans-serif">III.- CONTROL </font></strong></p>
    </td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="20%" height="19">
<p><font size="2" face="Arial, Helvetica, sans-serif">1.- 
        CONTROL :</font></p>
    </td>
    <td width="80%"><p><?php echo $row['control']; ?>&nbsp;</p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
</body>
</html>