<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
require("conexion.php");
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

require_once("funciones.php");
if (valida("Calen_cont")=="bad") {header("location: pagina_error.php");}
//if ($IMPRIMIR){header("location: ver_calen_cont.php");}
if (isset($RETORNAR)){echo "<script type=\"text/javascript\">
           history.go(-2);
       </script>";}
if (isset($NueCalend)){ 	
	$sql5="SELECT MAX(id_cmant) AS Id FROM calen_contingencia";
	$result5=mysql_query($sql5);
	$row5=mysql_fetch_array($result5);
	$r=$row5[Id]+1; 
	header("location: calendariza_cont.php?varia=$r&varia1=$r");
}
include ("top.php");
?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="69" valign="top"> 
      <table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="8" background="windowsvista-assets1/main-button-tile.jpg" height="30">CALENDARIZACION DE CONTINGENCIA</th>
        </tr>
        <tr align=\"center\"> 
          <th width="2%" class="menu" background="images/main-button-tileR1.jpg" height="22">Nro</th>
          <th width="6%" class="menu" background="images/main-button-tileR1.jpg" height="22">ORD. TRABAJO</th>
          <th width="35%" class="menu" background="images/main-button-tileR1.jpg" height="22">INCIDENCIA</th>
          <th width="10%" class="menu" background="images/main-button-tileR1.jpg" height="22">ESTADO</th>
          <th width="10%" class="menu" background="images/main-button-tileR1.jpg" height="22">FECHA INICIO</th>
          <th width="10%" class="menu" background="images/main-button-tileR1.jpg" height="22">FECHA FINAL</th>
          <th width="12%" class="menu" background="images/main-button-tileR1.jpg" height="22">SEGUIMIENTO</th>
          <th width="10%" class="menu" width="2%" background="images/main-button-tileR1.jpg" height="22">IMPRIMIR</th>
        </tr>
        <?php
$fechahoy=date("Y-m-d");
$sql3 = "SELECT * FROM calen_contingencia GROUP BY TipoPru ASC ORDER BY id_cmant ASC, estado";
$result3=mysql_query($sql3);
while($row3=mysql_fetch_array($result3))
{
	$a=0; 
	$sql = "SELECT *, DATE_FORMAT(fecha_del, '%Y/%m/%d') AS fecha_del, DATE_FORMAT(fecha_al, '%Y/%m/%d') AS fecha_al  
			FROM calen_contingencia WHERE TipoPru='$row3[TipoPru]'"; //HERE
	$result=mysql_query($sql);
	while ($row=mysql_fetch_array($result)) {

		$sql2 = "SELECT * FROM calen_contingencia WHERE id_cmant='$row[id_cmant]' AND estado='Realizado' ";
		$result2=mysql_query($sql2);
		$row2=mysql_fetch_array($result2); 	
		if (!$row2['estado'])
		{	if ($row['fecha_al'] >= $fechahoy)   // VIGENTE
			{$color="bgcolor=\"#00CC00\"";}
			else if ($row['fecha_al'] < $fechahoy) // VENCIDO
			{$color="bgcolor=\"#FF6666\"";}
			echo "<tr align=\"center\">";
			echo "<td ".$color."><font size=\"1\">$row[id_cmant]</font></td>";
			echo "<td><font size=\"1\"><a href=\"calen_cont_resumen.php?TipoPru=".$row['TipoPru']."\">".$row['TipoPru']."</a></font></td>";
			$sql4 = "SELECT * FROM ordenes WHERE id_orden='$row[TipoPru]'";
			$result4=mysql_query($sql4);
			$row4=mysql_fetch_array($result4);
			echo '<td><font size="1">'.$row4['desc_inc'].'</td>';
			echo '<td><font size="1">'.$row['estado'].'</td>';
			echo '<td><font size="1">'.$row['fecha_del'].'</font></td>';  //HERE
			echo '<td><font size="1">'.$row['fecha_al'].'</font></td>';	
			echo "<td><font size=\"1\"><a href=\"calendariza_cont_last.php?id_cmant=".$row['id_cmant']."&TipoPru=".$row['TipoPru']."\">REALIZACION</a></font></td>";
			echo "<td><font size=\"1\"><a href=\"ver_calen_cont_resumen.php?TipoPru=".$row['TipoPru']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
			echo "</tr>";
			$a=$a+1;}
		}
		if($a=="0")
		{	$color="bgcolor=\"#FFFF00\"";	
			$sql4 = "SELECT MAX(id_cmant) AS ID FROM calen_contingencia WHERE TipoPru='$row3[TipoPru]'";
			$result4=mysql_query($sql4);
			$row4=mysql_fetch_array($result4); 
			$sql5 = "SELECT *, DATE_FORMAT(fecha_del, '%Y/%m/%d') AS fecha_del, DATE_FORMAT(fecha_al, '%Y/%m/%d') AS fecha_al
					 FROM calen_contingencia WHERE TipoPru='$row3[TipoPru]' AND id_cmant='$row4[ID]'"; //HERE
			$result5 = mysql_query($sql5);
			while ($row5 = mysql_fetch_array($result5)){ 	
			echo "<tr align=\"center\">";
			echo "<td ".$color."><font size=\"1\">$row5[id_cmant]</font></td>";
			echo '<td><font size="1"><a href="calen_cont_resumen.php?TipoPru='.$row5['TipoPru'].'">'.$row5['TipoPru'].'</a></font></td>';
			$sql4 = "SELECT * FROM ordenes WHERE id_orden='".$row5['TipoPru']."'";
			$result4=mysql_query($sql4);
			$row4=mysql_fetch_array($result4);
			echo '<td><font size="1">'.$row4['desc_inc'].'</td>';
			echo '<td><font size="1">'.$row5['estado'].'</td>';
			echo '<td><font size="1">'.$row5['fecha_del'].'</font></td>'; //HERE
			echo '<td><font size="1">'.$row5['fecha_al'].'</font></td>';	
			echo "<td><font size=\"1\">LLENADO</font></td>";
			echo "<td><font size=\"1\"><a href=\"ver_calen_cont_resumen.php?TipoPru=".$row5[TipoPru]."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";			
			echo "</tr>";}}
}
?>
      </table></td>
  </tr>
</table>
<br \>
<form name="form1" method="get" action="">
  <div align="center">
    <input name="NueCalend" type="submit" value="NUEVA PLANIFICACION">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="IMPRIMIR" value="IMPRIMIR REPORTE" onClick="return openPrint()">
  </div>
</form>
<table width="80%" border="1" align="center">
  <tr> 
    <td width="15%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">PLANIFICACION 
        VENCIDA </font></div></td>
    <td width="7%" bgcolor="#FF6666">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="18%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">PLANIFICACION 
        VIGENTE</font></div></td>
    <td width="8%" bgcolor="#00CC00">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="23%"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">REALIZACION 
        Y PLANIFICACION CULMINADA</font></div></td>
    <td width="6%" bgcolor="#FFFF00">&nbsp;</td>
  </tr>
</table>
<script language="JavaScript">
<!--
function openPrint() {
	window.open("contingencia_estadistica.php",'Estadìsticas', 'width=590,height=140,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
	return false;
}
-->
</script>
