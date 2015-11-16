<?php session_start();
if(!empty($_SESSION["titulo_modulo"])) $titulo_modulo=$_SESSION["titulo_modulo"];
?>

<html>
<head>
<title>Pistas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="general.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style3 {
	font-size: medium;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>
</head>
<?php
include("conexion.php");
//$titulo_modulo = "titulo";
?>
<body><p>
<?php
include("datos_gral.php");
?>
</p>
<div align="center"><span class="style3"><u>PISTAS DE AUDITORIA ANTERIORES</u></span><font size="2" face="Arial, Helvetica"><b>
  <center>
    <span class="style1">
    </span>
  <center>
  </b></font><br>
  <table width="100%" border="1" align="center" cellspacing="0">
</div>
<tr>   
</tr>
<tr class="titulo6" align=\"center\"> 
    <th width="30" align="center" bgcolor="#CCCCCC" class="menu">Nro. DE PISTA</th>
    <th width="60" align="center" bgcolor="#CCCCCC" class="menu">FECHA</th>
    <th width="60" align="center" bgcolor="#CCCCCC" class="menu">HORA</th>
    <th width="200" align="center" bgcolor="#CCCCCC" class="menu">PROCESO</th>
    <th width="130" align="center" bgcolor="#CCCCCC" class="menu">RESPONSABLE</th>
    <th width="150" align="center" bgcolor="#CCCCCC" class="menu">NOMBRE DEL <?php echo ucfirst($titulo_modulo); ?></th>
    <th width="130" align="center" bgcolor="#CCCCCC" class="menu">NOMBRE DEL ARCHIVO</th>
    <th width="170" align="center" bgcolor="#CCCCCC" class="menu">NOMBRE DE LA VERSION</th>
    <th width="250" align="center" bgcolor="#CCCCCC" class="menu">OBSERVACIONES</th>
</tr>
<?php
if ($menu=='general'){
	$sql="SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM pistas_fuentes_gral WHERE agrupar_pista='$id_pista' ORDER BY id_pista DESC";}
elseif ($menu=='fecha'){
	if (strlen($DA) == 1){ $DA = "0".$DA; }
	if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
    $fec1 = $AA."-".$MA."-".$DA;   
	if (strlen($DE) == 1){ $DE = "0".$DE; }
	if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fec2 = $AE."-".$ME."-".$DE; 
	$sql="SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM pistas_fuentes_gral WHERE agrupar_pista ='$id_pista' AND fecha_pista BETWEEN '$fec1' AND '$fec2' ORDER BY id_pista DESC";}
elseif ($menu=='proceso'){
	$sql="SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM pistas_fuentes_gral WHERE accion='$cond' AND agrupar_pista ='$id_pista' ORDER BY id_pista DESC";}
elseif ($menu=='responsable'){
	$sql="SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM pistas_fuentes_gral WHERE login_pista='$cond' AND agrupar_pista ='$id_pista' ORDER BY id_pista DESC";}
elseif ($menu=='modulo'){
	$sql="SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM pistas_fuentes_gral WHERE id_mod='$cond' AND agrupar_pista ='$id_pista' ORDER BY id_pista DESC";}
elseif ($menu=='archivo'){
	$sql="SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM pistas_fuentes_gral WHERE id_arch='$cond' AND agrupar_pista ='$id_pista' ORDER BY id_pista DESC";}
elseif ($menu=='version'){
	$sql="SELECT *, DATE_FORMAT(fecha_pista, '%d/%m/%Y') AS fecha_pista2, TIME_FORMAT(hora_pista, '%H:%i:%s') AS hora_pista2 FROM pistas_fuentes_gral WHERE id_ver='$cond' AND agrupar_pista ='$id_pista' ORDER BY id_pista DESC";}	
$result=mysql_db_query($db,$sql,$link);

while($row=mysql_fetch_array($result)){

?>
<tr class="tit_form4">
    <td align="center">&nbsp;<?php echo $row['id_pista'];?></td>
    <td align="center">&nbsp;<?php echo $row['fecha_pista'];?></td>
    <td align="center">&nbsp;<?php echo $row['hora_pista'];?></td>
    <td align="center">&nbsp;<?php echo $row['accion'];?></td>
    <td align="center">&nbsp;<?php echo $row['login_pista'];?></td>
    <td align="center">&nbsp;<?php echo $row['id_mod'];?></td>
    <td align="center">&nbsp;<?php echo $row['id_arch'];?></td>
    <td align="center">&nbsp;<?php if($row['id_ver']){echo $row['id_ver'];} else echo "-";?></td>
  <td>&nbsp;</td>
</tr>
<?php
};
echo "</table>";
?>
</body>
</html>