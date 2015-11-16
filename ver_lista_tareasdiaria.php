<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		17/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include("top_ver.php");
require_once('funciones.php');
if (isset($DA)){

	if (strlen($DA) == 1){ $DA = "0".$DA; }
	if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
    $fec1 = $AA."-".$MA."-".$DA;   
	if (strlen($DE) == 1){ $DE = "0".$DE; }
	if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fec2 = $AE."-".$ME."-".$DE;
}

//echo $menu."--".$nombre."--".$IdProgTarea;
$IdProgTarea=SanitizeString($_GET['IdProgTarea']);
$sql = "SELECT *, DATE_FORMAT(FechaDe,'%d/%m/%Y') as FechaDe FROM progtareasdiaria WHERE IdProgTarea='$IdProgTarea'";
$rs  = mysql_query($sql);
$row = mysql_fetch_array($rs);
if(isset($opcion) && $opcion == "F") 
{	if (isset($menu) && $menu == "GENERAL")
	$sql="SELECT *, DATE_FORMAT(FechaProceso,'%d/%m/%Y  %H:%i:%s') as FechaProceso, DATE_FORMAT(RevisadoPorFecha,'%d/%m/%Y  %H:%i:%s') as RevisadoPorFecha  
	FROM progtareasdiaria1 WHERE (FechaProceso BETWEEN '#$fec1 00:00:00#' AND '#$fec2 23:59:59#') AND IdProgTarea=$IdProgTarea";
	else
	$sql="SELECT *, DATE_FORMAT(FechaProceso,'%d/%m/%Y  %H:%i:%s') as FechaProceso, DATE_FORMAT(RevisadoPorFecha,'%d/%m/%Y  %H:%i:%s') as RevisadoPorFecha  
	FROM progtareasdiaria1 WHERE (FechaProceso BETWEEN '#$fec1 00:00:00#' AND '#$fec2 23:59:59#') AND IdProgTarea=$IdProgTarea AND RealizadoPor='$nombre'";	
}
else 
{	if ($menu == "GENERAL")
	$sql="SELECT *, DATE_FORMAT(FechaProceso,'%d/%m/%Y  %H:%i:%s') as FechaProceso, DATE_FORMAT(RevisadoPorFecha,'%d/%m/%Y  %H:%i:%s') as RevisadoPorFecha  
	FROM progtareasdiaria1 WHERE IdProgTarea=$IdProgTarea";
	else 
	$sql="SELECT *, DATE_FORMAT(FechaProceso,'%d/%m/%Y  %H:%i:%s') as FechaProceso, DATE_FORMAT(RevisadoPorFecha,'%d/%m/%Y  %H:%i:%s') as RevisadoPorFecha  
	FROM progtareasdiaria1 WHERE IdProgTarea=$IdProgTarea AND RealizadoPor='$nombre'";
	
}
$rs=mysql_query($sql);
?>
<html>
<head>
	<title> GesTor F1 - PRODUCCIÓN-PROAPD - CALENDARIZACIÓN</title>
    <style type="text/css">
<!--
.margin {
	border-bottom-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-bottom-color: #000000;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
}
.text {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: normal;
}
.style16 {font-size: 11px; font-weight: bold; }
-->
    </style>
</head>
<body><p>
<?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><strong><u>PROGRAMACION 
        DE TAREAS DIARIAS</u></strong></font></div></td>
  </tr>
</table>

