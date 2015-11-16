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
$sql="SELECT login_usr, CONCAT(nom_usr, ' ', apa_usr, ' ', ama_usr) AS Nombre FROM users";
$rs=mysql_query( $sql);
while($tmp=mysql_fetch_array($rs)){
	$lstUsuario[$tmp['login_usr']]=$tmp['Nombre'];
}
$sql="SELECT *,DATE_FORMAT(FechaDe,'%d / %m / %Y') as FechaDe FROM progtareassemanal WHERE IdProgTarea=".$_GET["IdProgTarea"];
$rs=mysql_query($sql);
$row=mysql_fetch_array($rs);
if($opcion == "F") 
{	if (isset($menu) && $menu == "GENERAL")
	$sql="SELECT *, DATE_FORMAT(FechaProceso,'%d / %m / %Y  %H:%i:%s') as FechaProceso, DATE_FORMAT(RevisadoPorFecha,'%d / %m / %Y  %H:%i:%s') as RevisadoPorFecha  FROM progtareassemanal1 
		  WHERE (FechaProceso BETWEEN '#$fecha1#' AND '#$fecha2 23:59:59#') AND IdProgTarea=".$_GET["IdProgTarea"];
	else
	$sql="SELECT *, DATE_FORMAT(FechaProceso,'%d / %m / %Y  %H:%i:%s') as FechaProceso, DATE_FORMAT(RevisadoPorFecha,'%d / %m / %Y  %H:%i:%s') as RevisadoPorFecha  FROM progtareassemanal1 
		  WHERE (FechaProceso BETWEEN '#$fecha1#' AND '#$fecha2 23:59:59#') AND RealizadoPor='$nombre' AND IdProgTarea=".$_GET["IdProgTarea"];	
}
else 
{	if (isset($menu) && $menu == "GENERAL")
	$sql="SELECT *, DATE_FORMAT(FechaProceso,'%d / %m / %Y  %H:%i:%s') as FechaProceso, DATE_FORMAT(RevisadoPorFecha,'%d / %m / %Y  %H:%i:%s') as RevisadoPorFecha  FROM progtareassemanal1 WHERE IdProgTarea=".$_GET["IdProgTarea"];
	else	
	$sql="SELECT *, DATE_FORMAT(FechaProceso,'%d / %m / %Y  %H:%i:%s') as FechaProceso, DATE_FORMAT(RevisadoPorFecha,'%d / %m / %Y  %H:%i:%s') as RevisadoPorFecha  FROM progtareassemanal1 WHERE RealizadoPor='$nombre' AND IdProgTarea=".$_GET["IdProgTarea"];
}
$rs=mysql_query($sql);
?>
<html>
<head>
	<title> GesTor F1 - PRODUCCIÓN-PROAPD - CALENDARIZACIÓN</title>
    <style type="text/css">
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
.style3 {font-size: 11px; font-weight: bold; }

-->
    </style>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><strong><u>PROGRAMACION 
        DE TAREAS SEMANALES </u></strong></font></div></td>
  </tr>
</table>

<br>
<table width="75%" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td width="52%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NUMERO 
      DE PROGRAMACION DE TAREA:</strong></font></td>
    <td width="48%" class="margin"><?php echo $row['IdProgTarea']; ?></td>
  </tr>
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Actividad:</font></strong></td>
    <td class="margin"><?php=$row["Actividad"]?></td>
  </tr>
  <tr>
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Fecha de Programacion:</font></strong></td>
    <td class="margin"><?php=$row["FechaDe"]?></td>
  </tr>
  <tr>
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Hora de Realizacion:</font></strong></td>
    <td class="margin"><?php=$row["HoraDe"]." - ".$row["HoraA"]?></td>
  </tr>
  <tr>
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Dia de Realizacion:</font></strong></td>
    <td class="margin"><?php=$row["Dia"]?></td>
  </tr>
  <tr>
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Observaciones:</font></strong></td>
    <td class="margin"><?php=$row["Observaciones"]?></td>
  </tr>
</table>
<br>
<table width="90%" border="1" align="center" cellpadding="2" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
    <td width="15%"><div align="center" class="style3"><font face="Arial, Helvetica, sans-serif">REALIZADO POR </font></div></td>
    <td width="10%"><div align="center" class="style3"><font face="Arial, Helvetica, sans-serif">FECHA / HORA</font></div></td>
    <td width="10%"><div align="center" class="style3"><font face="Arial, Helvetica, sans-serif">REALIZACION</font></div></td>
    <td width="13%"><div align="center" class="style3"><font face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></div></td>
    <td width="15%"><div align="center" class="style3"><font face="Arial, Helvetica, sans-serif">REVISADO POR </font></div></td>
    <td width="10%"><div align="center" class="style3"><font face="Arial, Helvetica, sans-serif">FECHA / HORA </font></div></td>
    <td width="10%"><div align="center" class="style3"><font face="Arial, Helvetica, sans-serif">APROBACION</font></div></td>
    <td width="15%"><div align="center" class="style3"><font face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></div></td>
  </tr>
  <?php
while($lstTarea=mysql_fetch_array($rs))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\" class=\"text\">&nbsp;".$lstUsuario[$lstTarea['RealizadoPor']]."</font></td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$lstTarea[FechaProceso] </font></td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$lstTarea[Realizacion]</font></td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$lstTarea[RealizadoPorObs]</font></td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;".$lstUsuario[$lstTarea['RevisadoPor']]."</font></td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;";if($lstTarea['Revisado']==1) print $lstTarea['RevisadoPorFecha']; print "</font></td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$lstTarea[Aprobacion]</font></td>";
	echo "<td align=\"center\" class=\"text\">&nbsp;$lstTarea[RevisadoPorObs]</font></td>";
	echo "</tr>";
}
?>
</table>
</body>
</html>