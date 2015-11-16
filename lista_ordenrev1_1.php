<?php 
require_once("funciones.php");
if (valida("Produccion")=="bad") {header("location: pagina_error.php");}
if ($RETORNAR){header("location: lista_ordenrev.php?Naveg=Problemas");}
include ("top.php"); ?>
<?php 
	include_once ("help.class.php");
	$help=new Help();
	$help->AddHelp("num","Numero de Orden de Mesa");
	print $help->ToHtml();
 ?>
<table  width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td valign="top"><table width="100%"  border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
		  <th colspan="6">REVISION DEL DIA SIGUIENTE DE ORDENES DE TRABAJO </th>
		</tr>
        <tr align=\"center\"> 
    	<th width="3%" class="menu"><?php print $help->AddLink("num", "N°ORDEN"); ?></th>
      	<th width="21%" class="menu">FECHA Y HORA</th>      	
		  <th width="36%" class="menu">DESCRIPCION</th>
      	<th width="11%" class="menu">LLENAR DATOS</th>
		<?php if ($tipo=="A" or $tipo=="B") {?>
      	<th width="8%" class="menu">MODIFICAR</th><?php }?>
     	<th width="10%" class="menu">IMPRIMIR</th>
        </tr>
        <?php
$sql6 = "SELECT id_orden FROM asignacion GROUP BY id_orden ORDER BY id_orden DESC";
$result6=mysql_db_query($db,$sql6,$link);
while($row6=mysql_fetch_array($result6))
{
	$sql0 = "SELECT * FROM asignacion WHERE id_orden='$row6[id_orden]' ORDER BY id_asig DESC limit 1";
	$result0=mysql_db_query($db,$sql0,$link);
	$row0=mysql_fetch_array($result0);
	if ($row0[area]=='Problemas')
	{
	$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM ordenes WHERE id_orden='$row0[id_orden]' ORDER BY id_orden DESC";
	$result=mysql_db_query($db,$sql,$link);
	$row=mysql_fetch_array($result);

	$fechahora="$row[fecha] - $row[time]";

  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">$row[id_orden]</td>";
	echo "<td><font size=\"1\">$fechahora</td>";
	echo "<td><font size=\"1\">$row[desc_inc]</font></td>";

	$sql0 = "SELECT * FROM revision WHERE id_orden='$row[id_orden]'";
	$result0=mysql_db_query($db,$sql0,$link);
	$row0=mysql_fetch_array($result0);
	
	
	if (!$row0[id_orden])
	{echo "<td><font size=\"1\"><a href=\"revisionds1.php?id_orden=".$row[id_orden]."\">LLENAR</a></font></td>";
	if ($tipo=="A" or $tipo=="B") {echo "<td><font size=\"1\">MODIFICAR</font></td>";}
	echo "<td><font size=\"1\">IMPRIMIR</font></td>";
	}
	else
	{
	echo "<td><font size=\"1\">LLENADO</font></td>";	
	if ($tipo=="A" or $tipo=="B") {echo "<td><font size=\"1\"><a href=\"revisionds1_last.php?id_orden=".$row[id_orden]."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Imprimir\"></a></font></td>";}
	echo "<td><font size=\"1\"><a href=\"ver_ordenrev.php?variable=".$row[id_orden]."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Modificar\"></a></font></td>";
	}
}}
echo "</tr>";
?>
      </table></td>
  </tr>
</table>
<form name="form1" method="post" action="">
  <div align="center">
    <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
  </div>
</form>    
 <?php include("top_.php");?> 