<br>
<table width="75%" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td width="52%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NUMERO 
      DE PROGRAMACION DE TAREA :</strong></font></td>
    <td width="48%" class="margin"><?php echo $row['IdProgTarea']; ?></td>
  </tr>
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">ACTIVIDAD :</font></strong></td>
    <td class="margin"><?php=$row["Actividad"]?></td>
  </tr>
  <tr>
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA DE PROGRAMACION :</font></strong></td>
    <td class="margin"><?php=$row["FechaDe"]?></td>
  </tr>
  <tr>
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">HORA DE REALIZACION :</font></strong></td>
    <td class="margin"><?php=$row["HoraDe"]." - ".$row["HoraA"]?></td>
  </tr>
  <tr>
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES :</font></strong></td>
    <td class="margin"><?php=$row["Observaciones"]?></td>	
  </tr>
  <?php
  	$variable = explode("|",$row["d_asig"]);
	$tam = count($variable)-1;
	if($tam == 1)
	{
 ?>
	  <tr>
		<td><strong><font size="2" face="Arial, Helvetica, sans-serif">ASIGNADO A :</font></strong></td>
		<td class="margin"><?php=getname($variable[0]);?></td>	
	  </tr>
 <?php}
	else{ 
   	  for($i=0; $i<=$tam; $i++ )
	  {
   	?>
   	  <tr>
		<td><?php if($i == 0) {?><strong><font size="2" face="Arial, Helvetica, sans-serif">ASIGNADO A :</font></strong><?php }?></td>
		<td class="margin"><?php=getname($variable[$i]);?></td>	
	  </tr>	
   <?php } 
   } ?>

</table>
<br>
<table width="90%" border="1" align="center" cellpadding="2" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
    <th width="15%"><div align="center" class="style16"><font face="Arial, Helvetica, sans-serif">REALIZADO POR </font></div></th>
    <th width="10%"><div align="center" class="style16"><font face="Arial, Helvetica, sans-serif">FECHA / HORA</font></div></th>
    <th width="10%"><div align="center" class="style16"><font face="Arial, Helvetica, sans-serif">REALIZACION</font></div></th>
    <th width="13%"><div align="center" class="style16"><font face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></div></th>
    <th width="15%"><div align="center" class="style16"><font face="Arial, Helvetica, sans-serif">REVISADO POR </font></div></th>
    <th width="10%"><div align="center" class="style16"><font face="Arial, Helvetica, sans-serif">FECHA / HORA </font></div></th>
    <th width="10%"><div align="center" class="style16"><font face="Arial, Helvetica, sans-serif">APROBACION</font></div></th>
    <th width="15%"><div align="center" class="style16"><font face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></div></th>
  </tr>
  <?php
while($lstTarea=mysql_fetch_array($rs))
{
	echo "<tr align=\"center\">";
	$sql2 = "SELECT login_usr, CONCAT(nom_usr, ' ', apa_usr, ' ', ama_usr) AS nombre FROM users WHERE login_usr='$lstTarea[RealizadoPor]'" ;
    $rs2  = mysql_query( $sql2);
    $realizadoPor = mysql_fetch_array($rs2);
	echo "<td align=\"center\" class=\"text\">&nbsp;".$realizadoPor['nombre']."</font></td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$lstTarea[FechaProceso] </font></td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$lstTarea[Realizacion]</font></td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$lstTarea[RealizadoPorObs]</font></td>";
	$sql3 = "SELECT login_usr, CONCAT(nom_usr, ' ', apa_usr, ' ', ama_usr) AS nombre FROM users WHERE login_usr='$lstTarea[RevisadoPor]'" ;
    $rs3  = mysql_query( $sql3);
    $revisadoPor = mysql_fetch_array($rs3);	
	echo "<td align=\"center\" class=\"text\">&nbsp;".$revisadoPor['nombre']."</font></td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;";if($lstTarea['Revisado']==1) print $lstTarea['RevisadoPorFecha']; print "</font></td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$lstTarea[Aprobacion]</font></td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$lstTarea[RevisadoPorObs]</font></td>";
	echo "</tr>";
}
?>
</table>
</body>
</html>
<?php
function getname($login)
{
	include("conexion.php");
	$sql = "select *from users where login_usr='$login'";
	$res = mysql_query($sql);
	$row = mysql_fetch_array($res);
	$nombre = $row['nom_usr']." ".$row['apa_usr']." ".$row['ama_usr'];
	return $nombre;
}
?>