<?php
// Objetivo:	Optimización de consulta SQL, para listado de ordenes de trabajo
//				Modificación de metodo de envio de datos (a POST)
//				Mejora en Filtro de Busqueda -Area-Usuario
//				Validacion para Inyeccion SQL.
// Autor:		Alvaro Rodriguez
// Fecha:		08/junio/2013
// Desc:		
//________________________________________________________________________________
//header('content-type text/html charset=iso-8859-1');
@session_start();
require('../conexion.php');
require ('../funciones.php');
header('Content-Type: text/html; charset=iso-8859-1');
$fechahoy = date('Y-m-d');
echo '<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top">
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th background="images/main-button-tileR1.jpg" colspan="11">LISTA DE SOLICITUD DE PROYECTOS</th>
        </tr>
        <tr align=\"center\"> 
		  <th class="menu" background="images/main-button-tileR2.jpg" rowspan="2" width="3%">COD</th>
  		  <th class="menu" background="images/main-button-tileR2.jpg" rowspan="2">REQUERIMIENTO</th>
		  <th class="menu" background="images/main-button-tileR2.jpg" rowspan="2" width="20%">LIDER DEL PROYECTO</th>
 		  <th class="menu" background="images/main-button-tileR2.jpg" rowspan="2">DESCRIPCION DEL PROYECTO</th>
  		  <th class="menu" background="images/main-button-tileR2.jpg" rowspan="2">FECHA SOLICITADA</th>
  		  <th class="menu" background="images/main-button-tileR2.jpg" colspan="4">FASES DEL PROYECTO</th>';
            if ($_SESSION['tipo']=="A" or $_SESSION['tipo']=="B") {
  		  echo '<th class="menu" background="images/main-button-tileR2.jpg" rowspan="2">MODIFICAR</th>';
			 }
  		  echo '<th class="menu" background="images/main-button-tileR2.jpg" rowspan="2">IMPRIMIR</th>
		  </tr>
		  <tr align="center">
		  <th class="menu" background="images/main-button-tileR2.jpg">PLANIFICACION</th>
  		  <th class="menu" background="images/main-button-tileR2.jpg">EJECUCION</th>
  		  <th class="menu" background="images/main-button-tileR2.jpg" >CONTROL</th>
  		  <th class="menu" background="images/main-button-tileR2.jpg">CIERRE</th>
		  </tr>';

$sql = "SELECT *, DATE_FORMAT(FechSolic, '%d/%m/%Y') AS FechSolic FROM solicproydatos ORDER BY Codigo";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) 
{
  	echo "<tr align=\"center\">";
	echo '<td><font size="1">&nbsp;'.$row['Codigo'].'</font></td>';
	echo "<td><font size=\"1\">&nbsp;$row[Requerimiento]</font></td>";
	$sql2 = "SELECT * FROM users WHERE login_usr='$row[LiderProyecto]'";
	$result2 = mysql_query($sql2);
	$row2 = mysql_fetch_array($result2); 
	echo "<td align=\"center\"><font size=\"1\">&nbsp;$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[DescProyecto]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[FechSolic]</font></td>";
		
	$sql3 = "SELECT * FROM solicproyplanif WHERE Codigo='".$row['Codigo']."' GROUP BY Codigo";
    $result3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($result3);
	if (!$row3['Codigo'])
	{	echo "<td><font size=\"1\">&nbsp;<a href=\"solicproyecto3.php?Codigo=".$row['Codigo']."\">PLANIFICACION</a></font></td>";
		echo "<td><font size=\"1\">&nbsp;ANTES PLANIFIQUE</font></td>";
		echo "<td><font size=\"1\">&nbsp;ANTES PLANIFIQUE</font></td>";
		echo "<td><font size=\"1\">&nbsp;ANTES PLANIFIQUE</font></td>";}
	else
	{	echo "<td><font size=\"1\">PLANIFICADO</font></td>";	
		$sql4 = "SELECT * FROM solicproyejecucion WHERE Codigo='".$row['Codigo']."' GROUP BY Codigo";
	    $result4 = mysql_query($sql4);
		$row4 = mysql_fetch_array($result4);
		if (!$row4['Codigo'])
		{	echo "<td><font size=\"1\">&nbsp;<a href=\"solicproyecto4.php?Codigo=".$row['Codigo']."\">EJECUCION</a></font></td>";
			echo "<td><font size=\"1\">&nbsp;ANTES EJECUTE</font></td>";
			echo "<td><font size=\"1\">&nbsp;ANTES EJECUTE</font></td>";}
		else	
		{	echo "<td><font size=\"1\">EJECUTADO</font></td>";	
			$sql5 = "SELECT * FROM solicproycontrol WHERE Codigo='".$row['Codigo']."' GROUP BY Codigo";
		    $result5 = mysql_query($sql5);
			$row5 = mysql_fetch_array($result5);
			if (!$row5['Codigo'])
			{	echo "<td><font size=\"1\">&nbsp;<a href=\"solicproyecto5.php?Codigo=".$row['Codigo']."\">CONTROL</a></font></td>";
				echo "<td><font size=\"1\">&nbsp;ANTES CONTROLE</font></td>";}
			else 
			{	echo "<td><font size=\"1\">CONTROLADO</font></td>";	
				$sql6 = "SELECT * FROM solicproycierre WHERE Codigo='".$row['Codigo']."' GROUP BY Codigo";
			    $result6 = mysql_query($sql6);
				$row6 = mysql_fetch_array($result6);	
				if (!$row6['Codigo'])
				{	echo "<td><font size=\"1\">&nbsp;<a href=\"solicproyecto6.php?Codigo=".$row['Codigo']."\">CIERRE</a></font></td>";}
				else
				{	echo "<td><font size=\"1\">CIERRE</font></td>";}
			}	
		}	
	}	
        echo $_SESSION['tipo'];
if ($_SESSION['tipo']=="A" or $_SESSION['tipo']=="B")
{echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"solicproyecto1_last.php?Codigo=".$row['Codigo']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";}
echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\"><a href=\"ver_solicproydatos.php?variable=".$row['Codigo']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
}
echo "</tr>";
      echo '</table></td>
  </tr>
</table>';
?>