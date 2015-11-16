<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		17/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		15/AGO/2012
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
header('Content-Type: text/html; charset=iso-8859-1');
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require_once("funciones.php");
if (valida("Produccion")=="bad") {header("location: pagina_error.php");}
if (isset($RETORNAR))
{
	echo "<script type=\"text/javascript\">
           history.go(-2);
       </script>";
}
include ("top.php"); 
?>
<table  width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td valign="top">
	<table width="100%"  border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="7" background="images/main-button-tileR1.jpg" height="23">PROBLEMAS PRODUCCION - REVISION DEL DIA SIGUIENTE</th>
        </tr>
        <tr align="center"> 
		<th width="3%" class="menu" background="images/main-button-tileR2.jpg" height="23"><?php print $help->AddLink("num", "Nro. ORD"); ?></th>
		<th width="18%" class="menu" background="images/main-button-tileR2.jpg" height="23">FECHA Y HORA</th>
		<th width="39%" class="menu" background="images/main-button-tileR2.jpg" height="23">DESCRIPCION</th>
		<th width="11%" class="menu" background="images/main-button-tileR2.jpg" height="23">LLENAR DATOS</th>
		<?php if (isset($tipo) && ($tipo=="A" or $tipo=="B")) {?>
		<th width="8%" class="menu" background="images/main-button-tileR2.jpg" height="23">MODIFICAR</th> <?php }?>
		<th width="10%" class="menu" background="images/main-button-tileR2.jpg" height="23">IMPRIMIR</th>
		<?php if (isset($tipo) && ($tipo=="A" or $tipo=="B" or $tipo=="T")) {?>
		<th class="menu" width="10%" background="images/main-button-tileR2.jpg" height="23">ADJUNTAR ARCHIVOS</th>
		<?php }?>
		</tr>
        <?php
$sql6 = "SELECT id_orden FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";
$result6=mysql_query($sql6);
while($row6=mysql_fetch_array($result6))
{
	$sql0 = "SELECT * FROM asignacion WHERE id_orden='".$row6['id_orden']."' ORDER BY id_asig DESC limit 1";
	$result0=mysql_query($sql0);
	$row0=mysql_fetch_array($result0);
	if ($row0['area']=='Problemas'){
		$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes WHERE id_orden='$row0[id_orden]' ORDER BY id_orden DESC";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
		
		$fechahora=$row['fecha'].' - '.$row['time'];
		echo '<tr align="center">';
		echo "<td><font size=\"1\"><a href=\"ver_orden.php?id_orden=".$row['id_orden']."\" target=\"_blank\">$row[id_orden]</a></td>";
		echo "<td><font size=\"1\">$fechahora</td>";
		echo "<td><font size=\"1\">$row[desc_inc]</font></td>";
	
		$sp = "select *from problemas where probIdOrden='$row[id_orden]'";
		$rp = mysql_query( $sp);
		$rwp = mysql_fetch_array($rp);
		
		$sql0_1 = "SELECT * FROM revision WHERE id_orden='$row[id_orden]'";
		$result0_1=mysql_query($sql0_1);
		$row0_1=mysql_fetch_array($result0_1);
	    if (!$row0_1['id_orden'])
		{
			if($row0['asig']==$login OR $row0['escal']==$login OR $tipo=="A")
			{echo "<td><font size=\"1\"><a href=\"revisionds.php?id_orden=".$row['id_orden']."\">LLENAR</a></font></td>";}
			else
			{echo "<td><font size=\"1\">POR LLENAR</font></td>";}
			
			if ($tipo=="A" or $tipo=="B")
			{ echo "<td><font size=\"1\">MODIFICAR</font></td>";}
			echo "<td><font size=\"1\">IMPRIMIR</font></td>";
			
			if ($tipo=="A" or $tipo=="B" or $tipo=="T"){ 
				if($row0['asig']==$login OR $tipo=="A"){
					if ($rwp['probArchivos']==""){echo "<td><a href=\"adjuntar_prob.php?num=$row[id_orden]\">ADJUNTAR</a></td>";}
					else {echo "<td><a href=\"adjuntar_prob.php?num=$row[id_orden]\">ADJUNTADOS</a></td>";}
				}else{echo "<td>POR ADJUNTAR</td>";}
			}
		}
		else{
			 echo "<td><font size=\"1\">LLENADO</font></td>";	
			 if ($tipo=="A" or $tipo=="B"){
				echo "<td><font size=\"1\"><a href=\"revisionds_last.php?id_orden=".$row['id_orden']."\"><img src=\"images/editar.gif\" 	
				border=\"0\" alt=\"Modificar\"></a></font></td>";
			 }
			 echo "<td><font size=\"1\"><a href=\"ver_ordenrev.php?variable=".$row['id_orden']."\" target=\"_blank\"><img 	
			 src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";
			 
			 if ($tipo=="A" or $tipo=="B" or $tipo=="T")
			{ 
				if($row0['asig']==$login OR $tipo=="A")
				{	if ($rwp['probArchivos']==""){
						echo '<td><a href="adjuntar_prob.php?num='.$row['id_orden'].'">ADJUNTAR</a></td>';
					}
					else {
						echo '<td><a href="adjuntar_prob.php?num='.$row['id_orden'].'">ADJUNTADOS</a></td>';
					}
				}else{echo "<td>POR ADJUNTAR</td>";}
			}
			 
		}
   }
}
echo "</tr>";
?>
      </table></td>
  </tr>
</table>
<form name="form1" method="post" action="">
  <div align="center">
    <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    <input name="IMPRIMIR" type="button" id="IMPRIMIR" value="IMPRIMIR" onClick="imprime()">
  </div>
</form>    
<script>
function imprime() 
{	
	window.open("ver_ordenrev_pre.php",'Impresion', 'width=610,height=240,status=yes,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
 </script>