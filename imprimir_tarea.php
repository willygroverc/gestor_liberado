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
include("datos_gral.php");|
require_once('funciones.php');

require("conexion.php");
if (strlen($DA) == 1){ $DA = "0".$DA; }
if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
   $fec1 = $AA."-".$MA."-".$DA;   
if (strlen($DE) == 1){ $DE = "0".$DE; }
if (strlen($ME) == 1){ $ME = "0".$ME; }
$fec2 = $AE."-".$ME."-".$DE." 23:59:59";
if (isset($menu)){
	switch ($menu){
	case "realizado":
		$cond = "AND RealizadoPor LIKE '$selecta' AND FechaProceso BETWEEN '$fec1' AND '$fec2'";
		break;
	case "revisado":
		$cond = "AND RevisadoPor LIKE '$selecta' AND RevisadoPorFecha BETWEEN '$fec1' AND '$fec2'";
		break;
	default:
		$cond = "";
		break;
	}
}
if (isset($tarea)){
	switch($tarea){
	case "diaria":
		$tabla="progtareasdiaria1";
		break;
	case "semanal":
		$tabla="progtareassemanal1";
		break;
	case "mensual":
		$tabla="progtareasmensual1";
		break;
	case "trimestral":
		$tabla="progtareastrimestral1";
		break;
	case "semestral":
		$tabla="progtareassemestral1";
		break;
	case "anual":
		$tabla="progtareasanual1";
		break;
	}
}
?>
<table width="100%"  border="1" align="center" cellpadding="2" cellspacing="0">
  <tr align="center">
    <th colspan="8"><u><font size="3" face="Arial, Helvetica, sans-serif">REALIZACION&nbsp;/&nbsp;REVISION</font></u></th>
  </tr>
  <tr align="center" bgcolor="#CCCCCC">
    <th><font size="2">Nro.</font></th>
    <th><font size="2">Realizado por </font></th>
    <th><font size="2">Fecha/Hora</font></th>
    <th><font size="2">Realizacion</font></th>
    <th><font size="2">Revisado Por </font></th>
    <th><font size="2">Fecha/Hora</font></th>
    <th><font size="2">Aprobacion</font></th>
    <th><font size="2">Revision</font></th>
  </tr>
<?php
$sql = "SELECT *, DATE_FORMAT(FechaProceso, '%d/%m/%Y %H:%i:%s') AS FechaProceso, DATE_FORMAT(RevisadoPorFecha, '%d/%m/%Y %H:%i:%s') AS RevisadoPorFecha 
		FROM $tabla WHERE IdProgTarea='$IdProgTarea' $cond ORDER BY IdProgTarea1 DESC";
$rs=mysql_query($sql);
echo mysql_error();
while($tmp=mysql_fetch_array($rs)){
			echo "<tr>";
			echo "<td align=\"center\">$tmp[IdProgTarea1]</td>";
		  	$sql1 = "SELECT * FROM users WHERE login_usr='$tmp[RealizadoPor]'";
		  	$result1 = mysql_query($sql1);
		  	$row1 = mysql_fetch_array($result1);
			echo "<td align=\"center\">&nbsp;$row1[nom_usr] $row1[apa_usr] $row1[ama_usr]</td>";
			echo "<td align=\"center\">$tmp[FechaProceso]</td>";
			echo "<td align=\"center\">$tmp[Realizacion]</td>";
		  	$sql2 = "SELECT * FROM users WHERE login_usr='$tmp[RevisadoPor]'";
		  	$result2 = mysql_query($sql2);
		  	$row2 = mysql_fetch_array($result2);
			echo '<td align="center">&nbsp;'.$row2['nom_usr'].' '.$row2['apa_usr'].' '.$row2['ama_usr'].'</td>';
			if($tmp['RevisadoPorFecha']=="00/00/0000 00:00:00") echo "<td>&nbsp;</td>";
			else echo "<td align=\"center\">$tmp[RevisadoPorFecha]</td>";
			echo "<td align=\"center\">&nbsp;$tmp[Aprobacion]</td>";
			if($tmp["Revisado"]==1) echo "<td align=\"center\">SI</td>";
			else echo "<td align=\"center\">NO</td>";
			echo "</tr>";
		}
?>
</table>